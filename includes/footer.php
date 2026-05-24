</main>

<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-300 no-print">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

      <div class="md:col-span-2">
        <a href="/index.php" class="flex items-center gap-2 font-bold text-xl text-white mb-3 no-underline">
          <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
            </svg>
          </div>
          Verificamed
        </a>
        <p class="text-sm text-gray-400 leading-relaxed max-w-xs">
          Plataforma digital para emissão e verificação de atestados e receitas médicas com validade jurídica.
        </p>
        <div class="mt-4 flex flex-col gap-2 text-sm text-gray-400">
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            contato@verificamed.website
          </span>
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            (11) 99999-0000
          </span>
        </div>
      </div>

      <div>
        <h4 class="text-white font-semibold mb-3">Serviços</h4>
        <ul class="flex flex-col gap-2 text-sm">
          <li><a href="/atestado.php" class="hover:text-white transition-colors">Atestado Médico</a></li>
          <li><a href="/receita.php"  class="hover:text-white transition-colors">Receita Médica</a></li>
          <li><a href="/verificar.php" class="hover:text-white transition-colors">Verificar Documento</a></li>
        </ul>
      </div>

      <div>
        <h4 class="text-white font-semibold mb-3">Institucional</h4>
        <ul class="flex flex-col gap-2 text-sm">
          <li><a href="#" class="hover:text-white transition-colors">Sobre nós</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Política de Privacidade</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Termos de Uso</a></li>
          <li><a href="#" class="hover:text-white transition-colors">Suporte</a></li>
        </ul>
      </div>
    </div>

    <div class="border-t border-gray-800 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
      <span>&copy; <?= date('Y') ?> Verificamed. Todos os direitos reservados.</span>
      <span>Documentos com validade jurídica conforme Lei 14.063/2020</span>
    </div>
  </div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
