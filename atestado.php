<?php
$pageTitle = 'Atestado Médico — Verificamed';
$submitted = false;
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nomePaciente'   => trim($_POST['nomePaciente']   ?? ''),
        'cpfPaciente'    => trim($_POST['cpfPaciente']    ?? ''),
        'dataNascimento' => trim($_POST['dataNascimento'] ?? ''),
        'nomeMedico'     => trim($_POST['nomeMedico']     ?? ''),
        'crmMedico'      => trim($_POST['crmMedico']      ?? ''),
        'especialidade'  => trim($_POST['especialidade']  ?? ''),
        'diasAfastamento'=> trim($_POST['diasAfastamento']?? ''),
        'dataEmissao'    => trim($_POST['dataEmissao']    ?? ''),
        'cid'            => trim($_POST['cid']            ?? ''),
        'observacoes'    => trim($_POST['observacoes']    ?? ''),
    ];
    if ($data['nomePaciente'] && $data['nomeMedico'] && $data['crmMedico'] && $data['diasAfastamento']) {
        $submitted = true;
        $codigo = 'VM-' . date('Y') . '-' . str_pad(rand(1, 99999), 6, '0', STR_PAD_LEFT);
    }
}
$today = date('Y-m-d');
?>
<?php include 'includes/header.php'; ?>

<?php if ($submitted): ?>
<!-- SUCCESS STATE -->
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-16 text-center">
  <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
    <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
  </div>
  <h2 class="text-2xl font-bold text-gray-900 mb-2">Atestado emitido com sucesso!</h2>
  <p class="text-gray-500 mb-8">Código: <strong class="font-mono text-primary-700"><?= htmlspecialchars($codigo) ?></strong></p>

  <!-- Document preview -->
  <div class="doc-preview text-left mb-8" id="doc-print">
    <div class="text-center border-b-2 border-gray-300 pb-5 mb-6">
      <h2 class="text-2xl font-bold tracking-wide uppercase">ATESTADO MÉDICO</h2>
      <p class="text-xs text-gray-500 mt-1">Documento com validade jurídica — Verificamed | Cód: <?= htmlspecialchars($codigo) ?></p>
    </div>
    <p class="mb-4">
      Eu, <strong><?= htmlspecialchars($data['nomeMedico']) ?></strong>,
      médico(a) inscrito(a) no CRM <strong><?= htmlspecialchars($data['crmMedico']) ?></strong><?= $data['especialidade'] ? ', especialidade ' . htmlspecialchars($data['especialidade']) : '' ?>,
      atesto para os devidos fins que o(a) paciente
    </p>
    <div class="bg-gray-50 rounded-lg p-4 mb-4 grid grid-cols-2 gap-3 text-xs font-sans">
      <div><span class="text-gray-500">Nome:</span> <strong><?= htmlspecialchars($data['nomePaciente']) ?></strong></div>
      <div><span class="text-gray-500">CPF:</span> <strong><?= htmlspecialchars($data['cpfPaciente'] ?: '—') ?></strong></div>
      <div><span class="text-gray-500">Nascimento:</span> <strong><?= htmlspecialchars($data['dataNascimento'] ?: '—') ?></strong></div>
      <div><span class="text-gray-500">CID:</span> <strong><?= htmlspecialchars($data['cid'] ?: '—') ?></strong></div>
    </div>
    <p class="mb-4">
      necessita de afastamento de suas atividades pelo período de
      <strong><?= htmlspecialchars($data['diasAfastamento']) ?> dia(s)</strong>,
      a contar da data de emissão deste documento.
    </p>
    <?php if ($data['observacoes']): ?>
    <p class="mb-4 italic text-gray-600">Observações: <?= htmlspecialchars($data['observacoes']) ?></p>
    <?php endif; ?>
    <div class="border-t border-gray-200 mt-8 pt-5 text-center font-sans">
      <div class="w-40 border-b border-gray-700 mx-auto mb-1"></div>
      <p class="text-xs font-semibold"><?= htmlspecialchars($data['nomeMedico']) ?></p>
      <p class="text-xs text-gray-500">CRM <?= htmlspecialchars($data['crmMedico']) ?></p>
      <p class="text-xs text-gray-400 mt-3">Data de Emissão: <?= htmlspecialchars($data['dataEmissao']) ?></p>
    </div>
    <div class="flex justify-center mt-6">
      <div class="w-16 h-16 bg-gray-100 border border-gray-300 rounded flex items-center justify-center text-xs text-gray-400 text-center">QR Code<br>verificação</div>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row gap-3 justify-center no-print">
    <button onclick="printDoc()" class="btn-primary">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
      Imprimir / Salvar PDF
    </button>
    <a href="/atestado.php" class="btn-gray">Novo Atestado</a>
  </div>
</div>

