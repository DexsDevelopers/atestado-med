<?php $pageTitle = 'Política de Privacidade — VerificaMed'; ?>
<?php include 'includes/header.php'; ?>

<style>
.legal-wrap { max-width: 820px; margin: 0 auto; padding: 3rem 1.5rem 5rem; }
.legal-wrap h1 { font-size: 1.75rem; font-weight: 800; color: #111827; margin-bottom: .5rem; }
.legal-wrap .updated { font-size: .8125rem; color: #6b7280; margin-bottom: 2.5rem; }
.legal-wrap h2 { font-size: 1.1rem; font-weight: 700; color: #1e3a6e; margin: 2rem 0 .75rem; border-left: 3px solid #2563eb; padding-left: .75rem; }
.legal-wrap p, .legal-wrap li { font-size: .9375rem; color: #374151; line-height: 1.8; margin-bottom: .75rem; }
.legal-wrap ul { padding-left: 1.5rem; margin-bottom: 1rem; }
.legal-wrap .highlight-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: .75rem; padding: 1.25rem 1.5rem; margin: 1.5rem 0; }
.legal-wrap .highlight-box p { margin: 0; color: #1e40af; font-size: .875rem; }
</style>

<section style="background: linear-gradient(135deg,#1e3a6e,#2563eb); padding: 3rem 1.5rem; text-align:center;">
  <h1 style="color:#fff;font-size:1.75rem;font-weight:800;margin:0 0 .5rem;">Política de Privacidade</h1>
  <p style="color:rgba(255,255,255,.8);font-size:.9375rem;margin:0;">Em conformidade com a Lei nº 13.709/2018 — LGPD</p>
</section>

<div class="legal-wrap">
  <p class="updated">Última atualização: <?= date('d/m/Y') ?> &bull; Versão 1.0</p>

  <div class="highlight-box">
    <p>
      <strong>Resumo simples:</strong> O VerificaMed armazena apenas os dados necessários para emitir e verificar documentos médicos. Não vendemos, alugamos nem compartilhamos seus dados com terceiros para fins comerciais. Seus direitos como titular são garantidos nos termos da LGPD.
    </p>
  </div>

  <h2>1. Quem somos</h2>
  <p>O <strong>VerificaMed</strong> é um sistema eletrônico de registro e verificação de documentos médicos (atestados e receitas). Atuamos como <strong>operador e controlador de dados</strong> nos termos do art. 5º, incisos VI e VII da Lei nº 13.709/2018 (LGPD).</p>

  <h2>2. Dados coletados e finalidade</h2>
  <p>Coletamos apenas os dados estritamente necessários para as finalidades declaradas:</p>
  <ul>
    <li><strong>Dados do paciente</strong> (nome, tratamento): identificação no documento médico — base legal: <em>execução de contrato/obrigação legal</em> (art. 7º, II e III, LGPD).</li>
    <li><strong>Dados do médico</strong> (nome, CRM, CNS, especialidade): vinculação de responsabilidade técnica — base legal: <em>obrigação legal</em>.</li>
    <li><strong>Dados do documento</strong> (código, tipo, data, CID, quadro clínico): integridade e rastreabilidade — base legal: <em>legítimo interesse</em> (art. 7º, IX, LGPD).</li>
    <li><strong>Logs de acesso</strong> (IP, data/hora de verificação): segurança do sistema e prevenção a fraudes — base legal: <em>legítimo interesse</em> e <em>segurança</em> (art. 7º, IX e X, LGPD).</li>
  </ul>
  <p><strong>Dados de saúde</strong> (como CID e quadro clínico) são dados sensíveis nos termos do art. 11 da LGPD e são tratados com base na <em>tutela da saúde</em> (art. 11, II, "f") e <em>proteção da vida</em> (art. 11, II, "e").</p>

  <h2>3. Como os dados são armazenados</h2>
  <ul>
    <li>Armazenamento em servidor seguro com criptografia em repouso (MySQL com TLS).</li>
    <li>Acesso restrito via painel administrativo protegido por senha.</li>
    <li>Documentos PDF enviados são armazenados em diretório não indexável, acessível apenas pelo código único do documento.</li>
    <li>Não utilizamos cookies de rastreamento, analytics ou publicidade.</li>
  </ul>

  <h2>4. Compartilhamento de dados</h2>
  <p>Os dados <strong>não são vendidos, cedidos ou compartilhados</strong> com terceiros para fins comerciais. Poderemos compartilhar exclusivamente:</p>
  <ul>
    <li>Com autoridades competentes, mediante ordem judicial ou determinação legal.</li>
    <li>Com prestadores de infraestrutura (hosting Hostinger) sujeitos a acordos de confidencialidade e suas próprias políticas de proteção de dados.</li>
  </ul>

  <h2>5. Seus direitos como titular (art. 18 da LGPD)</h2>
  <p>Você tem direito a:</p>
  <ul>
    <li>Confirmar a existência de tratamento de seus dados;</li>
    <li>Acessar os dados que possuímos sobre você;</li>
    <li>Corrigir dados incompletos, inexatos ou desatualizados;</li>
    <li>Solicitar a anonimização, bloqueio ou eliminação de dados desnecessários;</li>
    <li>Portabilidade dos seus dados;</li>
    <li>Revogar o consentimento, quando aplicável.</li>
  </ul>
  <p>Para exercer seus direitos, entre em contato com o médico ou instituição responsável pelo documento.</p>

  <h2>6. Base legal para tratamento</h2>
  <p>O tratamento de dados no VerificaMed fundamenta-se nos seguintes dispositivos da LGPD:</p>
  <ul>
    <li>Art. 7º, II — cumprimento de obrigação legal ou regulatória;</li>
    <li>Art. 7º, IX — legítimo interesse do controlador para prevenção a fraudes;</li>
    <li>Art. 11, II, "e" e "f" — tutela da saúde e proteção da vida (dados sensíveis).</li>
  </ul>

  <h2>7. Conformidade com a Lei 14.063/2020</h2>
  <p>O sistema utiliza códigos únicos criptografados para verificação de autenticidade, em conformidade com o art. 4º da <strong>Lei nº 14.063, de 23 de setembro de 2020</strong>, que dispõe sobre o uso de assinaturas eletrônicas em interações com entes públicos e em atos de governo.</p>

  <h2>8. Retenção e exclusão de dados</h2>
  <p>Os dados são mantidos enquanto o documento médico possuir validade legal ou até que o médico/instituição solicite sua exclusão. Dados de logs de acesso são retidos por até 6 meses para fins de segurança.</p>

  <h2>9. Segurança</h2>
  <p>Adotamos medidas técnicas e organizacionais adequadas à proteção dos dados, incluindo:</p>
  <ul>
    <li>Conexão HTTPS com TLS em todas as páginas;</li>
    <li>Headers de segurança HTTP (X-Content-Type-Options, X-Frame-Options, HSTS);</li>
    <li>Acesso administrativo protegido por autenticação;</li>
    <li>Consultas parametrizadas (proteção contra SQL Injection);</li>
    <li>Proteção contra força bruta com limitação de tentativas.</li>
  </ul>

  <h2>10. Cookies</h2>
  <p>Utilizamos apenas <strong>cookies estritamente necessários</strong> para o funcionamento da sessão administrativa (PHP session). Não utilizamos cookies de rastreamento, publicidade ou analytics de terceiros.</p>

  <h2>11. Alterações nesta Política</h2>
  <p>Esta política poderá ser atualizada periodicamente. A versão mais recente estará sempre disponível nesta página com a data de revisão indicada no topo.</p>

  <h2>12. Contato — Encarregado (DPO)</h2>
  <p>Em caso de dúvidas sobre o tratamento de seus dados, entre em contato com o responsável pelo documento ou com a instituição emissora. Para questões sobre o sistema, o encarregado pelo tratamento de dados pode ser contactado pelo médico ou instituição cadastrada.</p>

  <div class="highlight-box" style="margin-top:2rem;">
    <p>
      <strong>Autoridade Nacional de Proteção de Dados (ANPD):</strong> Caso entenda que seus direitos não foram atendidos, você pode registrar reclamação junto à ANPD em <a href="https://www.gov.br/anpd" target="_blank" style="color:#2563eb;">gov.br/anpd</a>.
    </p>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
