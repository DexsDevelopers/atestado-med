<?php
date_default_timezone_set('America/Sao_Paulo');
$currentPage = basename($_SERVER['PHP_SELF'], '.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Sistema Nacional de Verificação de Documentos Médicos. Verifique atestados e receitas médicas com total segurança." />
  <title><?= htmlspecialchars($pageTitle ?? 'VerificaMed — Sistema Nacional de Verificação') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet" />
  <style><?php
  $cssPath = dirname(__DIR__) . '/assets/css/style.css';
  if (file_exists($cssPath)) { readfile($cssPath); } else { echo '/* CSS not found: ' . htmlspecialchars($cssPath) . ' */'; }
  ?></style>
</head>
<body style="margin:0;background:#fff;color:#111827;font-family:'Inter',system-ui,sans-serif;display:flex;flex-direction:column;min-height:100vh;">

<!-- SCROLL PROGRESS -->
<div id="scroll-progress"></div>

<!-- ANNOUNCEMENT BAR -->
<div class="announce-bar no-print" style="font-size:.8rem;font-weight:500;padding:.45rem 1rem;letter-spacing:.01em;">
  <span class="announce-pulse"></span>
  Sistema Oficial de Verificação &nbsp;&bull;&nbsp; Lei 14.063/2020 &nbsp;&bull;&nbsp; LGPD Compliant &nbsp;&bull;&nbsp; Dados protegidos com criptografia SSL
</div>

<!-- NAVBAR -->
<nav class="site-nav no-print" style="position:sticky;top:0;z-index:50;">
  <div class="nav-inner">
    <a href="index.php" class="nav-brand">
      <span class="nav-logo-icon">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
      </span>
      <span class="nav-brand-text">Verifica<span class="nav-brand-accent">Med</span></span>
      <span class="nav-brand-sep">|</span>
      <span class="nav-brand-sub">Sistema Nacional de Verificação</span>
    </a>

    <div class="nav-links" id="nav-links">
      <?php
      $links = [
        ['href'=>'index.php',       'page'=>'index',     'label'=>'Início'],
        ['href'=>'verificar.php',   'page'=>'verificar', 'label'=>'Verificar Documento'],
      ];
      foreach ($links as $l): ?>
        <a href="<?= $l['href'] ?>" class="nav-link <?= $currentPage === $l['page'] ? 'active' : '' ?>">
          <?= $l['label'] ?>
        </a>
      <?php endforeach; ?>
    </div>

    <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Menu">
      <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>
</nav>

<main style="flex:1;">
