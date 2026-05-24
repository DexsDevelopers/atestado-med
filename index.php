<?php $pageTitle = 'Verificamed — Atestados e Receitas Médicas Digitais'; ?>
<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="relative overflow-hidden gradient-bg py-24 md:py-32">
  <div class="absolute inset-0 hero-pattern"></div>
  <div class="relative max-w-6xl mx-auto px-4 sm:px-6 text-center">
    <span class="inline-flex items-center gap-2 bg-white/20 text-white text-sm font-medium px-4 py-1.5 rounded-full mb-6">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Documentos com validade jurídica
    </span>
    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
      Atestados e Receitas<br>
      <span class="text-sky-200">Médicas Digitais</span>
    </h1>
    <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10">
      Emita, assine e compartilhe documentos médicos com segurança, agilidade e validade jurídica reconhecida em todo o Brasil.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="/atestado.php" class="btn-white">
        Emitir Atestado
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
      <a href="/receita.php" class="btn-ghost">
        Emitir Receita
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="bg-white border-b border-gray-100">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <?php
      $stats = [
        ['icon'=>'users',  'value'=>'50.000+', 'label'=>'Documentos emitidos'],
        ['icon'=>'shield', 'value'=>'99,9%',   'label'=>'Disponibilidade'],
        ['icon'=>'star',   'value'=>'4,9/5',   'label'=>'Avaliação dos usuários'],
        ['icon'=>'zap',    'value'=>'< 30s',   'label'=>'Tempo de emissão'],
      ];
      $icons = [
        'users'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-4-4"/>',
        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'star'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
        'zap'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
      ];
      foreach ($stats as $s): ?>
      <div class="flex flex-col items-center text-center gap-1">
        <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center mb-1">
          <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <?= $icons[$s['icon']] ?>
          </svg>
        </div>
        <span class="text-2xl font-extrabold text-gray-900"><?= $s['value'] ?></span>
        <span class="text-sm text-gray-500"><?= $s['label'] ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Tudo que você precisa em um só lugar</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Plataforma completa para médicos e pacientes gerenciarem documentos médicos digitais com segurança.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
      $features = [
        ['href'=>'/atestado.php','color'=>'text-blue-600 bg-blue-50',   'title'=>'Atestado Médico Digital',
         'desc'=>'Emita atestados médicos com validade jurídica, assinatura digital e QR Code de verificação.',
         'path'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['href'=>'/receita.php', 'color'=>'text-emerald-600 bg-emerald-50','title'=>'Receita Médica Digital',
         'desc'=>'Gere receitas médicas digitais seguras, reconhecidas por farmácias em todo o Brasil.',
         'path'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
        ['href'=>'/verificar.php','color'=>'text-purple-600 bg-purple-50','title'=>'Verificação de Autenticidade',
         'desc'=>'Valide qualquer documento emitido pela plataforma de forma rápida e segura.',
         'path'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
      ];
      foreach ($features as $f): ?>
      <a href="<?= $f['href'] ?>" class="group bg-white rounded-2xl p-8 card-shadow border border-gray-100 hover:border-primary-200 hover:-translate-y-1 transition-all block no-underline">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5 <?= $f['color'] ?>">
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="<?= $f['path'] ?>"/>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2"><?= $f['title'] ?></h3>
        <p class="text-gray-500 text-sm leading-relaxed"><?= $f['desc'] ?></p>
        <span class="mt-4 inline-flex items-center gap-1 text-primary-600 text-sm font-semibold">
          Saiba mais
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-20 bg-white">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Como funciona?</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Em menos de 30 segundos você emite um documento médico com total validade jurídica.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php
      $steps = [
        ['n'=>'01','title'=>'Preencha os dados',      'desc'=>'Informe os dados do paciente e do médico responsável.'],
        ['n'=>'02','title'=>'Assine digitalmente',     'desc'=>'O documento é assinado eletronicamente com certificado válido.'],
        ['n'=>'03','title'=>'Envie ao paciente',       'desc'=>'Compartilhe o documento por e-mail, WhatsApp ou link direto.'],
        ['n'=>'04','title'=>'Verificação instantânea', 'desc'=>'Qualquer pessoa pode verificar a autenticidade pelo QR Code.'],
      ];
      foreach ($steps as $s): ?>
      <div class="bg-gradient-to-br from-primary-50 to-white rounded-2xl p-6 border border-primary-100">
        <span class="text-4xl font-black text-primary-200 leading-none"><?= $s['n'] ?></span>
        <h4 class="text-base font-bold text-gray-900 mt-2 mb-1"><?= $s['title'] ?></h4>
        <p class="text-sm text-gray-500 leading-relaxed"><?= $s['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6">
    <div class="text-center mb-14">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">O que dizem os médicos</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Milhares de profissionais de saúde já confiam no Verificamed.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
      $testimonials = [
        ['name'=>'Dr. Carlos Mendes',  'role'=>'Clínico Geral — São Paulo, SP',       'text'=>'Uso o Verificamed diariamente no meu consultório. A praticidade de emitir atestados e receitas digitais transformou minha rotina.'],
        ['name'=>'Dra. Ana Beatriz',   'role'=>'Pediatra — Belo Horizonte, MG',       'text'=>'Meus pacientes adoram receber os documentos pelo WhatsApp. A verificação por QR Code passou confiança para todos.'],
        ['name'=>'Dr. Roberto Lima',   'role'=>'Ortopedista — Rio de Janeiro, RJ',    'text'=>'Finalmente uma plataforma simples, rápida e com total validade jurídica. Recomendo a todos os colegas.'],
      ];
      foreach ($testimonials as $t): ?>
      <div class="bg-white rounded-2xl p-6 card-shadow border border-gray-100">
        <div class="flex gap-1 mb-4">
          <?php for ($i=0;$i<5;$i++): ?>
          <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <?php endfor; ?>
        </div>
        <p class="text-gray-600 text-sm leading-relaxed mb-5">"<?= htmlspecialchars($t['text']) ?>"</p>
        <div>
          <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($t['name']) ?></p>
          <p class="text-gray-400 text-xs"><?= htmlspecialchars($t['role']) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="gradient-bg py-20">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Pronto para modernizar seu consultório?</h2>
    <p class="text-blue-100 mb-8 text-lg">Comece agora e emita seu primeiro documento em menos de 1 minuto.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="/atestado.php" class="btn-white">
        Emitir Atestado
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
      <a href="/receita.php" class="btn-ghost">
        Emitir Receita
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