<?php else: ?>
<!-- FORM -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
  <div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
      <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-900">Atestado Médico</h1>
    </div>
    <p class="text-gray-500">Preencha os dados abaixo para gerar o atestado médico digital.</p>
  </div>

  <div class="flex gap-2 mb-6">
    <button id="tab-form"    onclick="switchTab('form','atestado-form','atestado-preview','bg-primary-600 text-white')"
      class="px-5 py-2 rounded-lg text-sm font-semibold bg-primary-600 text-white">Formulário</button>
    <button id="tab-preview" onclick="switchTab('preview','atestado-form','atestado-preview','bg-primary-600 text-white')"
      class="px-5 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">Pré-visualização</button>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Left: Form -->
    <form method="POST" action="/atestado.php" id="atestado-form" class="flex flex-col gap-5">

      <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <h3 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Dados do Paciente</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Nome completo <span class="text-red-500">*</span></label>
            <input id="nomePaciente" name="nomePaciente" class="input-field" placeholder="Nome do paciente" required>
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">CPF</label>
            <input id="cpfPaciente" name="cpfPaciente" class="input-field" placeholder="000.000.000-00">
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Data de nascimento</label>
            <input id="dataNascimento" name="dataNascimento" type="date" class="input-field">
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">CID (opcional)</label>
            <input id="cid" name="cid" class="input-field" placeholder="ex: Z76.0">
          </div>
        </div>
      </div>

      <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <h3 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Dados do Médico</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Nome do médico <span class="text-red-500">*</span></label>
            <input id="nomeMedico" name="nomeMedico" class="input-field" placeholder="Dr(a). Nome" required>
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">CRM <span class="text-red-500">*</span></label>
            <input id="crmMedico" name="crmMedico" class="input-field" placeholder="CRM/UF 000000" required>
          </div>
          <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-sm font-medium text-gray-700">Especialidade</label>
            <input id="especialidade" name="especialidade" class="input-field" placeholder="ex: Clínico Geral">
          </div>
        </div>
      </div>

      <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <h3 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Dados do Atestado</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Dias de afastamento <span class="text-red-500">*</span></label>
            <input id="diasAfastamento" name="diasAfastamento" type="number" min="1" class="input-field" placeholder="ex: 3" required>
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Data de emissão <span class="text-red-500">*</span></label>
            <input id="dataEmissao" name="dataEmissao" type="date" class="input-field" value="<?= $today ?>" required>
          </div>
          <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-sm font-medium text-gray-700">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="3" class="input-field resize-none" placeholder="Informações adicionais (opcional)"></textarea>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p>Este documento possui validade jurídica conforme a Lei 14.063/2020. Certifique-se de que todas as informações estão corretas.</p>
      </div>

      <button type="submit" class="btn-primary w-full py-3.5 text-base">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Gerar Atestado
      </button>
    </form>

    <!-- Right: Live Preview -->
    <div id="atestado-preview" class="hidden lg:block">
      <p class="text-xs text-gray-400 mb-3 font-medium uppercase tracking-wider">Pré-visualização do documento</p>
      <div class="doc-preview">
        <div class="text-center border-b-2 border-gray-300 pb-5 mb-6">
          <h2 class="text-2xl font-bold tracking-wide uppercase">ATESTADO MÉDICO</h2>
          <p class="text-xs text-gray-500 mt-1">Documento com validade jurídica — Verificamed</p>
        </div>
        <p class="mb-4">
          Eu, <strong><span id="prev-nomeMedico">________________________</span></strong>,
          médico(a) inscrito(a) no CRM <strong><span id="prev-crmMedico">______</span></strong><span id="prev-especialidade">,</span>
          atesto para os devidos fins que o(a) paciente
        </p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 grid grid-cols-2 gap-3 text-xs font-sans">
          <div><span class="text-gray-500">Nome:</span> <strong><span id="prev-nomePaciente">—</span></strong></div>
          <div><span class="text-gray-500">CPF:</span> <strong><span id="prev-cpfPaciente">—</span></strong></div>
          <div><span class="text-gray-500">Nascimento:</span> <strong><span id="prev-dataNascimento">—</span></strong></div>
          <div><span class="text-gray-500">CID:</span> <strong><span id="prev-cid">—</span></strong></div>
        </div>
        <p class="mb-4">
          necessita de afastamento de suas atividades pelo período de
          <strong><span id="prev-dias">___ dia(s)</span></strong>, a contar da data de emissão.
        </p>
        <p id="prev-observacoes-wrap" class="mb-4 italic text-gray-600 hidden">Observações: <span id="prev-observacoes"></span></p>
        <div class="border-t border-gray-200 mt-8 pt-5 text-center font-sans">
          <div class="w-40 border-b border-gray-700 mx-auto mb-1"></div>
          <p class="text-xs font-semibold"><span id="prev-nomeMedico2">Nome do Médico</span></p>
          <p class="text-xs text-gray-500">CRM <span id="prev-crmMedico2">——</span></p>
          <p class="text-xs text-gray-400 mt-3">Data: <span id="prev-dataEmissao"><?= $today ?></span></p>
        </div>
        <div class="flex justify-center mt-6">
          <div class="w-16 h-16 bg-gray-100 border border-gray-300 rounded flex items-center justify-center text-xs text-gray-400 text-center">QR Code<br>verificação</div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
