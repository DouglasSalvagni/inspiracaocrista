<div class="container mt-4">
    <div class=" p-4">
        <h2 class="text-success">Olá, <?= $assinante_name ?> e equipe,</h2>
        <p class="mt-3">É com grande satisfação que damos as boas-vindas a todos vocês ao <strong>DNA Care</strong>!</p>
        
        <p>Agora, cada colaborador faz parte do nosso programa de saúde, com acesso a benefícios exclusivos que tornam o cuidado com a saúde mais acessível e prático. Mesmo antes de receberem o Cartão DNA Care, vocês já podem utilizar todos os benefícios disponíveis. Basta apresentar o CPF na nossa rede credenciada, que a ativação da assinatura é automaticamente verificada.</p>
        
        <p>Com o DNA Care, vocês têm acesso a:</p>

        <div>
            <span>Descontos de até <strong>65%</strong> em consultas, exames e serviços de saúde.</span>
            <span>Uma ampla rede de profissionais de saúde qualificados, prontos para atender suas necessidades.</span>
        </div>
        
        <p>O cartão de benefícios chegará em breve, mas até lá, aproveitem essa facilidade para cuidar da saúde com tranquilidade!</p>
        
        <p>Caso tenham dúvidas ou precisem de suporte, estamos à disposição pelo telefone 
        <a href="tel:1155000515" class="text-primary">(11) 5500 0515</a> ou no nosso site 
        <a href="<?= home_url() ?>" target="_blank" class="text-primary">inspiracaocrista.com.br</a>, onde vocês também podem consultar a rede credenciada.</p>
        
        <p>Aproveite para nos acompanhar nas redes sociais em 
        <a href="https://instagram.com/inspiracaocrista" target="_blank" class="text-primary">@inspiracaocrista</a>.</p>
        
        <p>Sejam muito bem-vindos à nossa família!</p>
        
        <p class="mt-4">Um abraço,<br>
        <strong>Equipe DNA Care</strong></p>
    </div>
</div>


<h3 class="fw-semibold"><a href="apps-ecommerce-order-details.html" class="text-decoration-underline"></a></h3>

<?php if ($btn_link && $btn_label) : ?>
    <a href="<?= $btn_link ?>" class="btn btn-primary mt-2" download target="_blank"><?= $btn_label ?></a>
<?php endif ?>