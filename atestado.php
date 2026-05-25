<?php
$pageTitle = 'Atestado Médico — VerificaMed';
$submitted = false;
$data = [];

function gerarCodigoAtestado() {
    $c = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $r = '';
    for ($i = 0; $i < 18; $i++) $r .= $c[rand(0, strlen($c)-1)];
    return $r;
}
function formatarDataPT($ymd) {
    if (!$ymd) return '';
    $m = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    [$y,$mo,$d] = explode('-', $ymd);
    return (int)$d . ' de ' . $m[(int)$mo] . ' de ' . $y;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'tratamento'     => trim($_POST['tratamento']     ?? 'Sr.'),
        'nomePaciente'   => trim($_POST['nomePaciente']   ?? ''),
        'unidade'        => trim($_POST['unidade']        ?? ''),
        'enderecoUnidade'=> trim($_POST['enderecoUnidade']?? ''),
        'dataAtend'      => trim($_POST['dataAtend']      ?? ''),
        'quadroClinico'  => trim($_POST['quadroClinico']  ?? ''),
        'tipoAfast'      => trim($_POST['tipoAfast']      ?? 'dia'),
        'diasAfast'      => trim($_POST['diasAfast']      ?? '1'),
        'dataAfastInicio'=> trim($_POST['dataAfastInicio']?? ''),
        'recomendacoes'  => trim($_POST['recomendacoes']  ?? ''),
        'cid'            => trim($_POST['cid']            ?? ''),
        'nomeMedico'     => trim($_POST['nomeMedico']     ?? ''),
        'especialidade'  => trim($_POST['especialidade']  ?? ''),
        'crmEstado'      => trim($_POST['crmEstado']      ?? ''),
        'crmNumero'      => trim($_POST['crmNumero']      ?? ''),
        'cns'            => trim($_POST['cns']            ?? ''),
        'cidade'         => trim($_POST['cidade']         ?? ''),
        'observacoes'    => trim($_POST['observacoes']    ?? ''),
    ];
    if ($data['nomePaciente'] && $data['nomeMedico'] && $data['crmNumero'] && $data['dataAtend']) {
        $submitted = true;
        $codigo = gerarCodigoAtestado();
        $dataFormatada = formatarDataPT($data['dataAtend']);
        $dataAfastFmt  = $data['dataAfastInicio'] ? formatarDataPT($data['dataAfastInicio']) : $dataFormatada;
        $cidadeData    = ($data['cidade'] ? $data['cidade'] . ', ' : '') . $dataFormatada;
        if ($data['tipoAfast'] === 'dia') {
            $textoAfast = 'exclusivamente no dia ' . $dataFormatada;
        } else {
            $textoAfast = 'pelo período de ' . $data['diasAfast'] . ' dia(s), a contar de ' . $dataAfastFmt;
        }
    }
}
$today = date('Y-m-d');
?>
<?php include 'includes/header.php'; ?>

