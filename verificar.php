<?php
$pageTitle = 'Verificar Documento — VerificaMed';

$mockDocs = [
    'VM-2024-001234' => [
        'tipo'       => 'Atestado Médico',
        'paciente'   => 'João da Silva',
        'medico'     => 'Dr. Carlos Mendes',
        'crm'        => 'CRM/SP 123456',
        'emissao'    => '10/11/2024',
    ],
    'VM-2024-005678' => [
        'tipo'       => 'Receita Médica',
        'paciente'   => 'Maria Oliveira',
        'medico'     => 'Dra. Ana Beatriz',
        'crm'        => 'CRM/MG 654321',
        'emissao'    => '08/11/2024',
    ],
];

$codigo   = '';
$resultado = null;
$searched  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo   = strtoupper(trim($_POST['codigo'] ?? ''));
    $searched = true;
    if ($codigo && isset($mockDocs[$codigo])) {
        $resultado = $mockDocs[$codigo];
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
    <form method="POST" action="/verificar.php" style="display:flex;gap:.75rem;flex-wrap:wrap;">
      <input
        type="text"
        name="codigo"
        value="<?= htmlspecialchars($codigo) ?>"
        placeholder="Ex: VM-2024-001234"
        class="input-field"
        style="flex:1;min-width:200px;font-family:monospace;"
        required
      />
      <button type="submit" style="display:inline-flex;align-items:center;gap:.5rem;background:#2563eb;color:#fff;font-weight:600;padding:.75rem 1.5rem;border-radius:.625rem;border:none;cursor:pointer;font-size:.9rem;transition:background .15s;white-space:nowrap;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Verificar
      </button>
    </form>
    <p class="text-xs text-gray-400 mt-3 text-center">
      Teste com: <span class="font-mono font-semibold text-gray-600">VM-2024-001234</span>
      ou <span class="font-mono font-semibold text-gray-600">VM-2024-005678</span>
    </p>
  </div>

  <?php if ($searched && $resultado): ?>
  <div class="result-success" style="margin-top:1.5rem;">
    <div class="flex items-center gap-3 mb-6">
      <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div>
        <h2 class="text-lg font-bold text-emerald-700">Documento Autêntico</h2>
        <p class="text-sm text-gray-500">Verificado com sucesso na base Verificamed</p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 rounded-xl p-5">
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tipo de Documento</p>
        <div class="flex items-center gap-2">
          <?php if ($resultado['tipo'] === 'Atestado Médico'): ?>
          <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          <?php else: ?>
          <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          <?php endif; ?>
          <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($resultado['tipo']) ?></p>
        </div>
      </div>
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Código</p>
        <p class="font-mono font-semibold text-gray-900 text-sm"><?= htmlspecialchars($codigo) ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Paciente</p>
        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($resultado['paciente']) ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Médico Responsável</p>
        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($resultado['medico']) ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">CRM</p>
        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($resultado['crm']) ?></p>
      </div>
      <div>
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Data de Emissão</p>
        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($resultado['emissao']) ?></p>
      </div>
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
  <a href="/verificar.php" class="btn-verify">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    Verificar Documento
  </a>
</section>

<?php include 'includes/footer.php'; ?>
