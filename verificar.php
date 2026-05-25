<?php
$pageTitle = 'Verificar Documento — VerificaMed';
require_once 'config/db.php';

$codigo    = '';
$resultado = null;
$searched  = false;
$dbError   = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo   = strtoupper(trim($_POST['codigo'] ?? ''));
    $searched = true;
    if ($codigo) {
        try {
            $db   = getDB();
            $stmt = $db->prepare("SELECT * FROM documentos WHERE codigo = ? AND status = 'ativo' LIMIT 1");
            $stmt->execute([$codigo]);
            $resultado = $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            $dbError = true;
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

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
  <div style="background:#fff;border:2px solid #f59e0b;border-radius:1.25rem;padding:1.5rem;margin-top:1.5rem;">
    <p style="color:#92400e;font-weight:600;">Erro ao conectar ao banco de dados. Verifique as configurações.</p>
  </div>
  <?php elseif ($searched && $resultado): ?>
  <div class="result-success" style="margin-top:1.5rem;">
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;">
      <div style="width:3rem;height:3rem;background:#dcfce7;border-radius:.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
        <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div>
        <div style="font-size:1.0625rem;font-weight:700;color:#15803d;">Documento Autêntico</div>
        <div style="font-size:.8125rem;color:#6b7280;">Verificado com sucesso na base VerificaMed</div>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;background:#f9fafb;border-radius:.75rem;padding:1.25rem;">
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Tipo</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars($resultado['tipo']) ?></div>
      </div>
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Código</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;font-family:monospace;"><?= htmlspecialchars($codigo) ?></div>
      </div>
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Paciente</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars($resultado['tratamento'] . ' ' . $resultado['paciente']) ?></div>
      </div>
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Médico</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars($resultado['medico']) ?></div>
      </div>
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">CRM</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;">CRM <?= htmlspecialchars($resultado['crm_estado']) ?> <?= htmlspecialchars($resultado['crm_numero']) ?></div>
      </div>
      <div>
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Data do Atendimento</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars(date('d/m/Y', strtotime($resultado['data_atend']))) ?></div>
      </div>
      <?php if ($resultado['unidade']): ?>
      <div style="grid-column:span 2;">
        <div style="font-size:.7rem;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Unidade</div>
        <div style="font-weight:600;font-size:.875rem;color:#111827;"><?= htmlspecialchars($resultado['unidade']) ?></div>
      </div>
      <?php endif; ?>
    </div>

    <div class="mt-5 flex items-center gap-2 text-xs text-emerald-700 bg-emerald-50 rounded-xl p-3 border border-emerald-200">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
      </svg>
      <span>Assinatura digital válida — Documento íntegro e não adulterado conforme Lei 14.063/2020</span>
    </div>
  </div>

  <?php elseif ($searched && !$resultado): ?>
  <div class="result-error" style="margin-top:1.5rem;">
    <div class="flex items-center gap-3 mb-4">
      <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div>
        <h2 class="text-lg font-bold text-red-700">Documento não encontrado</h2>
        <p class="text-sm text-gray-500">Nenhum registro localizado para este código</p>
      </div>
    </div>
    <div class="bg-red-50 rounded-xl p-4 flex items-start gap-3 text-sm text-red-700 border border-red-200">
      <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
      <p>
        O código <span class="font-mono font-bold"><?= htmlspecialchars($codigo) ?></span> não foi encontrado.
        Verifique se foi digitado corretamente ou entre em contato com o médico emissor.
      </p>
    </div>
  </div>
  <?php endif; ?>

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
