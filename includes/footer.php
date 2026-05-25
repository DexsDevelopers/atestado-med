</main>

<!-- FOOTER -->
<footer class="site-footer no-print">
  <div style="max-width:960px;margin:0 auto;padding:1.5rem 1.5rem .75rem;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.75rem;border-top:1px solid rgba(255,255,255,.1);">
    <div style="display:flex;align-items:center;gap:.5rem;">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="opacity:.6;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
      <span style="font-size:.75rem;opacity:.7;">Lei 14.063/2020 &bull; LGPD (Lei 13.709/2018)</span>
    </div>
    <div style="display:flex;gap:1.25rem;">
      <a href="privacidade.php" style="font-size:.75rem;color:rgba(255,255,255,.65);text-decoration:none;">Privacidade</a>
      <a href="termos.php" style="font-size:.75rem;color:rgba(255,255,255,.65);text-decoration:none;">Termos de Uso</a>
    </div>
  </div>
  <div class="footer-bottom">&copy; <?= date('Y') ?> VerificaMed &mdash; Sistema de Verificação de Documentos Médicos</div>
</footer>

<script><?php
$jsPath = dirname(__DIR__) . '/assets/js/app.js';
if (file_exists($jsPath)) { readfile($jsPath); }
?></script>
</body>
</html>
