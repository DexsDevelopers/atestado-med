<?php $pageTitle = 'Termos de Uso — VerificaMed'; ?>
<?php include 'includes/header.php'; ?>

<style>
.legal-wrap { max-width: 820px; margin: 0 auto; padding: 3rem 1.5rem 5rem; }
.legal-wrap h1 { font-size: 1.75rem; font-weight: 800; color: #111827; margin-bottom: .5rem; }
.legal-wrap .updated { font-size: .8125rem; color: #6b7280; margin-bottom: 2.5rem; }
.legal-wrap h2 { font-size: 1.1rem; font-weight: 700; color: #1e3a6e; margin: 2rem 0 .75rem; border-left: 3px solid #2563eb; padding-left: .75rem; }
.legal-wrap p, .legal-wrap li { font-size: .9375rem; color: #374151; line-height: 1.8; margin-bottom: .75rem; }
.legal-wrap ul { padding-left: 1.5rem; margin-bottom: 1rem; }
.legal-wrap .highlight-box { background: #fefce8; border: 1px solid #fde68a; border-radius: .75rem; padding: 1.25rem 1.5rem; margin: 1.5rem 0; }
.legal-wrap .highlight-box p { margin: 0; color: #92400e; font-size: .875rem; }
</style>

<section style="background: linear-gradient(135deg,#1e3a6e,#2563eb); padding: 3rem 1.5rem; text-align:center;">
  <h1 style="color:#fff;font-size:1.75rem;font-weight:800;margin:0 0 .5rem;">Termos de Uso</h1>
  <p style="color:rgba(255,255,255,.8);font-size:.9375rem;margin:0;">Condições de utilização do sistema VerificaMed</p>
</section>

<div class="legal-wrap">
  <p class="updated">Última atualização: <?= date('d/m/Y') ?> &bull; Versão 1.0</p>

  <div class="highlight-box">
    <p>
      <strong>Atenção:</strong> O VerificaMed é um sistema de verificação de autenticidade de documentos médicos. A confirmação de autenticidade por este sistema não substitui a análise clínica do profissional de saúde nem a responsabilidade ética e legal do médico emissor do documento.
    </p>
  </div>

  <h2>1. Aceitação dos Termos</h2>
  <p>Ao acessar e utilizar o sistema VerificaMed, o usuário declara ter lido, compreendido e concordado com estes Termos de Uso. Caso não concorde, deve cessar o uso imediatamente.</p>

  <h2>2. Descrição do Serviço</h2>
  <p>O VerificaMed é um sistema eletrônico que permite:</p>
  <ul>
    <li>Verificar a autenticidade de documentos médicos (atestados) por meio de código único ou QR Code;</li>
    <li>Visualizar informações básicas do documento verificado (paciente, médico, data, CID);</li>
    <li>Visualizar o documento original em PDF, quando disponibilizado pelo médico emissor.</li>
  </ul>

  <h2>3. Usuários Autorizados</h2>
  <p>O sistema destina-se a:</p>
  <ul>
    <li><strong>Empregadores e RH</strong>: verificação de atestados médicos de colaboradores;</li>
    <li><strong>Planos de saúde e operadoras</strong>: confirmação de documentos para fins de cobertura;</li>
    <li><strong>Profissionais de saúde</strong>: consulta de documentos emitidos por colegas;</li>
    <li><strong>Órgãos públicos</strong>: validação de documentos para fins administrativos.</li>
  </ul>

  <h2>4. Responsabilidade do Médico Emissor</h2>
  <p>O profissional de saúde que utiliza o sistema para emissão de documentos é inteiramente responsável por:</p>
  <ul>
    <li>A veracidade das informações inseridas, nos termos do art. 80 do Código de Ética Médica (CFM Resolução nº 2.217/2018);</li>
    <li>A exatidão do diagnóstico, CID e período de afastamento declarados;</li>
    <li>A obtenção do consentimento do paciente para registro dos dados de saúde;</li>
    <li>O cumprimento das normas do CFM e legislação vigente sobre documentos médicos.</li>
  </ul>

  <h2>5. Limitações de Responsabilidade</h2>
  <p>O VerificaMed <strong>não se responsabiliza</strong> por:</p>
  <ul>
    <li>Informações incorretas inseridas pelo médico ou instituição no momento do cadastro;</li>
    <li>Decisões tomadas com base exclusiva na verificação eletrônica sem análise do documento original;</li>
    <li>Uso indevido das informações verificadas por terceiros não autorizados;</li>
    <li>Indisponibilidade temporária do sistema por manutenção ou falhas de infraestrutura.</li>
  </ul>

  <h2>6. Uso Proibido</h2>
  <p>É expressamente vedado:</p>
  <ul>
    <li>Tentar burlar, hackear ou sobrecarregar o sistema (ataques de força bruta, DoS, SQL Injection etc.);</li>
    <li>Cadastrar documentos falsos, fraudulentos ou sem respaldo clínico real;</li>
    <li>Utilizar os dados verificados para fins discriminatórios, em violação à LGPD;</li>
    <li>Reproduzir, copiar ou redistribuir o conteúdo do sistema sem autorização.</li>
  </ul>
  <p>A prática de fraude em documentos médicos configura crime tipificado no art. 297 do Código Penal (falsidade ideológica) e pode ensejar responsabilidade civil e disciplinar perante o CFM.</p>

  <h2>7. Base Legal e Conformidade</h2>
  <p>O sistema opera em conformidade com:</p>
  <ul>
    <li><strong>Lei nº 14.063/2020</strong> — assinaturas eletrônicas em interações com entes públicos;</li>
    <li><strong>Lei nº 13.709/2018 (LGPD)</strong> — proteção de dados pessoais;</li>
    <li><strong>Resolução CFM nº 2.217/2018</strong> — Código de Ética Médica;</li>
    <li><strong>Lei nº 12.842/2013</strong> — exercício da medicina;</li>
    <li><strong>Lei nº 9.656/1998</strong> — planos e seguros privados de saúde.</li>
  </ul>

  <h2>8. Propriedade Intelectual</h2>
  <p>Todo o código, layout e conteúdo do sistema VerificaMed são protegidos. A marca "VerificaMed" e seus elementos visuais não podem ser reproduzidos sem autorização expressa.</p>

  <h2>9. Alterações nos Termos</h2>
  <p>Estes termos podem ser atualizados a qualquer momento. A versão vigente sempre estará disponível nesta página. O uso contínuo do sistema após alterações implica aceitação dos novos termos.</p>

  <h2>10. Foro</h2>
  <p>Fica eleito o foro da comarca de Teresina — PI para dirimir quaisquer controvérsias decorrentes destes termos, com renúncia de qualquer outro, por mais privilegiado que seja.</p>
</div>

<?php include 'includes/footer.php'; ?>
