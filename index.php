<?php $pageTitle = 'VerificaMed — Sistema Nacional de Verificação de Documentos Médicos'; ?>
<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero-section">
  <div style="position:relative;z-index:1;">
    <div class="hero-badge">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/></svg>
      Sistema Oficial de Verificação
    </div>
    <h1 class="hero-h1">Verificação de Documentos<br>Médicos em Tempo Real</h1>
    <p class="hero-sub">Sistema utilizado por hospitais, UPAs, prontos-socorros e clínicas em todo o Brasil para validar atestados e receitas médicas com total segurança.</p>
    <a href="verificar.php" class="btn-verify">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Verificar Documento
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </a>
  </div>
</section>

<!-- STATS -->
<section class="stats-section">
  <div class="stats-grid">
    <?php
    $stats = [
      ['path'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'value'=>'2.500+', 'label'=>'Unidades de Saúde'],
      ['path'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'value'=>'15M+', 'label'=>'Documentos Verificados'],
      ['path'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', 'value'=>'27', 'label'=>'Estados Atendidos'],
      ['path'=>'M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 0a4 4 0 11-4-4', 'value'=>'50k+', 'label'=>'Profissionais'],
    ];
    foreach ($stats as $s): ?>
    <div class="stat-card">
      <div class="stat-icon">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" color="#2563eb">
          <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s['path'] ?>"/>
        </svg>
      </div>
      <div class="stat-value"><?= $s['value'] ?></div>
      <div class="stat-label"><?= $s['label'] ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- TIPOS DE DOCUMENTOS -->
<section class="section-light">
  <div class="section-wrap text-center">
    <h2 class="section-title">Tipos de Documentos</h2>
    <p class="section-sub">Nosso sistema suporta a verificação de diversos tipos de documentos médicos, garantindo segurança em todas as modalidades.</p>
    <div class="doc-types-grid">
      <div class="doc-type-card">
        <div class="doc-type-icon blue">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
        </div>
        <div>
          <div class="doc-type-title">Atestados Médicos</div>
          <div class="doc-type-desc">Verificação de atestados de afastamento, comparecimento e aptidão.</div>
        </div>
      </div>
      <div class="doc-type-card">
        <div class="doc-type-icon green">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
          </svg>
        </div>
        <div>
          <div class="doc-type-title">Receitas Médicas</div>
          <div class="doc-type-desc">Validação de receitas simples, especiais e de controle especial.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- POR QUE USAR -->
<section class="section-gray">
  <div class="section-wrap text-center">
    <div>
      <span class="section-badge">
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Cobertura Nacional
      </span>
    </div>
    <h2 class="section-title">Por que usar o VerificaMed?</h2>
    <p class="section-sub">Tecnologia de ponta para garantir a autenticidade dos documentos médicos em todo o território brasileiro.</p>
    <div class="features-grid">
      <?php
      $features = [
        ['title'=>'QR Code Único',        'desc'=>'Cada documento recebe um código exclusivo criptografado para verificação instantânea.',
         'path'=>'M3 4h4v4H3zM3 10h4v4H3zM10 3h4v4h-4zM17 3h4v4h-4zM17 10h4v4h-4zM10 17h4v4h-4zM17 17h4v4h-4zM3 17h4v4H3zM10 10h4v4h-4z'],
        ['title'=>'Validação em Segundos','desc'=>'Confirme a autenticidade de atestados e receitas em menos de 5 segundos.',
         'path'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['title'=>'Segurança Total',      'desc'=>'Sistema certificado com criptografia de ponta a ponta contra fraudes.',
         'path'=>'M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
        ['title'=>'LGPD Compliant',       'desc'=>'Dados protegidos seguindo todas as normas da Lei Geral de Proteção de Dados.',
         'path'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
      ];
      foreach ($features as $f): ?>
      <div class="feature-card">
        <div class="feature-icon">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="<?= $f['path'] ?>"/>
          </svg>
        </div>
        <div class="feature-title"><?= $f['title'] ?></div>
        <div class="feature-desc"><?= $f['desc'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <h2 class="cta-h2">Verifique agora a autenticidade</h2>
  <p class="cta-sub">Basta escanear o QR Code do documento ou digitar o código de verificação para confirmar sua autenticidade instantaneamente.</p>
  <a href="verificar.php" class="btn-verify">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    Verificar Documento
  </a>
</section>

<?php include 'includes/footer.php'; ?>
