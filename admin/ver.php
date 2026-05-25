<?php
session_start();
if (empty($_SESSION['admin'])) { header('Location: index.php'); exit; }

require_once '../config/db.php';

$id  = (int)($_GET['id'] ?? 0);
if (!$id) { echo 'ID inválido.'; exit; }

try {
    $db   = getDB();
    $stmt = $db->prepare("SELECT * FROM documentos WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $doc  = $stmt->fetch();
} catch (PDOException $e) { echo 'Erro DB.'; exit; }
if (!$doc) { echo 'Documento não encontrado.'; exit; }

/* ── reconstruir variáveis ─────────────────────────────── */
function formatarDataPT2($ymd) {
    if (!$ymd) return '';
    $m = ['','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    [$y,$mo,$d] = explode('-', $ymd);
    return (int)$d . ' de ' . $m[(int)$mo] . ' de ' . $y;
}

$codigo        = $doc['codigo'];
$dataFormatada = formatarDataPT2($doc['data_atend']);
$dataAfastFmt  = $doc['data_afast'] ? formatarDataPT2($doc['data_afast']) : $dataFormatada;
$cidadeData    = ($doc['cidade'] ? $doc['cidade'] . ', ' : '') . $dataFormatada;

if ($doc['tipo_afast'] === 'dia') {
    $textoAfast = 'exclusivamente no dia ' . $dataFormatada;
} else {
    $textoAfast = 'pelo período de ' . $doc['dias_afast'] . ' dia(s), a contar de ' . $dataAfastFmt;
}

$_sigPath  = dirname(__DIR__) . '/assets/img/assinatura.png';
$_sigSrc   = file_exists($_sigPath)  ? 'data:image/png;base64,' . base64_encode(file_get_contents($_sigPath))  : '';
$_logoPath = dirname(__DIR__) . '/assets/img/upa-logo.png';
$_logoSrc  = file_exists($_logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($_logoPath)) : '';
?><!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Atestado — <?= htmlspecialchars($codigo) ?></title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{background:#e8edf5;font-family:Arial,sans-serif;padding:2rem 1rem;}
.toolbar{max-width:820px;margin:0 auto 1.25rem;display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;}
.btn{display:inline-flex;align-items:center;gap:.4rem;font-weight:600;font-size:.875rem;padding:.65rem 1.25rem;border-radius:.5rem;border:none;cursor:pointer;text-decoration:none;}
.btn-blue{background:#2563eb;color:#fff;}
.btn-blue:hover{background:#1d4ed8;}
.btn-gray{background:#f1f5f9;color:#374151;}
.btn-gray:hover{background:#e2e8f0;}
@media print{
  body{background:#fff;padding:0;}
  .toolbar{display:none;}
  #doc-print{box-shadow:none!important;border:none!important;margin:0!important;padding:1.5cm 2cm!important;max-width:100%!important;}
}
</style>
</head>
<body>

<div class="toolbar">
  <a href="index.php" class="btn btn-gray">← Voltar ao Admin</a>
  <button onclick="printDoc()" class="btn btn-blue">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
    Imprimir / Salvar PDF
  </button>
  <span style="font-size:.8125rem;color:#6b7280;">Código: <strong style="font-family:monospace;color:#2563eb;"><?= htmlspecialchars($codigo) ?></strong></span>
</div>

<!-- ══ DOCUMENTO ══════════════════════════════════════════ -->
<div id="doc-print" style="background:#fff;border:1px solid #d1d5db;padding:1.8cm 2.2cm 1.2cm;font-family:'Times New Roman',Times,serif;font-size:11.5pt;line-height:1.7;color:#111;box-shadow:0 4px 28px rgba(0,0,0,.11);max-width:820px;margin:0 auto;min-height:26cm;display:flex;flex-direction:column;">

  <!-- HEADER -->
  <table style="width:100%;border-bottom:2px solid #333;padding-bottom:.65rem;margin-bottom:1.1rem;" cellpadding="0" cellspacing="0">
    <tr valign="middle">
      <td style="width:125px;padding-right:14px;vertical-align:middle;">
        <?php if ($_logoSrc): ?>
        <div style="width:120px;height:56px;overflow:hidden;">
          <img src="<?= $_logoSrc ?>" alt="UPA 24h"
            style="width:262px;margin-left:-62px;margin-top:-97px;display:block;">
        </div>
        <?php endif; ?>
      </td>
      <td style="text-align:center;padding:0 .5rem;">
        <div style="font-size:12.5pt;font-weight:800;text-transform:uppercase;letter-spacing:.3px;font-family:Arial,sans-serif;"><?= htmlspecialchars($doc['unidade'] ?: 'UNIDADE DE PRONTO ATENDIMENTO') ?></div>
        <?php if ($doc['unidade']): ?><div style="font-size:9.5pt;font-family:Arial,sans-serif;">(UPA 24h UPA)</div><?php endif; ?>
        <?php if ($doc['endereco']): ?>
        <div style="font-size:8pt;color:#555;margin-top:2px;font-family:Arial,sans-serif;"><?= htmlspecialchars($doc['endereco']) ?></div>
        <?php endif; ?>
      </td>
      <td style="width:72px;text-align:right;vertical-align:top;padding-top:2px;">
        <div style="font-size:8.5pt;font-family:Arial,sans-serif;color:#333;">Prontuário</div>
      </td>
    </tr>
  </table>

  <!-- BODY -->
  <p style="text-align:justify;margin:0 0 .95rem;">
    Declaro, para os devidos fins, que o <?= htmlspecialchars($doc['tratamento']) ?>&nbsp;<?= htmlspecialchars($doc['paciente']) ?> foi atendido nesta Unidade de Pronto Atendimento (UPA) no dia <?= date('d/m/Y', strtotime($doc['data_atend'])) ?>, apresentando quadro clínico compatível com <?= htmlspecialchars($doc['quadro'] ?: 'quadro clínico em avaliação') ?>.
  </p>
  <p style="text-align:justify;margin:0 0 .95rem;">
    Após avaliação médica, constatou-se a necessidade de afastamento de suas atividades habituais <?= htmlspecialchars($textoAfast) ?>, sendo recomendado <?= htmlspecialchars($doc['recomendacoes'] ?: 'repouso e acompanhamento médico') ?>.
  </p>
  <p style="text-align:justify;margin:0 0 0;">
    Firmo o presente atestado para os devidos fins.
  </p>

  <div style="flex:1;min-height:2.5cm;"></div>

  <!-- BOTTOM -->
  <table style="width:100%;" cellpadding="0" cellspacing="0">
    <tr valign="bottom">
      <td style="width:46%;font-size:9.5pt;line-height:2;vertical-align:bottom;">
        <div style="font-size:8.5pt;font-style:italic;color:#444;margin-bottom:.1rem;">Observações</div>
        <?php if ($doc['observacoes']): ?>
        <div style="font-size:9pt;margin-bottom:.4rem;"><?= nl2br(htmlspecialchars($doc['observacoes'])) ?></div>
        <?php else: ?><div style="margin-bottom:.4rem;">&nbsp;</div><?php endif; ?>
        <?php if ($doc['cid']): ?>
        <div>CID <?= htmlspecialchars(strtoupper($doc['cid'])) ?></div>
        <?php endif; ?>
        <div style="margin-top:.6rem;line-height:1.5;">
          <?= htmlspecialchars($cidadeData) ?><br>
          <span style="font-size:8.5pt;">código: <span style="font-family:Courier,monospace;"><?= htmlspecialchars($codigo) ?></span></span>
        </div>
      </td>
      <td style="width:8%;"></td>
      <td style="width:46%;text-align:center;vertical-align:bottom;">
        <div style="height:6rem;display:flex;align-items:flex-end;justify-content:center;">
          <?php if ($_sigSrc): ?>
          <img src="<?= $_sigSrc ?>" alt="Assinatura" style="width:90%;max-width:240px;height:auto;display:block;margin:0 auto;">
          <?php else: ?><div style="height:5rem;"></div><?php endif; ?>
        </div>
        <div style="border-top:1.5px solid #111;padding-top:.35rem;">
          <div style="font-size:10.5pt;font-weight:600;font-family:Arial,sans-serif;"><?= htmlspecialchars($doc['medico']) ?></div>
          <div style="font-size:8.5pt;font-family:Arial,sans-serif;text-transform:uppercase;letter-spacing:.2px;margin-top:1px;">
            <?= htmlspecialchars(strtoupper($doc['especialidade'] ?? '')) ?>
            CRM - <?= htmlspecialchars(strtoupper($doc['crm_estado'])) ?>
            <?= htmlspecialchars($doc['crm_numero']) ?>-<?= htmlspecialchars(strtolower($doc['crm_estado'])) ?>/
            <?php if ($doc['cns']): ?>CNS: <?= htmlspecialchars($doc['cns']) ?><?php endif; ?>
          </div>
        </div>
      </td>
    </tr>
  </table>

  <!-- FOOTER -->
  <div style="margin-top:1.2rem;border-top:1px solid #bbb;padding-top:.3rem;font-size:7pt;color:#666;display:flex;justify-content:space-between;font-family:Arial,sans-serif;">
    <span>Gerado por <?= strtoupper(htmlspecialchars($doc['medico'])) ?></span>
    <span>© VerificaMed | verificamed.website</span>
    <span>1/1</span>
    <span><?= date('d/m/Y H:i') ?></span>
  </div>
</div>

<script>
function printDoc() {
  var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
  if (isIOS) { window.focus(); setTimeout(function(){ window.print(); }, 300); }
  else { window.print(); }
}
</script>
</body>
</html>
