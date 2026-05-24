<?php $pageTitle = 'Sobre — VerificaMed'; ?>
<?php include 'includes/header.php'; ?>

<section class="hero-section" style="padding:3rem 1.5rem;">
  <div style="position:relative;z-index:1;">
    <h1 class="hero-h1" style="font-size:2rem;">Sobre o VerificaMed</h1>
    <p class="hero-sub">Sistema Nacional de Verificação de Documentos Médicos</p>
  </div>
</section>

<section class="section-light">
  <div class="section-wrap" style="max-width:760px;">
    <h2 class="section-title" style="text-align:left;">Nossa Missão</h2>
    <p style="color:#4b5563;line-height:1.8;margin-bottom:1.5rem;font-size:0.9375rem;">
      O VerificaMed é o sistema oficial de verificação de documentos médicos do Brasil. Nossa plataforma foi desenvolvida para garantir a autenticidade de atestados e receitas médicas em todo o território nacional, combatendo fraudes e protegendo pacientes, empresas e instituições de saúde.
    </p>
    <p style="color:#4b5563;line-height:1.8;margin-bottom:1.5rem;font-size:0.9375rem;">
      Utilizamos tecnologia de criptografia avançada e QR Codes únicos para que qualquer pessoa possa verificar, em segundos, se um documento médico é autêntico — de qualquer dispositivo, a qualquer hora.
    </p>

    <h2 class="section-title" style="text-align:left;margin-top:2.5rem;">Por que o VerificaMed?</h2>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1.5rem;">
      <?php
      $items = [
        ['t'=>'Cobertura Nacional','d'=>'Presente em todos os 27 estados do Brasil.'],
        ['t'=>'Tecnologia Segura','d'=>'Criptografia de ponta a ponta em todos os documentos.'],
        ['t'=>'LGPD Compliant','d'=>'Dados protegidos conforme a Lei Geral de Proteção de Dados.'],
        ['t'=>'Verificação Instantânea','d'=>'Resultado em menos de 5 segundos via QR Code ou código.'],
      ];
      foreach ($items as $i): ?>
      <div style="background:#f4f7ff;border-radius:.75rem;padding:1.25rem;">
        <div style="font-weight:700;color:#111827;margin-bottom:.3rem;font-size:.9rem;"><?= $i['t'] ?></div>
        <div style="color:#6b7280;font-size:.825rem;line-height:1.55;"><?= $i['d'] ?></div>
      </div>
      <?php endforeach; ?>
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
