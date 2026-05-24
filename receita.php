<?php
$pageTitle = 'Receita Médica — Verificamed';
$submitted = false;
$data = [];
$meds = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nomePaciente'   => trim($_POST['nomePaciente']   ?? ''),
        'cpfPaciente'    => trim($_POST['cpfPaciente']    ?? ''),
        'dataNascimento' => trim($_POST['dataNascimento'] ?? ''),
        'nomeMedico'     => trim($_POST['nomeMedico']     ?? ''),
        'crmMedico'      => trim($_POST['crmMedico']      ?? ''),
        'especialidade'  => trim($_POST['especialidade']  ?? ''),
        'dataEmissao'    => trim($_POST['dataEmissao']    ?? ''),
        'validade'       => trim($_POST['validade']       ?? ''),
        'observacoes'    => trim($_POST['observacoes']    ?? ''),
    ];
    $nomes = $_POST['med_nome']      ?? [];
    $doses = $_POST['med_dose']      ?? [];
    $posols= $_POST['med_posologia'] ?? [];
    $qtds  = $_POST['med_qtd']       ?? [];
    foreach ($nomes as $i => $nome) {
        if (trim($nome)) {
            $meds[] = [
                'nome'      => trim($nome),
                'dose'      => trim($doses[$i]  ?? ''),
                'posologia' => trim($posols[$i] ?? ''),
                'qtd'       => trim($qtds[$i]   ?? ''),
            ];
        }
    }
    if ($data['nomePaciente'] && $data['nomeMedico'] && $data['crmMedico'] && count($meds) > 0) {
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
  <h2 class="text-2xl font-bold text-gray-900 mb-2">Receita emitida com sucesso!</h2>
  <p class="text-gray-500 mb-8">Código: <strong class="font-mono text-emerald-700"><?= htmlspecialchars($codigo) ?></strong></p>

  <div class="doc-preview text-left mb-8">
    <div class="text-center border-b-2 border-gray-300 pb-5 mb-6">
      <h2 class="text-2xl font-bold tracking-wide uppercase">RECEITA MÉDICA</h2>
      <p class="text-xs text-gray-500 mt-1">Documento com validade jurídica — Verificamed | Cód: <?= htmlspecialchars($codigo) ?></p>
    </div>

    <div class="mb-4">
      <p class="text-xs text-gray-500 uppercase tracking-wider mb-2 font-sans">Dados do Paciente</p>
      <div class="bg-gray-50 rounded-lg p-3 grid grid-cols-2 gap-2 text-xs font-sans">
        <div><span class="text-gray-500">Nome:</span> <strong><?= htmlspecialchars($data['nomePaciente']) ?></strong></div>
        <div><span class="text-gray-500">CPF:</span> <strong><?= htmlspecialchars($data['cpfPaciente'] ?: '—') ?></strong></div>
        <div><span class="text-gray-500">Nascimento:</span> <strong><?= htmlspecialchars($data['dataNascimento'] ?: '—') ?></strong></div>
      </div>
    </div>

    <div class="mb-6">
      <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 font-sans">Prescrição</p>
      <ol class="flex flex-col gap-4">
        <?php foreach ($meds as $i => $m): ?>
        <li class="flex gap-3">
          <span class="font-black text-emerald-400 text-xl leading-none"><?= $i + 1 ?>.</span>
          <div>
            <p class="font-bold"><?= htmlspecialchars($m['nome']) ?></p>
            <?php if ($m['dose']): ?><p class="text-xs text-gray-600">Dose: <?= htmlspecialchars($m['dose']) ?></p><?php endif; ?>
            <?php if ($m['posologia']): ?><p class="text-xs text-gray-600">Posologia: <?= htmlspecialchars($m['posologia']) ?></p><?php endif; ?>
            <?php if ($m['qtd']): ?><p class="text-xs text-gray-600">Quantidade: <?= htmlspecialchars($m['qtd']) ?></p><?php endif; ?>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <?php if ($data['observacoes']): ?>
    <p class="text-xs italic text-gray-600 mb-4 font-sans">Obs: <?= htmlspecialchars($data['observacoes']) ?></p>
    <?php endif; ?>

    <div class="border-t border-gray-200 mt-6 pt-5 text-center font-sans">
      <div class="w-40 border-b border-gray-700 mx-auto mb-1"></div>
      <p class="text-xs font-semibold"><?= htmlspecialchars($data['nomeMedico']) ?></p>
      <p class="text-xs text-gray-500">CRM <?= htmlspecialchars($data['crmMedico']) ?></p>
      <?php if ($data['especialidade']): ?><p class="text-xs text-gray-400"><?= htmlspecialchars($data['especialidade']) ?></p><?php endif; ?>
      <p class="text-xs text-gray-400 mt-2">Data: <?= htmlspecialchars($data['dataEmissao']) ?></p>
      <?php if ($data['validade']): ?><p class="text-xs text-gray-400">Válida até: <?= htmlspecialchars($data['validade']) ?></p><?php endif; ?>
    </div>
    <div class="flex justify-center mt-6">
      <div class="w-16 h-16 bg-gray-100 border border-gray-300 rounded flex items-center justify-center text-xs text-gray-400 text-center">QR Code<br>verificação</div>
    </div>
  </div>

  <div class="flex flex-col sm:flex-row gap-3 justify-center no-print">
    <button onclick="printDoc()" class="btn-green">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
      Imprimir / Salvar PDF
    </button>
    <a href="/receita.php" class="btn-gray">Nova Receita</a>
  </div>
</div>

<?php else: ?>
<!-- FORM -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
  <div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
      <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-gray-900">Receita Médica</h1>
    </div>
    <p class="text-gray-500">Preencha os dados para emitir uma receita médica digital.</p>
  </div>

  <div class="flex gap-2 mb-6">
    <button id="tab-form"    onclick="switchTab('form','receita-form','receita-preview','bg-emerald-600 text-white')"
      class="px-5 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white">Formulário</button>
    <button id="tab-preview" onclick="switchTab('preview','receita-form','receita-preview','bg-emerald-600 text-white')"
      class="px-5 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200">Pré-visualização</button>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <form method="POST" action="/receita.php" id="receita-form" class="flex flex-col gap-5">

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
            <input id="especialidade" name="especialidade" class="input-field" placeholder="ex: Cardiologista">
          </div>
        </div>
      </div>

      <!-- Medications -->
      <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
          <h3 class="font-semibold text-gray-900">Medicamentos <span class="text-red-500">*</span></h3>
          <button type="button" id="add-med-btn" class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Adicionar
          </button>
        </div>
        <div id="meds-container" class="flex flex-col gap-5">
          <div class="bg-gray-50 rounded-xl p-4" id="med-1">
            <div class="flex items-center justify-between mb-3">
              <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Medicamento 1</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div class="flex flex-col gap-1">
                <label class="text-sm font-medium text-gray-700">Nome <span class="text-red-500">*</span></label>
                <input class="input-field" placeholder="ex: Amoxicilina 500mg" name="med_nome[]">
              </div>
              <div class="flex flex-col gap-1">
                <label class="text-sm font-medium text-gray-700">Dose</label>
                <input class="input-field" placeholder="ex: 500mg" name="med_dose[]">
              </div>
              <div class="flex flex-col gap-1">
                <label class="text-sm font-medium text-gray-700">Posologia</label>
                <input class="input-field" placeholder="ex: 1 comp 8/8h" name="med_posologia[]">
              </div>
              <div class="flex flex-col gap-1">
                <label class="text-sm font-medium text-gray-700">Quantidade</label>
                <input class="input-field" placeholder="ex: 21 comprimidos" name="med_qtd[]">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white border border-gray-200 rounded-2xl p-6">
        <h3 class="font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100">Informações Adicionais</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Data de emissão <span class="text-red-500">*</span></label>
            <input id="dataEmissao" name="dataEmissao" type="date" class="input-field" value="<?= $today ?>" required>
          </div>
          <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-gray-700">Válida até</label>
            <input id="validade" name="validade" type="date" class="input-field">
          </div>
          <div class="flex flex-col gap-1 sm:col-span-2">
            <label class="text-sm font-medium text-gray-700">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="3" class="input-field resize-none" placeholder="Recomendações adicionais (opcional)"></textarea>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p>Receita emitida com validade jurídica conforme a Lei 14.063/2020. Verifique todos os dados antes de emitir.</p>
      </div>

      <button type="submit" class="btn-green w-full py-3.5 text-base">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Gerar Receita
      </button>
    </form>

    <!-- Live Preview -->
    <div id="receita-preview" class="hidden lg:block">
      <p class="text-xs text-gray-400 mb-3 font-medium uppercase tracking-wider">Pré-visualização do documento</p>
      <div class="doc-preview">
        <div class="text-center border-b-2 border-gray-300 pb-5 mb-6">
          <h2 class="text-2xl font-bold tracking-wide uppercase">RECEITA MÉDICA</h2>
          <p class="text-xs text-gray-500 mt-1">Documento com validade jurídica — Verificamed</p>
        </div>
        <div class="mb-4">
          <p class="text-xs text-gray-500 uppercase tracking-wider mb-2 font-sans">Dados do Paciente</p>
          <div class="bg-gray-50 rounded-lg p-3 grid grid-cols-2 gap-2 text-xs font-sans">
            <div><span class="text-gray-500">Nome:</span> <strong><span id="prev-nomePaciente">—</span></strong></div>
            <div><span class="text-gray-500">CPF:</span> <strong><span id="prev-cpfPaciente">—</span></strong></div>
            <div><span class="text-gray-500">Nascimento:</span> <strong><span id="prev-dataNascimento">—</span></strong></div>
          </div>
        </div>
        <div class="mb-6">
          <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 font-sans">Prescrição</p>
          <div id="prev-meds"><p class="text-gray-400 italic text-xs">Nenhum medicamento adicionado.</p></div>
        </div>
        <p id="prev-observacoes-wrap" class="text-xs italic text-gray-600 mb-4 font-sans hidden">Obs: <span id="prev-observacoes"></span></p>
        <div class="border-t border-gray-200 mt-6 pt-5 text-center font-sans">
          <div class="w-40 border-b border-gray-700 mx-auto mb-1"></div>
          <p class="text-xs font-semibold"><span id="prev-nomeMedico">Nome do Médico</span></p>
          <p class="text-xs text-gray-500">CRM <span id="prev-crmMedico">——</span></p>
          <p class="text-xs text-gray-400"><span id="prev-especialidade"></span></p>
          <p class="text-xs text-gray-400 mt-2">Data: <span id="prev-dataEmissao"><?= $today ?></span></p>
          <p id="prev-validade-wrap" class="text-xs text-gray-400 hidden">Válida até: <span id="prev-validade"></span></p>
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