<?php if ($submitted): ?>
<!-- DOCUMENT OUTPUT -->
<style>
@media print {
  .no-print { display: none !important; }
  .site-nav, .announce-bar, footer { display: none !important; }
  body { background: #fff !important; }
  #doc-print { box-shadow: none !important; border: none !important; margin: 0 !important; padding: 1.5cm 2cm !important; max-width: 100% !important; }
}
</style>
<div style="max-width:820px;margin:2rem auto;padding:0 1.5rem 3rem;">

  <div class="no-print" style="text-align:center;margin-bottom:1.5rem;">
    <span style="display:inline-flex;align-items:center;gap:.5rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:.75rem;padding:.75rem 1.25rem;font-size:.875rem;font-weight:600;color:#15803d;">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Atestado gerado! &nbsp;<span style="font-weight:400;color:#6b7280;">Código: <strong style="font-family:monospace;color:#2563eb;"><?= htmlspecialchars($codigo) ?></strong></span>
    </span>
  </div>

  <!-- ====== THE DOCUMENT ====== -->
  <div id="doc-print" style="background:#fff;border:1px solid #ccc;padding:2.5rem 3rem;font-family:'Times New Roman',Times,serif;font-size:11.5pt;line-height:1.65;color:#111;box-shadow:0 4px 24px rgba(0,0,0,.10);">

    <!-- HEADER -->
    <table style="width:100%;border-bottom:2px solid #444;padding-bottom:.6rem;margin-bottom:.8rem;">
      <tr valign="top">
        <td>
          <div style="font-size:13.5pt;font-weight:800;text-transform:uppercase;letter-spacing:.4px;"><?= htmlspecialchars($data['unidade'] ?: 'Estabelecimento de Saúde') ?></div>
          <?php if ($data['enderecoUnidade']): ?>
          <div style="font-size:8.5pt;color:#555;margin-top:2px;"><?= htmlspecialchars($data['enderecoUnidade']) ?></div>
          <?php endif; ?>
        </td>
        <td style="text-align:right;">
          <div style="font-size:14pt;font-weight:700;font-style:italic;">Atestado</div>
        </td>
      </tr>
    </table>

    <!-- BODY PARAGRAPHS -->
    <p style="text-align:justify;margin:0 0 .9rem;">
      Declaro, para os devidos fins, que o(a) <?= htmlspecialchars($data['tratamento']) ?>&nbsp;<strong><?= htmlspecialchars($data['nomePaciente']) ?></strong> foi atendido(a) nesta <?= htmlspecialchars($data['unidade'] ?: 'Unidade de Saúde') ?> no dia <strong><?= htmlspecialchars($dataFormatada) ?></strong>, apresentando quadro clínico compatível com <?= htmlspecialchars($data['quadroClinico'] ?: 'quadro clínico em avaliação') ?>.
    </p>
    <p style="text-align:justify;margin:0 0 .9rem;">
      Após avaliação médica, constatou-se a necessidade de afastamento de suas atividades habituais <?= htmlspecialchars($textoAfast) ?>, sendo recomendado <?= htmlspecialchars($data['recomendacoes'] ?: 'repouso e acompanhamento médico') ?>.
    </p>
    <p style="text-align:justify;margin:0 0 2rem;">
      Firmo o presente atestado para os devidos fins.
    </p>

    <!-- BOTTOM SECTION -->
    <table style="width:100%;margin-top:1rem;">
      <tr valign="bottom">
        <td style="width:48%;font-size:9.5pt;line-height:1.8;">
          <?php if ($data['observacoes']): ?>
          <div><em>Observações:</em><br><?= nl2br(htmlspecialchars($data['observacoes'])) ?></div>
          <?php endif; ?>
          <?php if ($data['cid']): ?>
          <div>CID: <?= htmlspecialchars($data['cid']) ?></div>
          <?php endif; ?>
          <div style="margin-top:.4rem;">
            <?= htmlspecialchars($cidadeData) ?><br>
            Código: <span style="font-family:Courier,monospace;font-size:8.5pt;"><?= htmlspecialchars($codigo) ?></span>
          </div>
        </td>
        <td style="width:4%;"></td>
        <td style="width:48%;text-align:center;">
          <div style="border-top:1.5px solid #222;padding-top:.4rem;margin-top:3rem;">
            <div style="font-weight:700;font-size:10.5pt;"><?= htmlspecialchars($data['nomeMedico']) ?></div>
            <?php if ($data['especialidade']): ?>
            <div style="font-size:9pt;"><?= htmlspecialchars($data['especialidade']) ?></div>
            <?php endif; ?>
            <div style="font-size:9pt;">CRM <?= htmlspecialchars($data['crmEstado']) ?> <?= htmlspecialchars($data['crmNumero']) ?></div>
            <?php if ($data['cns']): ?>
            <div style="font-size:8.5pt;color:#444;">CNS: <?= htmlspecialchars($data['cns']) ?></div>
            <?php endif; ?>
          </div>
        </td>
      </tr>
    </table>

    <!-- FOOTER STRIP -->
    <div style="margin-top:2rem;border-top:1px solid #bbb;padding-top:.35rem;font-size:8pt;color:#777;display:flex;justify-content:space-between;">
      <span>VerificaMed — Sistema Nacional de Verificação</span>
      <span>verificamed.website</span>
      <span>Lei 14.063/2020</span>
    </div>
  </div>

  <!-- ACTIONS -->
  <div class="no-print" style="display:flex;gap:.75rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap;">
    <button onclick="window.print()" style="display:inline-flex;align-items:center;gap:.5rem;background:#2563eb;color:#fff;font-weight:600;padding:.75rem 1.75rem;border-radius:.625rem;border:none;cursor:pointer;font-size:.9rem;">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
      Imprimir / Salvar PDF
    </button>
    <a href="atestado.php" style="display:inline-flex;align-items:center;gap:.5rem;background:#f3f4f6;color:#374151;font-weight:600;padding:.75rem 1.75rem;border-radius:.625rem;text-decoration:none;font-size:.9rem;">Novo Atestado</a>
  </div>
</div>

<?php else: ?>
<!-- FORM -->
<section class="hero-section" style="padding:2.5rem 1.5rem;">
  <div style="position:relative;z-index:1;">
    <h1 class="hero-h1" style="font-size:1.75rem;">Gerar Atestado Médico</h1>
    <p class="hero-sub" style="margin-bottom:0;">Preencha os campos abaixo para emitir um atestado no formato UPA/clínica.</p>
  </div>
</section>

<div style="max-width:820px;margin:0 auto;padding:2rem 1.5rem 3rem;">
  <form method="POST" action="atestado.php" style="display:flex;flex-direction:column;gap:1.5rem;">

    <!-- UNIDADE -->
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);">
      <h3 style="font-size:.9375rem;font-weight:700;color:#111827;margin:0 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;">🏥 Unidade / Estabelecimento</h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;grid-column:span 2;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Nome da unidade <span style="color:#ef4444;">*</span></label>
          <input name="unidade" class="input-field" placeholder="ex: Unidade de Pronto Atendimento (UPA 24h)" required value="<?= htmlspecialchars($_POST['unidade'] ?? '') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;grid-column:span 2;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Endereço da unidade</label>
          <input name="enderecoUnidade" class="input-field" placeholder="ex: Av. Principal, 100 - Bairro - Cidade/UF" value="<?= htmlspecialchars($_POST['enderecoUnidade'] ?? '') ?>">
        </div>
      </div>
    </div>

    <!-- PACIENTE -->
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);">
      <h3 style="font-size:.9375rem;font-weight:700;color:#111827;margin:0 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;">👤 Paciente</h3>
      <div style="display:grid;grid-template-columns:100px 1fr;gap:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Tratamento</label>
          <select name="tratamento" class="input-field">
            <option value="Sr.">Sr.</option>
            <option value="Sra.">Sra.</option>
            <option value="Dr.">Dr.</option>
            <option value="Dra.">Dra.</option>
          </select>
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Nome completo <span style="color:#ef4444;">*</span></label>
          <input name="nomePaciente" class="input-field" placeholder="Nome completo do paciente" required value="<?= htmlspecialchars($_POST['nomePaciente'] ?? '') ?>">
        </div>
      </div>
    </div>

    <!-- ATENDIMENTO -->
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);">
      <h3 style="font-size:.9375rem;font-weight:700;color:#111827;margin:0 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;">📋 Atendimento</h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Data do atendimento <span style="color:#ef4444;">*</span></label>
          <input name="dataAtend" type="date" class="input-field" value="<?= htmlspecialchars($_POST['dataAtend'] ?? $today) ?>" required>
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">CID</label>
          <input name="cid" class="input-field" placeholder="ex: J11" value="<?= htmlspecialchars($_POST['cid'] ?? '') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;grid-column:span 2;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Quadro clínico / sintomas <span style="color:#ef4444;">*</span></label>
          <textarea name="quadroClinico" class="input-field" rows="2" placeholder="ex: síndrome gripal, acompanhada de febre, cefaleia, dores no corpo e mal-estar geral" style="resize:vertical;" required><?= htmlspecialchars($_POST['quadroClinico'] ?? '') ?></textarea>
        </div>
      </div>
    </div>

    <!-- AFASTAMENTO -->
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);">
      <h3 style="font-size:.9375rem;font-weight:700;color:#111827;margin:0 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;">📅 Afastamento</h3>
      <div style="display:flex;gap:1rem;margin-bottom:1rem;">
        <label style="display:flex;align-items:center;gap:.4rem;font-size:.875rem;cursor:pointer;">
          <input type="radio" name="tipoAfast" value="dia" checked onchange="toggleAfast(this.value)"> Só no dia do atendimento
        </label>
        <label style="display:flex;align-items:center;gap:.4rem;font-size:.875rem;cursor:pointer;">
          <input type="radio" name="tipoAfast" value="periodo" onchange="toggleAfast(this.value)"> Por período (dias)
        </label>
      </div>
      <div id="afast-periodo" style="display:none;grid-template-columns:1fr 1fr;gap:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Nº de dias</label>
          <input name="diasAfast" type="number" min="1" class="input-field" placeholder="ex: 3" value="<?= htmlspecialchars($_POST['diasAfast'] ?? '') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">A partir de</label>
          <input name="dataAfastInicio" type="date" class="input-field" value="<?= htmlspecialchars($_POST['dataAfastInicio'] ?? $today) ?>">
        </div>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;grid-column:span 2;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Recomendações <span style="color:#ef4444;">*</span></label>
          <textarea name="recomendacoes" class="input-field" rows="2" placeholder="ex: repouso, hidratação e acompanhamento dos sintomas para adequada recuperação do quadro clínico" style="resize:vertical;" required><?= htmlspecialchars($_POST['recomendacoes'] ?? '') ?></textarea>
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Observações</label>
          <input name="observacoes" class="input-field" placeholder="Observações (opcional)" value="<?= htmlspecialchars($_POST['observacoes'] ?? '') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Cidade</label>
          <input name="cidade" class="input-field" placeholder="ex: Teresina" value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>">
        </div>
      </div>
    </div>

    <!-- MÉDICO -->
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1rem;padding:1.5rem;box-shadow:0 2px 10px rgba(37,99,235,.05);">
      <h3 style="font-size:.9375rem;font-weight:700;color:#111827;margin:0 0 1rem;padding-bottom:.5rem;border-bottom:1px solid #f0f0f0;">👨‍⚕️ Médico Responsável</h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div style="display:flex;flex-direction:column;gap:.3rem;grid-column:span 2;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Nome completo <span style="color:#ef4444;">*</span></label>
          <input name="nomeMedico" class="input-field" placeholder="ex: Alice Nobre de Moura Filho" required value="<?= htmlspecialchars($_POST['nomeMedico'] ?? 'Alice Nobre de Moura Filho') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Especialidade</label>
          <input name="especialidade" class="input-field" placeholder="ex: Médico Clínico Geral" value="<?= htmlspecialchars($_POST['especialidade'] ?? 'Médico Clínico Geral') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">CRM — Estado</label>
          <select name="crmEstado" class="input-field">
            <?php foreach (['AC','AL','AM','AP','BA','CE','DF','ES','GO','MA','MG','MS','MT','PA','PB','PE','PI','PR','RJ','RN','RO','RR','RS','SC','SE','SP','TO'] as $uf): ?>
            <option value="<?= $uf ?>" <?= (($_POST['crmEstado'] ?? 'PI') === $uf) ? 'selected' : '' ?>><?= $uf ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">Nº CRM <span style="color:#ef4444;">*</span></label>
          <input name="crmNumero" class="input-field" placeholder="ex: 14927" required value="<?= htmlspecialchars($_POST['crmNumero'] ?? '14927') ?>">
        </div>
        <div style="display:flex;flex-direction:column;gap:.3rem;">
          <label style="font-size:.8125rem;font-weight:600;color:#374151;">CNS (opcional)</label>
          <input name="cns" class="input-field" placeholder="ex: 702302133658716" value="<?= htmlspecialchars($_POST['cns'] ?? '702302133658716') ?>">
        </div>
      </div>
    </div>

    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:.75rem;padding:1rem 1.25rem;display:flex;gap:.75rem;align-items:flex-start;font-size:.8125rem;color:#92400e;">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
      <span>Certifique-se de que todas as informações estão corretas antes de gerar o atestado. O documento possui validade jurídica.</span>
    </div>

    <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:#2563eb;color:#fff;font-weight:700;padding:1rem;border-radius:.75rem;border:none;cursor:pointer;font-size:1rem;transition:background .15s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Gerar Atestado
    </button>
  </form>
</div>

<script>
function toggleAfast(v) {
  var el = document.getElementById('afast-periodo');
  el.style.display = v === 'periodo' ? 'grid' : 'none';
}
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
