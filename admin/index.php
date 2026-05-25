<?php
session_start();
require_once '../config/db.php';

define('ADMIN_PASS', 'Lucastav8012@');

$error = '';
$msg   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['login'])) {
        if ($_POST['senha'] === ADMIN_PASS) {
            $_SESSION['admin'] = true;
        } else {
            $error = 'Senha incorreta.';
        }
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['novo_doc']) && !empty($_SESSION['admin'])) {
        try {
            $db = getDB();
            $codigo = strtoupper(substr(bin2hex(random_bytes(9)), 0, 18));

            $stmt = $db->prepare("INSERT INTO documentos
                (codigo, tipo, tratamento, paciente, unidade, endereco, medico, especialidade,
                 crm_estado, crm_numero, cns, data_atend, quadro, tipo_afast, dias_afast,
                 data_afast, recomendacoes, cid, cidade, observacoes)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->execute([
                $codigo,
                trim($_POST['tipo']         ?? 'Atestado Médico'),
                trim($_POST['tratamento']   ?? 'Sr.'),
                trim($_POST['paciente']     ?? ''),
                trim($_POST['unidade']      ?? ''),
                trim($_POST['endereco']     ?? ''),
                trim($_POST['medico']       ?? ''),
                trim($_POST['especialidade']?? ''),
                trim($_POST['crm_estado']   ?? ''),
                trim($_POST['crm_numero']   ?? ''),
                trim($_POST['cns']          ?? ''),
                trim($_POST['data_atend']   ?? date('Y-m-d')),
                trim($_POST['quadro']       ?? ''),
                trim($_POST['tipo_afast']   ?? 'dia'),
                (int)($_POST['dias_afast']  ?? 1),
                !empty($_POST['data_afast']) ? trim($_POST['data_afast']) : null,
                trim($_POST['recomendacoes']?? ''),
                strtoupper(trim($_POST['cid'] ?? '')),
                trim($_POST['cidade']       ?? ''),
                trim($_POST['observacoes']  ?? ''),
            ]);
            $msg = $codigo;
        } catch (PDOException $e) {
            $error = 'Erro ao salvar: ' . $e->getMessage();
        }
    }

    if (isset($_POST['cancelar_doc']) && !empty($_SESSION['admin'])) {
        try {
            $db = getDB();
            $db->prepare("UPDATE documentos SET status='cancelado' WHERE id=?")->execute([(int)$_POST['doc_id']]);
        } catch (PDOException $e) {}
        header('Location: index.php');
        exit;
    }
}

$docs = [];
if (!empty($_SESSION['admin'])) {
    try {
        $db   = getDB();
        $docs = $db->query("SELECT * FROM documentos ORDER BY created_at DESC LIMIT 100")->fetchAll();
    } catch (PDOException $e) {
        $error = 'Erro DB: ' . $e->getMessage();
    }
}

