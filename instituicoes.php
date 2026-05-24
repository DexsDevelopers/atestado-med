<?php $pageTitle = 'Instituições — VerificaMed'; ?>
<?php include 'includes/header.php'; ?>

<section class="hero-section" style="padding:3rem 1.5rem;">
  <div style="position:relative;z-index:1;">
    <h1 class="hero-h1" style="font-size:2rem;">Instituições Parceiras</h1>
    <p class="hero-sub">Hospitais, clínicas e empresas que utilizam o VerificaMed</p>
  </div>
</section>

<section class="section-light">
  <div class="section-wrap">
    <h2 class="section-title">Quem usa o VerificaMed?</h2>
    <p class="section-sub">Nossa plataforma é utilizada por milhares de instituições em todo o Brasil para validar documentos médicos com segurança e agilidade.</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-top:2rem;">
      <?php
      $tipos = [
        ['icon'=>'🏥','title'=>'Hospitais','desc'=>'Validação de atestados na admissão e gestão de afastamentos.'],
        ['icon'=>'🏪','title'=>'Empresas','desc'=>'Verificação de atestados de funcionários com segurança jurídica.'],
        ['icon'=>'🏛️','title'=>'Órgãos Públicos','desc'=>'Validação de documentos para concessão de benefícios.'],
        ['icon'=>'💊','title'=>'Farmácias','desc'=>'Conferência de autenticidade de receitas médicas.'],
        ['icon'=>'🏋️','title'=>'Academias','desc'=>'Verificação de laudos e atestados de aptidão física.'],
        ['icon'=>'🎓','title'=>'Universidades','desc'=>'Validação de atestados para abono de faltas.'],
      ];
      foreach ($tipos as $t): ?>
      <div class="feature-card">
        <div style="font-size:2rem;margin-bottom:.75rem;"><?= $t['icon'] ?></div>
        <div class="feature-title"><?= $t['title'] ?></div>
        <div class="feature-desc"><?= $t['desc'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-gray">
  <div class="section-wrap" style="max-width:640px;text-align:center;">
    <h2 class="section-title">Sua instituição quer se tornar parceira?</h2>
    <p class="section-sub">Entre em contato com nossa equipe e saiba como integrar o VerificaMed ao seu sistema.</p>
    <div style="background:#fff;border:1px solid #e8edf5;border-radius:1.25rem;padding:2rem;box-shadow:0 2px 12px rgba(37,99,235,0.07);">
      <div style="font-size:.875rem;color:#4b5563;margin-bottom:1rem;">Fale conosco:</div>
      <div style="font-size:1rem;font-weight:600;color:#2563eb;margin-bottom:.5rem;">suporte@verificamed.com.br</div>
      <div style="font-size:1rem;font-weight:600;color:#2563eb;">0800 123 4567</div>
    </div>
  </div>
</section>

<section class="cta-section">
  <h2 class="cta-h2">Verifique um documento agora</h2>
  <p class="cta-sub">Acesse nossa ferramenta de verificação e confirme a autenticidade de qualquer documento médico.</p>
  <a href="/verificar.php" class="btn-verify">
    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
    Verificar Documento
  </a>
</section>

<?php include 'includes/footer.php'; ?>
