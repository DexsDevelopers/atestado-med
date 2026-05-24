<?php $currentPage = basename($_SERVER['PHP_SELF'], '.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Atestados e receitas médicas digitais com validade jurídica" />
  <title><?= htmlspecialchars($pageTitle ?? 'Verificamed') ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50:'#f0f9ff', 100:'#e0f2fe', 200:'#bae6fd', 300:'#7dd3fc',
              400:'#38bdf8', 500:'#0ea5e9', 600:'#0284c7', 700:'#0369a1',
              800:'#075985', 900:'#0c4a6e'
            }
          },
          fontFamily: { sans: ['Inter','system-ui','sans-serif'] }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-900 font-sans">

<!-- NAVBAR -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm no-print">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">

    <a href="/index.php" class="flex items-center gap-2 font-bold text-xl text-primary-700 no-underline">
      <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
        </svg>
      </div>
      Verificamed
    </a>

    <nav class="hidden md:flex items-center gap-1">
      <?php
      $links = [
        ['href'=>'/index.php',    'page'=>'index',    'label'=>'Início'],
        ['href'=>'/atestado.php', 'page'=>'atestado', 'label'=>'Atestado'],
        ['href'=>'/receita.php',  'page'=>'receita',  'label'=>'Receita'],
        ['href'=>'/verificar.php','page'=>'verificar','label'=>'Verificar Documento'],
      ];
      foreach ($links as $l): ?>
        <a href="<?= $l['href'] ?>"
           class="nav-link <?= $currentPage === $l['page'] ? 'active' : '' ?>">
          <?= $l['label'] ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="hidden md:flex items-center gap-3">
      <a href="/verificar.php" class="btn-gradient">Verificar Agora</a>
    </div>

    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
  </div>

  <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 flex flex-col gap-1">
    <?php foreach ($links as $l): ?>
      <a href="<?= $l['href'] ?>"
         class="nav-link block <?= $currentPage === $l['page'] ? 'active' : '' ?>">
        <?= $l['label'] ?>
      </a>
    <?php endforeach; ?>
  </div>
</header>

<main class="flex-1">
