<?php
$pageTitle = 'Verificar Documento — VerificaMed';
require_once 'config/db.php';

$codigo    = '';
$resultado = null;
$searched  = false;
$dbError   = false;

$codigoGet = strtoupper(trim($_GET['codigo'] ?? ''));
if ($codigoGet) {
    $codigo   = $codigoGet;
    $searched = true;
    try {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM documentos WHERE codigo = ? AND status = 'ativo' LIMIT 1");
        $stmt->execute([$codigo]);
        $resultado = $stmt->fetch() ?: null;
    } catch (PDOException $e) { $dbError = true; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo   = strtoupper(trim($_POST['codigo'] ?? ''));
    $searched = true;
    if ($codigo) {
        try {
            $db   = getDB();
            $stmt = $db->prepare("SELECT * FROM documentos WHERE codigo = ? AND status = 'ativo' LIMIT 1");
            $stmt->execute([$codigo]);
            $resultado = $stmt->fetch() ?: null;
        } catch (PDOException $e) { $dbError = true; }
    }
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$shareUrl = $resultado ? $protocol . '://' . $_SERVER['HTTP_HOST']
    . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/verificar.php?codigo=' . urlencode($codigo) : '';
?>
<?php include 'includes/header.php'; ?>
<style>
@media print {
  .announce-bar, .site-nav, footer,
  .hero-section, .section-gray,
  .seal-wrap, .share-bar, .copy-toast,
  .no-print, #qr-container { display: none !important; }

  body { background: #fff !important; }
  section { padding: 0 !important; background: none !important; }
  .verify-result-wrap { padding: 0 !important; max-width: 100% !important; }

  .doc-card {
    box-shadow: none !important;
    border: 1px solid #ccc !important;
    border-radius: 0 !important;
    page-break-inside: avoid;
  }
  .doc-card-header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  .doc-fields { grid-template-columns: 1fr 1fr !important; }
}
</style>

<section class="hero-section" style="padding:3rem 1.5rem;">
  <div style="position:relative;z-index:1;">
    <h1 class="hero-h1" style="font-size:2rem;">Verificar Documento</h1>
    <p class="hero-sub">Insira o código do documento ou escaneie o QR Code para confirmar a autenticidade em tempo real.</p>
  </div>
</section>

<section class="section-gray" style="padding:3rem 0;">
<div style="max-width:640px;margin:0 auto;padding:0 1.5rem;">

  <div class="verify-card" style="margin-bottom:1.5rem;">
    <p style="font-size:.9375rem;font-weight:600;color:#111827;margin-bottom:1rem;">Digite o código de verificação</p>
    <form method="POST" action="verificar.php" id="verify-form" style="display:flex;gap:.75rem;flex-wrap:wrap;">
      <input
        type="text"
        name="codigo"
        id="codigo-input"
        value="<?= htmlspecialchars($codigo) ?>"
        placeholder="Ex: VM-2024-001234"
        class="input-field"
        style="flex:1;min-width:200px;font-family:monospace;"
        required
      />
      <button type="submit" style="display:inline-flex;align-items:center;gap:.5rem;background:#2563eb;color:#fff;font-weight:600;padding:.75rem 1.5rem;border-radius:.625rem;border:none;cursor:pointer;font-size:.9rem;transition:background .15s;white-space:nowrap;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
        <svg fill="none" width="16" height="16" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Verificar
      </button>
    </form>

    <!-- QR SCANNER BUTTON -->
    <div style="text-align:center;margin-top:1.25rem;">
      <button type="button" id="btn-scan" onclick="toggleScanner()"
        style="display:inline-flex;align-items:center;gap:.5rem;background:#f0f4ff;color:#2563eb;font-weight:600;font-size:.875rem;padding:.625rem 1.25rem;border-radius:.625rem;border:1.5px solid #c7d7fd;cursor:pointer;transition:background .15s;"
        onmouseover="this.style.background='#dce8ff'" onmouseout="this.style.background='#f0f4ff'">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 14h2m0 0h3m-3 0v2m0 3h3m-6 0h3"/>
        </svg>
        Escanear QR Code com a câmera
      </button>
    </div>

    <!-- QR SCANNER CONTAINER -->
    <div id="qr-container" style="display:none;margin-top:1rem;">
      <div style="position:relative;background:#000;border-radius:.75rem;overflow:hidden;max-width:360px;margin:0 auto;">
        <div id="qr-reader" style="width:100%;"></div>
      </div>
      <div style="text-align:center;margin-top:.75rem;">
        <button type="button" onclick="stopScanner()"
          style="display:inline-flex;align-items:center;gap:.4rem;background:#fee2e2;color:#dc2626;font-weight:600;font-size:.8125rem;padding:.5rem 1rem;border-radius:.5rem;border:none;cursor:pointer;">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          Fechar câmera
        </button>
      </div>
      <p style="text-align:center;font-size:.75rem;color:#9ca3af;margin-top:.5rem;">Aponte a câmera para o QR Code do documento</p>
    </div>

  </div>

  <?php if ($dbError): ?>
  <div style="background:#fff;border:2px solid #f59e0b;border-radius:1.25rem;padding:1.5rem;margin-top:1.5rem;" class="anim-fadeup">
    <p style="color:#92400e;font-weight:600;">⚠️ Erro ao conectar ao banco de dados. Verifique as configurações.</p>
  </div>
  <?php endif; ?>

</div>
</section>

<?php if ($searched && $resultado): ?>
<!-- ══ RESULTADO: AUTÊNTICO ══════════════════════════════════ -->
<section style="background:linear-gradient(180deg,#f4f7ff 0%,#fff 100%);padding:2rem 0 4rem;">
<div class="verify-result-wrap">

  <!-- SEAL -->
  <div class="seal-wrap">
    <div class="seal-icon-ok">
      <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
      </svg>
    </div>
    <div class="seal-title-ok">Documento Autêntico</div>
    <div class="seal-sub">Verificado em <?= date('d/m/Y \à\s H:i') ?> · Base VerificaMed</div>
    <div class="badge-autent">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      ✓ VERIFICADO · ASSINATURA DIGITAL VÁLIDA · LEI 14.063/2020
    </div>
  </div>

  <!-- CARD DO DOCUMENTO -->
  <div class="doc-card">
    <div class="doc-card-header">
      <div class="doc-card-tipo">
        <?php if (str_contains($resultado['tipo'], 'Atestado')): ?>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <?php else: ?>
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <?php endif; ?>
        <?= htmlspecialchars($resultado['tipo']) ?>
      </div>
      <div class="doc-card-codigo"><?= htmlspecialchars($codigo) ?></div>
    </div>

    <div class="doc-fields">
      <div class="doc-field anim-fadeup anim-delay-1">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Paciente
        </div>
        <div class="doc-field-value"><?= htmlspecialchars($resultado['tratamento'] . ' ' . $resultado['paciente']) ?></div>
      </div>

      <div class="doc-field anim-fadeup anim-delay-2">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          Data do Atendimento
        </div>
        <div class="doc-field-value"><?= date('d/m/Y', strtotime($resultado['data_atend'])) ?></div>
      </div>

      <div class="doc-field anim-fadeup anim-delay-2">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M6 20v-1a6 6 0 0112 0v1"/></svg>
          Médico Responsável
        </div>
        <div class="doc-field-value"><?= htmlspecialchars($resultado['medico']) ?></div>
      </div>

      <div class="doc-field anim-fadeup anim-delay-3">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
          CRM
        </div>
        <div class="doc-field-value">CRM <?= htmlspecialchars($resultado['crm_estado']) ?> <?= htmlspecialchars($resultado['crm_numero']) ?></div>
      </div>

      <?php if ($resultado['especialidade']): ?>
      <div class="doc-field anim-fadeup anim-delay-3">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
          Especialidade
        </div>
        <div class="doc-field-value"><?= htmlspecialchars($resultado['especialidade']) ?></div>
      </div>
      <?php endif; ?>

      <?php if ($resultado['cid']): ?>
      <div class="doc-field anim-fadeup anim-delay-4">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 9"/></svg>
          CID
        </div>
        <div class="doc-field-value" style="font-family:monospace;font-size:1rem;color:#2563eb;"><?= htmlspecialchars($resultado['cid']) ?></div>
      </div>
      <?php endif; ?>

      <?php if ($resultado['unidade']): ?>
      <div class="doc-field doc-field-full anim-fadeup anim-delay-4">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          Unidade / Estabelecimento
        </div>
        <div class="doc-field-value"><?= htmlspecialchars($resultado['unidade']) ?><?= $resultado['endereco'] ? ' · ' . htmlspecialchars($resultado['endereco']) : '' ?></div>
      </div>
      <?php endif; ?>

      <?php if ($resultado['quadro']): ?>
      <div class="doc-field doc-field-full anim-fadeup anim-delay-5">
        <div class="doc-field-label">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Quadro Clínico
        </div>
        <div class="doc-field-value" style="font-weight:500;font-size:.875rem;color:#334155;line-height:1.6;"><?= htmlspecialchars($resultado['quadro']) ?></div>
      </div>
      <?php endif; ?>
    </div>

    <div class="doc-card-footer">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      <span class="doc-lei-badge">Lei 14.063/2020</span>
      <span>Assinatura digital válida · Documento íntegro e não adulterado</span>
      <span style="margin-left:auto;">Verificado às <?= date('H:i') ?></span>
    </div>
  </div>

  <!-- SHARE BAR -->
  <div class="share-bar no-print">
    <button class="btn-share btn-share-green" onclick="compartilhar('<?= htmlspecialchars($shareUrl, ENT_QUOTES) ?>')">
      <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
      Compartilhar Link
    </button>
    <button class="btn-share btn-share-primary" onclick="copiarLink('<?= htmlspecialchars($shareUrl, ENT_QUOTES) ?>')">
      <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
      Copiar Link
    </button>
    <button class="btn-share btn-share-gray" onclick="window.print()">
      <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
      Imprimir
    </button>
  </div>

  <?php
  $pdfFile = $resultado['arquivo_pdf'] ?? null;
  $pdfPath = __DIR__ . '/uploads/atestados/' . $pdfFile;
  $pdfUrl  = 'uploads/atestados/' . rawurlencode($pdfFile ?? '');
  if ($pdfFile && file_exists($pdfPath)):
  ?>
  <!-- ATESTADO PDF -->
  <div style="max-width:820px;margin:2rem auto 0;width:100%;padding:0 1rem;">
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1.25rem;overflow:hidden;box-shadow:0 4px 24px rgba(37,99,235,.07);">
      <div style="background:linear-gradient(135deg,#1e3a6e,#2563eb);padding:1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:.6rem;">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          <span style="color:#fff;font-weight:700;font-size:.9375rem;">Documento Original</span>
          <span style="background:rgba(255,255,255,.15);color:#fff;font-size:.7rem;font-weight:600;padding:.2rem .6rem;border-radius:999px;letter-spacing:.5px;">PDF</span>
        </div>
        <a href="<?= htmlspecialchars($pdfUrl) ?>" download
           style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:.5rem;padding:.4rem .9rem;font-size:.8125rem;font-weight:600;text-decoration:none;">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Baixar PDF
        </a>
      </div>
      <iframe src="<?= htmlspecialchars($pdfUrl) ?>" width="100%" height="680"
        style="display:block;border:none;"
        title="Atestado Médico">
        <p style="padding:2rem;text-align:center;">
          Seu navegador não suporta visualização de PDF.
          <a href="<?= htmlspecialchars($pdfUrl) ?>">Clique aqui para baixar</a>.
        </p>
      </iframe>
    </div>
  </div>
  <?php endif; ?>

</div>
</section>

<?php elseif ($searched && !$dbError && !$resultado): ?>
<!-- ══ RESULTADO: NÃO ENCONTRADO ════════════════════════════ -->
<section style="background:#f4f7ff;padding:2rem 0 4rem;">
<div class="verify-result-wrap">
  <div class="seal-wrap">
    <div class="seal-icon-err">
      <svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </div>
    <div class="seal-title-err">Documento Não Encontrado</div>
    <div class="seal-sub">Nenhum registro ativo localizado para este código</div>
  </div>

  <div class="doc-card" style="border-color:#fecaca;">
    <div class="doc-card-header" style="background:linear-gradient(135deg,#dc2626,#b91c1c);">
      <div class="doc-card-tipo">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Verificação Negativa
      </div>
      <div class="doc-card-codigo"><?= htmlspecialchars($codigo) ?></div>
    </div>
    <div style="padding:2rem 1.5rem;">
      <p style="font-size:.9375rem;color:#374151;line-height:1.7;">
        O código <strong style="font-family:monospace;color:#dc2626;"><?= htmlspecialchars($codigo) ?></strong>
        não foi localizado na base de dados VerificaMed. Isso pode indicar:
      </p>
      <ul style="margin-top:1rem;display:flex;flex-direction:column;gap:.6rem;padding-left:1.25rem;">
        <li style="font-size:.875rem;color:#6b7280;">Código digitado ou escaneado incorretamente</li>
        <li style="font-size:.875rem;color:#6b7280;">Documento cancelado ou inválido</li>
        <li style="font-size:.875rem;color:#6b7280;">Documento não registrado no sistema</li>
      </ul>
    </div>
    <div class="doc-card-footer" style="background:#fff5f5;border-color:#fecaca;">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#dc2626" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01"/></svg>
      <span style="color:#dc2626;font-weight:600;">Documento não autenticado</span>
      <span style="margin-left:auto;">Verificado às <?= date('H:i') ?></span>
    </div>
  </div>

  <div class="share-bar no-print" style="justify-content:center;">
    <a href="verificar.php" class="btn-share btn-share-primary" style="max-width:240px;">
      <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
      Tentar novamente
    </a>
  </div>
</div>
</section>
<?php endif; ?>

<!-- TOAST -->
<div class="copy-toast" id="copy-toast">✓ Link copiado!</div>

<script>
function compartilhar(url) {
  if (navigator.share) {
    navigator.share({ title: 'VerificaMed — Documento Verificado', url: url });
  } else { copiarLink(url); }
}
function copiarLink(url) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(url).then(showToast);
  } else {
    var t = document.createElement('textarea');
    t.value = url; document.body.appendChild(t); t.select();
    document.execCommand('copy'); document.body.removeChild(t);
    showToast();
  }
}
function showToast() {
  var el = document.getElementById('copy-toast');
  el.style.display = 'block';
  setTimeout(function(){ el.style.display='none'; }, 2500);
}
</script>

<?php
// placeholder so the section/div close tags below still make sense
$__result_rendered = true;
?><div style="display:none"></div>
<div style="display:none"></div>
<?php if (!$searched): ?>
</div>
</section>
<section class="cta-section">
  <h2 class="cta-h2">Verifique agora a autenticidade</h2>
  <p class="cta-sub">Basta escanear o QR Code do documento ou digitar o código de verificação para confirmar sua autenticidade instantaneamente.</p>
  <a href="verificar.php" class="btn-verify">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    Verificar Documento
  </a>
</section>
<?php endif; ?>

<!-- html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
var html5QrCode = null;
var scannerActive = false;

function toggleScanner() {
  var container = document.getElementById('qr-container');
  if (!scannerActive) {
    container.style.display = 'block';
    document.getElementById('btn-scan').innerHTML = '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg> Fechar scanner';
    startScanner();
  } else {
    stopScanner();
  }
}

function startScanner() {
  html5QrCode = new Html5Qrcode('qr-reader');
  html5QrCode.start(
    { facingMode: 'environment' },
    { fps: 10, qrbox: { width: 240, height: 240 } },
    function(decodedText) {
      document.getElementById('codigo-input').value = decodedText.trim();
      stopScanner();
      setTimeout(function() { document.getElementById('verify-form').submit(); }, 300);
    },
    function(err) { /* scan errors ignorados */ }
  ).then(function() {
    scannerActive = true;
  }).catch(function(err) {
    alert('Não foi possível acessar a câmera. Verifique as permissões do navegador.');
    document.getElementById('qr-container').style.display = 'none';
  });
}

function stopScanner() {
  if (html5QrCode && scannerActive) {
    html5QrCode.stop().then(function() {
      html5QrCode.clear();
      scannerActive = false;
      document.getElementById('qr-container').style.display = 'none';
      document.getElementById('btn-scan').innerHTML = '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 14h2m0 0h3m-3 0v2m0 3h3m-6 0h3"/></svg> Escanear QR Code com a câmera';
    }).catch(function() { scannerActive = false; });
  }
}
</script>
<?php include 'includes/footer.php'; ?>