$today = date('Y-m-d');
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Admin — VerificaMed</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/qrcode@1.5.3/build/qrcode.min.js"></script>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:#f4f7ff;color:#111827;min-height:100vh;}
.topbar{background:#1e3a6e;color:#fff;padding:.875rem 2rem;display:flex;align-items:center;justify-content:space-between;}
.topbar-title{font-size:1.125rem;font-weight:700;}
.topbar-sub{font-size:.75rem;color:rgba(255,255,255,.6);margin-top:.1rem;}
.content{max-width:1200px;margin:0 auto;padding:2rem 1.5rem;}
.card{background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);}
.card-title{font-size:1rem;font-weight:700;color:#111827;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid #f0f0f0;}
label{font-size:.8125rem;font-weight:600;color:#374151;display:block;margin-bottom:.25rem;}
input,select,textarea{width:100%;border:1px solid #d1daf0;border-radius:.5rem;padding:.625rem .875rem;font-size:.875rem;color:#111827;background:#f8faff;outline:none;font-family:inherit;}
input:focus,select:focus,textarea:focus{border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1);background:#fff;}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.grid3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;}
.span2{grid-column:span 2;}
.btn{display:inline-flex;align-items:center;gap:.4rem;font-weight:600;font-size:.875rem;padding:.65rem 1.25rem;border-radius:.5rem;border:none;cursor:pointer;transition:background .15s;}
.btn-primary{background:#2563eb;color:#fff;}
.btn-primary:hover{background:#1d4ed8;}
.btn-danger{background:#fee2e2;color:#dc2626;}
.btn-danger:hover{background:#fecaca;}
.btn-gray{background:#f3f4f6;color:#374151;}
.btn-gray:hover{background:#e5e7eb;}
.badge{display:inline-block;font-size:.7rem;font-weight:600;padding:.2rem .6rem;border-radius:99px;}
.badge-ativo{background:#dcfce7;color:#15803d;}
.badge-cancelado{background:#fee2e2;color:#dc2626;}
table{width:100%;border-collapse:collapse;font-size:.8125rem;}
th{text-align:left;font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:#9ca3af;font-weight:600;padding:.5rem .75rem;border-bottom:1px solid #f0f0f0;}
td{padding:.75rem;border-bottom:1px solid #f9fafb;vertical-align:middle;}
tr:last-child td{border-bottom:none;}
tr:hover td{background:#fafbff;}
.login-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f4f7ff;}
.qr-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;}
.qr-modal.open{display:flex;}
.qr-box{background:#fff;border-radius:1rem;padding:2rem;text-align:center;max-width:320px;width:90%;}
.msg-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;padding:.75rem 1rem;border-radius:.625rem;font-size:.875rem;font-weight:600;margin-bottom:1.5rem;}
.msg-error{background:#fff1f2;border:1px solid #fecdd3;color:#be123c;padding:.75rem 1rem;border-radius:.625rem;font-size:.875rem;font-weight:600;margin-bottom:1.5rem;}
</style>
</head>
<body>

<?php if (empty($_SESSION['admin'])): ?>
<!-- LOGIN -->
<div class="login-wrap">
  <div class="card" style="width:100%;max-width:360px;">
    <div style="text-align:center;margin-bottom:1.5rem;">
      <div style="font-size:1.5rem;font-weight:800;color:#1e3a6e;">VerificaMed</div>
      <div style="font-size:.8125rem;color:#6b7280;margin-top:.25rem;">Painel Administrativo</div>
    </div>
    <?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
      <div style="margin-bottom:1rem;">
        <label>Senha de acesso</label>
        <input type="password" name="senha" placeholder="••••••••" required autofocus/>
      </div>
      <button type="submit" name="login" class="btn btn-primary" style="width:100%;justify-content:center;">Entrar</button>
    </form>
  </div>
</div>

<?php else: ?>
<!-- DASHBOARD -->
<div class="topbar">
  <div>
    <div class="topbar-title">VerificaMed Admin</div>
    <div class="topbar-sub">Gerenciamento de documentos</div>
  </div>
  <form method="POST" style="display:inline;">
    <button type="submit" name="logout" class="btn btn-gray" style="font-size:.8125rem;">Sair</button>
  </form>
</div>

<div class="content">

  <?php if ($error): ?><div class="msg-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if ($msg): ?>
  <div class="msg-success">
    ✅ Documento cadastrado! Código: <strong style="font-family:monospace;"><?= htmlspecialchars($msg) ?></strong>
    &nbsp;<button onclick="showQR('<?= htmlspecialchars($msg) ?>')" class="btn btn-gray" style="font-size:.75rem;padding:.3rem .75rem;">Ver QR Code</button>
  </div>
  <?php endif; ?>

  <!-- FORM NOVO DOCUMENTO -->
  <div class="card" style="margin-bottom:2rem;">
    <div class="card-title">➕ Cadastrar novo documento</div>
    <form method="POST">
      <div class="grid3" style="margin-bottom:1rem;">
        <div>
          <label>Tipo</label>
          <select name="tipo">
            <option>Atestado Médico</option>
            <option>Receita Médica</option>
            <option>Declaração</option>
          </select>
        </div>
        <div>
          <label>Tratamento</label>
          <select name="tratamento">
            <option>Sr.</option><option>Sra.</option><option>Dr.</option><option>Dra.</option>
          </select>
        </div>
        <div>
          <label>Nome do paciente *</label>
          <input name="paciente" placeholder="Nome completo" required/>
        </div>
      </div>
      <div class="grid2" style="margin-bottom:1rem;">
        <div class="span2">
          <label>Unidade / Estabelecimento *</label>
          <input name="unidade" placeholder="ex: UPA 24h" required/>
        </div>
        <div class="span2">
          <label>Endereço da unidade</label>
          <input name="endereco" placeholder="Av. Principal, 100 - Bairro - Cidade/UF"/>
        </div>
      </div>
      <div class="grid3" style="margin-bottom:1rem;">
        <div>
          <label>Nome do médico *</label>
          <input name="medico" value="Alice Nobre de Moura Filho" required/>
        </div>
        <div>
          <label>Especialidade</label>
          <input name="especialidade" value="Médico Clínico Geral"/>
        </div>
        <div style="display:grid;grid-template-columns:80px 1fr;gap:.5rem;">
          <div>
            <label>Estado CRM</label>
            <select name="crm_estado">
              <?php foreach(['AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO'] as $uf): ?>
              <option value="<?=$uf?>" <?=$uf==='PI'?'selected':''?>><?=$uf?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label>Nº CRM *</label>
            <input name="crm_numero" value="14927" required/>
          </div>
        </div>
      </div>
      <div class="grid3" style="margin-bottom:1rem;">
        <div>
          <label>CNS</label>
          <input name="cns" value="702302133658716"/>
        </div>
        <div>
          <label>Data do atendimento *</label>
          <input type="date" name="data_atend" value="<?= $today ?>" required/>
        </div>
      </div>
      <!-- QUADRO PRE-DEFINIDO -->
      <div style="margin-bottom:1rem;">
        <label>Quadro clínico pré-definido <span style="font-weight:400;color:#9ca3af;">(opcional — preenche os campos abaixo automaticamente)</span></label>
        <select id="sel-quadro" onchange="preencherQuadro(this.value)" style="width:100%;border:1px solid #d1daf0;border-radius:.5rem;padding:.625rem .875rem;font-size:.875rem;background:#f8faff;color:#374151;">
          <option value="">— Selecione um quadro clínico —</option>
          <optgroup label="🤷 Infectológico / Respiratório">
            <option value="gripal">Síndrome gripal (Gripe) — J11</option>
            <option value="resfriado">Resfriado comum (Rinofaringite) — J00</option>
            <option value="faringite">Faringite aguda — J02.9</option>
            <option value="amigdalite">Amigdalite aguda — J03.9</option>
            <option value="sinusite">Sinusite aguda — J01.9</option>
            <option value="bronquite">Bronquite aguda — J20.9</option>
            <option value="pneumonia">Pneumonia — J18.9</option>
            <option value="covid">COVID-19 — U07.1</option>
            <option value="otite">Otite média aguda — H66.0</option>
            <option value="conjuntivite">Conjuntivite aguda — H10.9</option>
          </optgroup>
          <optgroup label="🪴 Gastrointestinal">
            <option value="gastroenterite">Gastroenterite aguda — A09</option>
            <option value="gastrite">Gastrite aguda — K29.1</option>
            <option value="dor_abd">Dor abdominal — R10.4</option>
            <option value="diarreia">Diarréia aguda — A09</option>
            <option value="nausea">Náusea e vômito — R11</option>
            <option value="colica">Cólica abdominal — R10.4</option>
          </optgroup>
          <optgroup label="🦴 Osteomuscular / Dor">
            <option value="lombalgia">Lombalgia (dor lombar) — M54.5</option>
            <option value="dorsalgia">Dorsalgia — M54.9</option>
            <option value="cervicalgia">Cervicalgia — M54.2</option>
            <option value="tendinite">Tendinite — M77.9</option>
            <option value="contusao">Contusão / trauma — T14.0</option>
            <option value="cefaleia">Cefaleia tensional — R51</option>
            <option value="enxaqueca">Enxaqueca — G43.9</option>
          </optgroup>
          <optgroup label="🧠 Neurológico / Psiquiátrico">
            <option value="ansiedade">Transtorno de ansiedade — F41.9</option>
            <option value="depressao">Episódio depressivo — F32.9</option>
            <option value="insonia">Insônia — G47.0</option>
            <option value="tontura">Tontura e vertigem — R42</option>
            <option value="sincope">Síncope e lipotímia — R55</option>
          </optgroup>
          <optgroup label="❤️ Cardiovascular / Metabólico">
            <option value="has">Hipertensão arterial descompensada — I10</option>
            <option value="dm">Diabetes mellitus descompensada — E11.9</option>
            <option value="palpitacao">Palpitções / taquicardia — R00.0</option>
          </optgroup>
          <optgroup label="🫁 Urológico / Ginecológico">
            <option value="itu">Infecção do trato urinário — N39.0</option>
            <option value="colica_renal">Cólica renal — N23</option>
            <option value="dismenorreia">Dismenorreia — N94.6</option>
          </optgroup>
          <optgroup label="🦱 Dermatológico">
            <option value="dermatite">Dermatite — L30.9</option>
            <option value="urticaria">Urticária — L50.9</option>
            <option value="herpes">Herpes zoster — B02.9</option>
            <option value="varicela">Varicela (Catapora) — B01.9</option>
          </optgroup>
          <optgroup label="🔍 Geral / Outros">
            <option value="mal_estar">Mal-estar geral e febre — R53</option>
            <option value="febre">Febre sem causa determinada — R50.9</option>
            <option value="astenia">Astenia / fadiga — R53.1</option>
            <option value="hipoglicemia">Hipoglicemia — E16.0</option>
            <option value="alergica">Reação alérgica — T78.4</option>
          </optgroup>
        </select>
      </div>
      <div class="grid2" style="margin-bottom:1rem;">
        <div>
          <label>Quadro clínico / sintomas *</label>
          <textarea id="campo-quadro" name="quadro" rows="3" style="resize:vertical;" required></textarea>
        </div>
        <div style="display:flex;flex-direction:column;gap:1rem;">
          <div>
            <label>CID</label>
            <input id="campo-cid" name="cid" placeholder="ex: J11"/>
          </div>
          <div>
            <label>Recomendações *</label>
            <textarea id="campo-rec" name="recomendacoes" rows="3" style="resize:vertical;" required></textarea>
          </div>
        </div>
      </div>
      <div class="grid3" style="margin-bottom:1rem;">
        <div>
          <label>Tipo de afastamento</label>
          <select name="tipo_afast" onchange="this.form.querySelector('#dias-row').style.display=this.value==='periodo'?'flex':'none'">
            <option value="dia">Só no dia</option>
            <option value="periodo">Por período</option>
          </select>
        </div>
        <div id="dias-row" style="display:none;gap:.5rem;">
          <div style="flex:1;"><label>Nº dias</label><input type="number" name="dias_afast" min="1" value="1"/></div>
          <div style="flex:1;"><label>A partir de</label><input type="date" name="data_afast" value="<?= $today ?>"/></div>
        </div>
        <div>
          <label>Cidade</label>
          <input name="cidade" placeholder="ex: Teresina"/>
        </div>
      </div>
      <div style="margin-bottom:1rem;">
        <label>Observações</label>
        <textarea name="observacoes" rows="2" style="resize:vertical;"></textarea>
      </div>
      <button type="submit" name="novo_doc" class="btn btn-primary">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Cadastrar e gerar código
      </button>
    </form>
  </div>

  <!-- LISTA DE DOCUMENTOS -->
  <div class="card">
    <div class="card-title">📋 Documentos cadastrados (<?= count($docs) ?>)</div>
    <?php if (empty($docs)): ?>
    <p style="color:#9ca3af;font-size:.875rem;">Nenhum documento cadastrado ainda.</p>
    <?php else: ?>
    <div style="overflow-x:auto;">
    <table>
      <thead>
        <tr>
          <th>Código</th><th>Tipo</th><th>Paciente</th><th>Médico</th>
          <th>Data</th><th>Status</th><th>QR</th><th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($docs as $d): ?>
        <tr>
          <td><span style="font-family:monospace;font-size:.75rem;background:#f4f7ff;padding:.2rem .5rem;border-radius:.3rem;"><?= htmlspecialchars($d['codigo']) ?></span></td>
          <td><?= htmlspecialchars($d['tipo']) ?></td>
          <td><?= htmlspecialchars($d['tratamento'].' '.$d['paciente']) ?></td>
          <td><?= htmlspecialchars($d['medico']) ?></td>
          <td><?= date('d/m/Y', strtotime($d['data_atend'])) ?></td>
          <td><span class="badge badge-<?= $d['status'] ?>"><?= $d['status'] ?></span></td>
          <td>
            <button onclick="showQR('<?= htmlspecialchars($d['codigo']) ?>')" class="btn btn-gray" style="font-size:.75rem;padding:.3rem .75rem;">QR</button>
          </td>
          <td>
            <?php if ($d['status'] === 'ativo'): ?>
            <form method="POST" onsubmit="return confirm('Cancelar este documento?')">
              <input type="hidden" name="doc_id" value="<?= $d['id'] ?>"/>
              <button type="submit" name="cancelar_doc" class="btn btn-danger" style="font-size:.75rem;padding:.3rem .75rem;">Cancelar</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php endif; ?>
  </div>

</div>

<!-- QR CODE MODAL -->
<div class="qr-modal" id="qr-modal" onclick="if(event.target===this)closeQR()">
  <div class="qr-box">
    <div style="font-size:.9375rem;font-weight:700;color:#111827;margin-bottom:1rem;">QR Code do Documento</div>
    <canvas id="qr-canvas" style="display:block;margin:0 auto;border-radius:.5rem;"></canvas>
    <div id="qr-code-text" style="font-family:monospace;font-size:.75rem;color:#6b7280;margin-top:.5rem;word-break:break-all;"></div>
    <div style="display:flex;gap:.75rem;justify-content:center;margin-top:1.25rem;">
      <button onclick="downloadQR()" class="btn btn-primary" style="font-size:.8125rem;">⬇ Baixar PNG</button>
      <button onclick="closeQR()" class="btn btn-gray" style="font-size:.8125rem;">Fechar</button>
    </div>
  </div>
</div>

<script>
var QUADROS = {
  gripal:       { q:'síndrome gripal, acompanhada de febre, cefaleia, mialgia, dores no corpo e mal-estar geral', c:'J11', r:'repouso, hidratação adequada, uso de antipiréticos e acompanhamento dos sintomas para adequada recuperação do quadro clínico' },
  resfriado:    { q:'rinofaringite aguda, com congestão nasal, coriza, espirros e leve mal-estar', c:'J00', r:'repouso, hidratação, uso de descongestionante nasal e lavagem nasal com soro fisiológico' },
  faringite:    { q:'faringite aguda com odinofagia, hiperemia de orofaringe, febre e mal-estar', c:'J02.9', r:'repouso, hidratação, uso de analgésico/antipirético conforme prescrição e antibioticoterapia se indicado' },
  amigdalite:   { q:'amigdalite aguda com odinofagia intensa, febre, hiperemia e exsudato tonsilar', c:'J03.9', r:'repouso, hidratação, dieta pastosa e antibioticoterapia conforme prescrição médica' },
  sinusite:     { q:'sinusite aguda com cefaleia, pressão facial, congestão nasal e secreção purulenta', c:'J01.9', r:'repouso, hidratação, lavagem nasal, uso de descongestionante e antibioticoterapia conforme prescrição' },
  bronquite:    { q:'bronquite aguda com tosse produtiva, dispneia leve, congestão das vias aéreas superiores e mal-estar', c:'J20.9', r:'repouso, hidratação, uso de broncodilatador e expectorante conforme prescrição médica' },
  pneumonia:    { q:'pneumonia com febre alta, tosse produtiva, dispneia e dor torácica', c:'J18.9', r:'repouso absoluto, hidratação, antibioticoterapia e acompanhamento médico rigoroso' },
  covid:        { q:'infecção pelo SARS-CoV-2 (COVID-19) com febre, tosse seca, dispneia, anosmia e mal-estar geral', c:'U07.1', r:'isolamento doméstico, repouso, hidratação, monitoramento da saturação e acompanhamento médico' },
  otite:        { q:'otite média aguda com otalgia, febre, hiperemia de membrana timpânica e hipoacusia', c:'H66.0', r:'repouso, analgésico/antipirético e antibioticoterapia conforme prescrição médica' },
  conjuntivite: { q:'conjuntivite aguda com hiperemia, secreção ocular, lacrimejamento e fotofobia', c:'H10.9', r:'repouso, higiene ocular com soro fisiológico, colírio conforme prescrição e evitar contato com outras pessoas' },
  gastroenterite:{ q:'gastroenterite aguda com náuseas, vômitos, diarreia e cólicas abdominais', c:'A09', r:'repouso, hidratação oral com solução de reidratação, dieta leve e uso de medicamentos conforme prescrição' },
  gastrite:     { q:'gastrite aguda com epigastralgia, náuseas, vômitos e desconforto abdominal', c:'K29.1', r:'repouso, dieta leve e sem irritantes gástricos, uso de antiemético e protetor gástrico conforme prescrição' },
  dor_abd:      { q:'dor abdominal aguda de moderada intensidade, com desconforto difuso e náuseas', c:'R10.4', r:'repouso, dieta leve, hidratação e uso de analgésico conforme prescrição médica' },
  diarreia:     { q:'diarreia aguda com evacuações líquidas frequentes, cólicas e indisposição', c:'A09', r:'repouso, reidratação oral, dieta BRAT (banana, arroz, maçã e torrada) e medicamentos conforme prescrição' },
  nausea:       { q:'náuseas e vômitos recorrentes com indisposição geral e prostração', c:'R11', r:'repouso, hidratação fracionada, dieta leve e uso de antiemético conforme prescrição médica' },
  colica:       { q:'cólica abdominal aguda com dor em cólica de moderada intensidade e distenção abdominal', c:'R10.4', r:'repouso, hidratação, dieta leve, antiespasmódico e acompanhamento médico' },
  lombalgia:    { q:'lombalgia aguda com dor intensa na região lombar, limitando movimentação e atividades físicas', c:'M54.5', r:'repouso relativo, uso de analgésico e anti-inflamatório conforme prescrição, aplicação de calor local e fisioterapia posterior' },
  dorsalgia:    { q:'dorsalgia com dor dorsal de intensidade moderada, mialgia paravertebral e limitação de amplitude de movimento', c:'M54.9', r:'repouso relativo, anti-inflamatório e miorrelaxante conforme prescrição médica' },
  cervicalgia:  { q:'cervicalgia com dor cervical intensa, rigidez muscular e limitação da mobilidade do pescoço', c:'M54.2', r:'repouso, anti-inflamatório, miorrelaxante conforme prescrição e fisioterapia posterior' },
  tendinite:    { q:'tendinite com dor, edema e limitação funcional na região afetada', c:'M77.9', r:'repouso do membro afetado, gelo local, anti-inflamatório conforme prescrição e imobilização se necessário' },
  contusao:     { q:'contusão com dor local, edema e limitação funcional após trauma', c:'T14.0', r:'repouso, aplicação de gelo nas primeiras 48 horas, elevação do membro e analgésico conforme prescrição' },
  cefaleia:     { q:'cefaleia tensional intensa com dor difusa, pulsátil, fotofobia e náuseas', c:'R51', r:'repouso em ambiente silencioso e com pouca luz, hidratação e analgésico conforme prescrição médica' },
  enxaqueca:    { q:'crise de enxaqueca com cefaleia intensa unilateral, pulsátil, acompanhada de náuseas, vômito e fotofobia', c:'G43.9', r:'repouso em ambiente escuro e silencioso, hidratação e medicação específica conforme prescrição' },
  ansiedade:    { q:'transtorno de ansiedade com sintomas de agitação, taquicardia, dispneia, insônia e dificuldade de concentração', c:'F41.9', r:'repouso, afastamento de situações estressoras, uso de medicação conforme prescrição e acompanhamento psiquiátrico' },
  depressao:    { q:'episódio depressivo com humor deprimido, anedonia, fadiga, insônia e dificuldade de concentração', c:'F32.9', r:'repouso, afastamento de atividades laborais, acompanhamento psiquiátrico e psicológico e uso de medicação conforme prescrição' },
  insonia:      { q:'insônia persistente com dificuldade de indução e manutenção do sono, sonolência diurna e irritação', c:'G47.0', r:'repouso, higiene do sono, evitar cafeína e telas à noite, medicação conforme prescrição médica' },
  tontura:      { q:'tontura e vertigem com desequilíbrio, náuseas e instabilidade postural', c:'R42', r:'repouso, evitar movimentos brúscos, hidratação, antivertiginoso conforme prescrição' },
  sincope:      { q:'síncope com perda súbita da consciência de curta duração, precedida de tontura e mal-estar', c:'R55', r:'repouso absoluto, monitoramento de sinais vitais, hidratação e avaliação cardiológica' },
  has:          { q:'hipertensão arterial sistêmica descompensada com cefaléia occipital, tontura, epistáxis e mal-estar', c:'I10', r:'repouso, redução do estíeé, dieta hipossódica, uso regular da medicação anti-hipertensiva conforme prescrição' },
  dm:           { q:'diabetes mellitus descompensada com hiperglicemia, astenia, poliúria, polidipsia e mal-estar', c:'E11.9', r:'repouso, monitoramento da glicemia, ajuste da medicação conforme prescrição e dieta appropriada' },
  palpitacao:   { q:'palpitções com taquicardia, desconforto torácico e ansieda', c:'R00.0', r:'repouso, evitar estimulantes (cafeína, álcool), monitoração de sinais vitais e avaliação cardiológica' },
  itu:          { q:'infecção do trato urinário com disúria, polaciúria, urgência miccional e desconforto suprapúbico', c:'N39.0', r:'repouso, hidratação abundante, antibioticoterapia conforme prescrição e retorno em caso de piora' },
  colica_renal: { q:'cólica renal com dor lombar intensa em cólica, irradiada para virilha, com náuseas e agitação', c:'N23', r:'repouso, hidratação, analgésico e antiespasmódico conforme prescrição médica' },
  dismenorreia: { q:'dismenorreia com dor pélvica intensa de cólica, associada ao ciclo menstrual, acompanhada de náuseas e mal-estar', c:'N94.6', r:'repouso, compressa morna na região pélvica, anti-inflamatório e antiespasmódico conforme prescrição' },
  dermatite:    { q:'dermatite com lesões eritematosas, prurido intenso e descamação na região afetada', c:'L30.9', r:'repouso, evitar agentes irritantes, hidratante e corticoide tópico conforme prescrição médica' },
  urticaria:    { q:'urticária aguda com pápulas eritematosas, pruriginosas e disseminadas pelo corpo', c:'L50.9', r:'repouso, anti-histamínico conforme prescrição, evitar calor e agentes desencadeantes' },
  herpes:       { q:'herpes zoster com lesões vesiculares dolorosas em distribuição dermatômica, acompanhadas de neuralgia intensa', c:'B02.9', r:'repouso, antiviral conforme prescrição, analgésico e curativo das lesões' },
  varicela:     { q:'varicela (catapora) com lesões vesiculares pruriginosas disseminadas, febre e mal-estar geral', c:'B01.9', r:'repouso, isolamento domiciliar até crostação total das lesões, anti-histamínico e antiviral conforme prescrição' },
  mal_estar:    { q:'mal-estar geral, febre e prostração, sem diagnóstico específico definido no momento do atendimento', c:'R53', r:'repouso, hidratação, uso de antipirético, monitoramento dos sintomas e retorno em caso de piora' },
  febre:        { q:'febre sem causa determinada, acompanhada de calafrios, sudorese e mal-estar', c:'R50.9', r:'repouso, hidratação, uso de antipirético (dipirona/paracetamol) conforme prescrição e retorno se persistir' },
  astenia:      { q:'astenia e fadiga acentuada com limitação significativa das atividades habituais', c:'R53.1', r:'repouso, hidratação, dieta equilibrada, suplementação se indicada e acompanhamento médico' },
  hipoglicemia: { q:'hipoglicemia com sudorese fria, tremores, tonturas, palpitações e rebaixamento do nível de consciência', c:'E16.0', r:'repouso, monitoramento da glicemia, refeições regulares e ajuste de medicação conforme prescrição' },
  alergica:     { q:'reação alérgica com urticária, prurido, edema e mal-estar após exposição a substância alergênica', c:'T78.4', r:'repouso, anti-histamínico e corticoide conforme prescrição, afastar o agente causador e observação clínica' },
};
function preencherQuadro(key) {
  if (!key || !QUADROS[key]) return;
  var d = QUADROS[key];
  document.getElementById('campo-quadro').value = d.q;
  document.getElementById('campo-cid').value    = d.c;
  document.getElementById('campo-rec').value    = d.r;
}
var currentCode = '';
function showQR(code) {
  currentCode = code;
  document.getElementById('qr-modal').classList.add('open');
  document.getElementById('qr-code-text').textContent = code;
  var canvas = document.getElementById('qr-canvas');
  QRCode.toCanvas(canvas, code, { width: 220, margin: 2, color: { dark:'#1e3a6e', light:'#ffffff' } }, function(){});
}
function closeQR() {
  document.getElementById('qr-modal').classList.remove('open');
}
function downloadQR() {
  var canvas = document.getElementById('qr-canvas');
  var a = document.createElement('a');
  a.download = 'qr-' + currentCode + '.png';
  a.href = canvas.toDataURL('image/png');
  a.click();
}
</script>
<?php endif; ?>
</body>
</html>
