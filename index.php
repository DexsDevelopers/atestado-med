<?php $pageTitle = 'VerificaMed — Verificação de Documentos Médicos'; ?>
<?php include 'includes/header.php'; ?>

<section class="hero-section">
  <!-- Decorative orbs -->
  <div class="hero-orb" style="width:320px;height:320px;top:-80px;right:-60px;animation-delay:0s;"></div>
  <div class="hero-orb" style="width:200px;height:200px;bottom:-40px;left:-30px;animation-delay:3s;"></div>
  <div class="hero-orb" style="width:140px;height:140px;top:40%;left:8%;animation-delay:1.5s;"></div>

  <div style="position:relative;z-index:1;">
    <div class="hero-badge">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      Verificação Oficial de Documentos
    </div>
    <h1 class="hero-h1">Autentique Documentos<br>Médicos em Segundos</h1>
    <p class="hero-sub">Escaneie o QR Code ou insira o código para verificar a autenticidade de atestados médicos instantaneamente.</p>
    <a href="verificar.php" class="btn-verify">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Verificar Documento Agora
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </a>
    <!-- Trust badges -->
    <div class="trust-badges" style="display:flex;flex-wrap:wrap;justify-content:center;gap:.75rem;margin-top:2rem;">
      <?php
      $badges = [
        ['icon'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'label'=>'SSL / HTTPS'],
        ['icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label'=>'Lei 14.063/2020'],
        ['icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label'=>'LGPD Compliant'],
        ['icon'=>'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'label'=>'Ética CFM'],
      ];
      foreach ($badges as $b): ?>
      <div class="trust-chip">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="rgba(255,255,255,.9)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="<?= $b['icon'] ?>"/></svg>
        <span style="font-size:.75rem;color:rgba(255,255,255,.9);font-weight:500;"><?= $b['label'] ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section style="background:#f8faff;padding:4rem 1.5rem;">
  <div style="max-width:820px;margin:0 auto;text-align:center;">
    <p class="reveal" style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#2563eb;margin-bottom:.5rem;">Como funciona</p>
    <h2 class="reveal" style="font-size:1.5rem;font-weight:800;color:#111827;margin-bottom:2.5rem;">Verificação em 3 passos simples</h2>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
      <?php
      $steps = [
        ['n'=>'1','title'=>'Escaneie o QR Code','desc'=>'Use a câmera do celular para escanear o QR Code impresso no documento médico.','icon'=>'M3 4h4v4H3zM3 10h4v4H3zM10 3h4v4h-4zM17 3h4v4h-4zM17 10h4v4h-4zM10 17h4v4h-4zM17 17h4v4h-4zM3 17h4v4H3zM10 10h4v4h-4z','delay'=>'rd-1'],
        ['n'=>'2','title'=>'Ou insira o código','desc'=>'Digite o código único de 18 caracteres presente no rodapé do documento médico.','icon'=>'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4','delay'=>'rd-2'],
        ['n'=>'3','title'=>'Resultado instantâneo','desc'=>'Veja se o documento é autêntico, os dados do paciente, médico e o atestado em PDF.','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','delay'=>'rd-3'],
      ];
      foreach ($steps as $s): ?>
      <div class="step-card reveal <?= $s['delay'] ?>">
        <div class="step-num">
          <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="<?= $s['icon'] ?>"/></svg>
        </div>
        <div style="font-size:.6875rem;font-weight:700;background:#eff6ff;color:#2563eb;border-radius:999px;padding:.2rem .7rem;display:inline-block;margin-bottom:.5rem;">PASSO <?= $s['n'] ?></div>
        <div style="font-size:.9375rem;font-weight:700;color:#111827;margin-bottom:.5rem;"><?= $s['title'] ?></div>
        <p style="font-size:.8125rem;color:#6b7280;line-height:1.7;margin:0;"><?= $s['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- LEGAL NOTICE -->
<section class="reveal" style="background:#fff;padding:2rem 1.5rem;border-top:1px solid #e8edf5;">
  <div style="max-width:760px;margin:0 auto;display:flex;align-items:flex-start;gap:1rem;flex-wrap:wrap;">
    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4f46e5" stroke-width="2" style="flex-shrink:0;margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
    <div style="flex:1;">
      <p style="font-size:.8125rem;color:#374151;margin:0;line-height:1.8;">
        <strong>Base legal:</strong> Este sistema opera em conformidade com a <strong>Lei nº 14.063/2020</strong> (assinaturas eletrônicas), <strong>Lei nº 13.709/2018 — LGPD</strong>, <strong>Resolução CFM nº 2.217/2018</strong> (Código de Ética Médica) e <strong>Lei nº 12.842/2013</strong> (exercício da medicina).
        A verificação eletrônica não substitui a análise do documento original pelo profissional responsável.
        <a href="termos.php" style="color:#4f46e5;">Termos de Uso</a> &bull; <a href="privacidade.php" style="color:#4f46e5;">Política de Privacidade</a>
      </p>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
