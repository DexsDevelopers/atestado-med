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
          <input name="medico" required/>
        </div>
        <div>
          <label>Especialidade</label>
          <input name="especialidade" placeholder="ex: Médico Clínico Geral"/>
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
            <input name="crm_numero" required/>
          </div>
        </div>
      </div>
      <div class="grid3" style="margin-bottom:1rem;">
        <div>
          <label>CNS</label>
          <input name="cns" placeholder="opcional"/>
        </div>
        <div>
          <label>Data do atendimento *</label>
          <input type="date" name="data_atend" value="<?= $today ?>" required/>
        </div>
        <div>
          <label>CID</label>
          <input name="cid" placeholder="ex: J11"/>
        </div>
      </div>
      <div style="margin-bottom:1rem;">
        <label>Quadro clínico / sintomas *</label>
        <textarea name="quadro" rows="2" style="resize:vertical;" required></textarea>
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
      <div class="grid2" style="margin-bottom:1rem;">
        <div>
          <label>Recomendações *</label>
          <textarea name="recomendacoes" rows="2" style="resize:vertical;" required></textarea>
        </div>
        <div>
          <label>Observações</label>
          <textarea name="observacoes" rows="2" style="resize:vertical;"></textarea>
        </div>
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
