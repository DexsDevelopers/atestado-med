</main>

<!-- FOOTER -->
<footer class="site-footer no-print">
  <div class="footer-bottom" style="border-top:none;">&copy; <?= date('Y') ?> VerificaMed &mdash; Sistema de Verificação de Documentos Médicos</div>
</footer>

<script><?php
$jsPath = dirname(__DIR__) . '/assets/js/app.js';
if (file_exists($jsPath)) { readfile($jsPath); }
?></script>
</body>
</html>
