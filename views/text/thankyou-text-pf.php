<div class="container mt-4">
    <div class=" p-4">
        <h2 class="text-success">Olá, <?= $assinante_name ?>!</h2>
        <p class="mt-3">Parabéns pela sua assinatura! Você já pode usar os benefícios do <strong>DNA Care</strong>, mesmo sem o Cartão. Apresente seu CPF na nossa rede credenciada para comprovação. Conheça a rede credenciada em
            <a href="<?= home_url() ?>rede-credenciada/" target="_blank" class="text-primary"><?= home_url() ?>rede-credenciada/</a>.
        </p>

        <p>Para retirar seu Cartão, visite a <strong>DNA Medicina Diagnóstica</strong> na Rua Bolívia, 326.</p>

        <p>Estamos à disposição no <a href="tel:1155000515" class="text-primary">(11) 5500 0515</a>.</p>

        <p>Seja bem-vindo(a)!</p>

        <p class="mt-4">Abraços,<br>
            <strong>Equipe DNA Care</strong>
        </p>
    </div>
</div>


<h3 class="fw-semibold"><a href="apps-ecommerce-order-details.html" class="text-decoration-underline"></a></h3>

<?php if ($btn_link && $btn_label) : ?>
    <a href="<?= $btn_link ?>" class="btn btn-primary mt-2" download target="_blank"><?= $btn_label ?></a>
<?php endif ?>