<?php $currentPage = basename($_SERVER['PHP_SELF'], '.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Sistema Nacional de Verificação de Documentos Médicos. Verifique atestados e receitas médicas com total segurança." />
  <title><?= htmlspecialchars($pageTitle ?? 'VerificaMed — Sistema Nacional de Verificação') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<?php
$_base = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
?>
<body style="margin:0;background:#fff;color:#111827;font-family:'Inter',system-ui,sans-serif;display:flex;flex-direction:column;min-height:100vh;">

<!-- ANNOUNCEMENT BAR -->
<div class="announce-bar no-print">
  Sistema oficial de verificação de documentos médicos &bull; Brasil
</div>

<!-- NAVBAR -->
<nav class="site-nav no-print" style="position:sticky;top:0;z-index:50;">
  <div class="nav-inner">
    <a href="index.php" class="nav-brand">
      VerificaMed
      <span class="nav-brand-sep">|</span>
      <span class="nav-brand-sub">Sistema Nacional de Verificação</span>
    </a>

    <div class="nav-links" id="nav-links">
      <?php
      $links = [
        ['href'=>'index.php',        'page'=>'index',        'label'=>'Início'],
        ['href'=>'sobre.php',          'page'=>'sobre',        'label'=>'Sobre'],
        ['href'=>'instituicoes.php',   'page'=>'instituicoes', 'label'=>'Instituições'],
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
