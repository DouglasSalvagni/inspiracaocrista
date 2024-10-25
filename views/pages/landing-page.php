<!-- Begin page -->
<div class="layout-wrapper landing">
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="<?= home_url() ?>">
                <?php

                $logo_height = 100;
                if (wp_is_mobile()) $logo_height = 60;

                ?>
                <img src="<?= Media_Helper::get_asset_url('images/logo.png') ?>" class="card-logo card-logo-dark" alt="logo dark" height="<?= $logo_height ?>">
                <img src="<?= Media_Helper::get_asset_url('images/logo.png') ?>" class="card-logo card-logo-light" alt="logo light" height="<?= $logo_height ?>">
            </a>
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item">
                        <a class="nav-link fs-14 active" href="<?= home_url('/#hero') ?>">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="<?= home_url('/#benefits') ?>">Benefícios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="<?= home_url('/#citacoes') ?>">Citações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="<?= home_url('/#como-funciona') ?>">Como funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="<?= home_url('/#gratis') ?>">Comece grátis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="<?= home_url('/#faq') ?>">FAQ</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <!-- end navbar -->
    <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>

    <!-- start hero section -->
    <section class="section pb-5 hero-section" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-sm-10">
                    <div class="text-center mt-lg-5 pt-5">
                        <h1 class="display-6 fw-semibold mb-3 lh-base">Inicie Seus Dias com Inspiração <span class="text-success">Divina </span></h1>
                        <p class="lead text-muted lh-base">Receba diariamente no WhatsApp uma passagem bíblica e uma imagem inspiradora todos os dias por apenas R$5,00 ao mês.</p>

                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <a href="<?= get_whats_api_url(5180140694, 55, 'Olá, quero conhecer mais sobre o inspiração Cristã') ?>" class="btn btn-success">Assine Agora pelo WhatsApp <i class="ri-whatsapp-line align-middle ms-1"></i></a>
                        </div>
                    </div>

                    <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                        <div class="demo-img-patten-top d-none d-sm-block">
                            <img src="<?= Media_Helper::get_asset_url('images/landing/img-pattern.png') ?>" class="d-block img-fluid" alt="...">
                        </div>
                        <div class="demo-img-patten-bottom d-none d-sm-block">
                            <img src="<?= Media_Helper::get_asset_url('images/landing/img-pattern.png') ?>" class="d-block img-fluid" alt="...">
                        </div>
                        <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                <div class="carousel-item active" data-bs-interval="2000">
                                    <img src="<?= Media_Helper::get_asset_url('images/lp/banner1.webp') ?>" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <img src="<?= Media_Helper::get_asset_url('images/lp/banner2.webp') ?>" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item" data-bs-interval="2000">
                                    <img src="<?= Media_Helper::get_asset_url('images/lp/banner3.webp') ?>" class="d-block w-100" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
        <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                    <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                    </path>
                </g>
            </svg>
        </div>
        <!-- end shape -->
    </section>
    <!-- end hero section -->



    <!-- start benefits -->
    <section class="section pt-5 mt-5" id="benefits">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h1 class="mb-3 ff-secondary fw-semibold lh-base">Benefícios</h1>
                        <p class="text-muted">Receba diariamente mensagens inspiradoras e reflexões bíblicas diretamente no seu WhatsApp, com total flexibilidade e suporte dedicado.</p>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-sun-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Inspiração Diária</h5>
                            <p class="text-muted my-3 ff-secondary">Receba mensagens que fortalecem a fé e trazem paz ao seu dia.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-whatsapp-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Praticidade</h5>
                            <p class="text-muted my-3 ff-secondary">Conteúdo entregue diretamente no WhatsApp, sem complicações.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-refresh-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Flexibilidade</h5>
                            <p class="text-muted my-3 ff-secondary">Cancele a qualquer momento, sem burocracia.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-hand-heart-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Demonstração Gratuita</h5>
                            <p class="text-muted my-3 ff-secondary">Experimente antes de assinar enviando <em>"teste"</em> para o nosso WhatsApp.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-heart-2-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Conexão Espiritual Constante</h5>
                            <p class="text-muted my-3 ff-secondary">Fortaleça sua fé diariamente com reflexões e passagens bíblicas enviadas diretamente no seu celular.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-flex p-3">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm icon-effect">
                                <div class="avatar-title bg-transparent text-success rounded-circle">
                                    <i class="ri-customer-service-2-line fs-36"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-18">Suporte Amigável</h5>
                            <p class="text-muted my-3 ff-secondary">Nossa equipe está sempre pronta para ajudar com qualquer dúvida ou necessidade, a um clique de distância.</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end benefi -->

    <!-- start review -->
    <section class="section bg-primary" id="citacoes">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center">
                        <div>
                            <i class="ri-double-quotes-l text-success display-3"></i>
                        </div>
                        <h4 class="text-white mb-5"><span class="text-success">Milhares</span> de citações bíblicas inspiradoras</h4>

                        <!-- Swiper -->
                        <div class="swiper client-review-swiper rounded" dir="ltr">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-20 ff-secondary mb-4">"Mas os que esperam no Senhor renovarão as suas forças. Voarão alto como águias; correrão e não se cansarão, caminharão e não se fatigarão."</p>

                                                <div>
                                                    <h5 class="text-white">— Isaías 40:31</h5>
                                                </div>

                                                <div class="d-flex justify-content-center w-100">
                                                    <img src="<?= Media_Helper::get_asset_url('images/lp/passagem1.webp') ?>" class="d-block img-fluid w-md-50 w-75" alt="...">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-20 ff-secondary mb-4">"Porque sou eu que conheço os planos que tenho para vocês", diz o Senhor, "planos de fazê-los prosperar e não de causar dano, planos de dar a vocês esperança e um futuro."</p>

                                                <div>
                                                    <h5 class="text-white">— Jeremias 29:11</h5>
                                                </div>

                                                <div class="d-flex justify-content-center w-100">
                                                    <img src="<?= Media_Helper::get_asset_url('images/lp/passagem2.webp') ?>" class="d-block img-fluid w-50" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                                <div class="swiper-slide">
                                    <div class="row justify-content-center">
                                        <div class="col-10">
                                            <div class="text-white-50">
                                                <p class="fs-20 ff-secondary mb-4">"Confie no Senhor de todo o seu coração e não se apoie em seu próprio entendimento; reconheça o Senhor em todos os seus caminhos, e ele endireitará as suas veredas."</p>

                                                <div>
                                                    <h5 class="text-white">— Provérbios 3:5-6</h5>
                                                </div>

                                                <div class="d-flex justify-content-center w-100">
                                                    <img src="<?= Media_Helper::get_asset_url('images/lp/passagem3.webp') ?>" class="d-block img-fluid w-50" alt="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end slide -->
                            </div>
                            <div class="swiper-button-next bg-white rounded-circle"></div>
                            <div class="swiper-button-prev bg-white rounded-circle"></div>
                            <div class="swiper-pagination position-relative mt-2"></div>
                        </div>
                        <!-- end slider -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end review -->

    <!-- start Work Process -->
    <section class="section" id="como-funciona">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Como Funciona</h3>
                        <p class="text-muted mb-4 ff-secondary">Veja como é simples começar a receber passagens bíblicas e imagens inspiradoras todos os dias.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row text-center">
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="process-arrow-img d-none d-lg-block">
                            <img src="<?= Media_Helper::get_asset_url('images/landing/process-arrow-img.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                <i class="ri-chat-1-line"></i>
                            </div>
                        </div>

                        <h5>1. Envie uma Mensagem</h5>
                        <p class="text-muted ff-secondary">Entre em contato pelo WhatsApp e envie "Assinar".</p>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="process-arrow-img d-none d-lg-block">
                            <img src="<?= Media_Helper::get_asset_url('images/landing/process-arrow-img.png') ?>" alt="" class="img-fluid">
                        </div>
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                <i class="ri-secure-payment-line"></i>
                            </div>
                        </div>

                        <h5>2. Confirme a Assinatura</h5>
                        <p class="text-muted ff-secondary">Siga as instruções para confirmar o pagamento de R$5,00/mês.</p>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-lg-4">
                    <div class="process-card mt-4">
                        <div class="avatar-sm icon-effect mx-auto mb-4">
                            <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                <i class="ri-sun-line"></i>
                            </div>
                        </div>

                        <h5>3. Receba Conteúdo Diário</h5>
                        <p class="text-muted ff-secondary">Comece a receber as passagens bíblicas e imagens inspiradoras todas as manhãs.</p>
                    </div>
                </div>
                <!-- end col -->
            </div>


            <div class="mt-4 row justify-content-center">
                    <a href="<?= get_whats_api_url(5180140694, 55, 'Olá, quero conhecer mais sobre o inspiração Cristã') ?>" class="btn btn-success flex-shrink-1 btn-lg btn--shake px-5 py-3 shadow-lg">Assinar Agora</a>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end Work Process -->


    <!-- start features -->
    <section class="section bg-light py-5" id="gratis">
        <div class="container">
            <div class="row align-items-center gy-4">
                <div class="col-lg-6 col-sm-7 mx-auto">
                    <div>
                        <img src="<?= Media_Helper::get_asset_url('images/lp/banner3.webp') ?>" alt="Demonstração Gratuita" class="img-fluid mx-auto">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-muted">
                        <div class="avatar-sm icon-effect mb-4">
                            <div class="avatar-title bg-transparent rounded-circle text-success h1">
                                <i class="ri-whatsapp-line fs-36"></i>
                            </div>
                        </div>
                        <h3 class="mb-3 fs-20">Quero uma Demonstração Gratuita</h3>
                        <p class="mb-4 ff-secondary fs-16">Para experimentar gratuitamente nosso serviço, envie "teste" para o WhatsApp e descubra como podemos ajudar você.</p>

                        <div class="row pt-3">
                            <div class="col-12">
                                <a href="<?= get_whats_api_url(5180140694, 55, 'Olá, quero conhecer mais sobre o inspiração Cristã') ?>" class="btn btn-success btn--shake">Quero uma Demonstração Gratuita <i class="ri-whatsapp-line align-middle ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end features -->

    <!-- start faqs -->
    <section class="section" id="faq">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Perguntas Frequentes (FAQ)</h3>
                        <p class="text-muted mb-4 ff-secondary">Se você não encontrar a resposta para sua pergunta, pode sempre entrar em contato pelo WhatsApp. Estamos prontos para ajudar!</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row g-lg-5 g-4">
                <div class="col-lg-6">
                    <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="faq-accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseSix" aria-expanded="false" aria-controls="faq-collapseSix">
                                    Há algum período de teste gratuito?
                                </button>
                            </h2>
                            <div id="faq-collapseSix" class="accordion-collapse collapse" aria-labelledby="faq-headingSix" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Sim, você pode experimentar o serviço gratuitamente por 7 dias antes de decidir pela assinatura.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseOne" aria-expanded="true" aria-controls="faq-collapseOne">
                                    Posso cancelar quando quiser?
                                </button>
                            </h2>
                            <div id="faq-collapseOne" class="accordion-collapse collapse show" aria-labelledby="faq-headingOne" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Sim, basta nos informar pelo WhatsApp.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseTwo" aria-expanded="false" aria-controls="faq-collapseTwo">
                                    Como é feito o pagamento?
                                </button>
                            </h2>
                            <div id="faq-collapseTwo" class="accordion-collapse collapse" aria-labelledby="faq-headingTwo" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    O pagamento pode ser feito com cartão de crédito de sua preferência.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseThree" aria-expanded="false" aria-controls="faq-collapseThree">
                                    As mensagens podem ser compartilhadas?
                                </button>
                            </h2>
                            <div id="faq-collapseThree" class="accordion-collapse collapse" aria-labelledby="faq-headingThree" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Sim, sinta-se à vontade para compartilhar a inspiração com amigos e familiares.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseFour" aria-expanded="false" aria-controls="faq-collapseFour">
                                    O conteúdo é enviado em qual horário?
                                </button>
                            </h2>
                            <div id="faq-collapseFour" class="accordion-collapse collapse" aria-labelledby="faq-headingFour" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    As mensagens diárias são enviadas pela manhã, para começar o dia com inspiração.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="faq-accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseEight" aria-expanded="false" aria-controls="faq-collapseEight">
                                    O que está incluído na assinatura?
                                </button>
                            </h2>
                            <div id="faq-collapseEight" class="accordion-collapse collapse" aria-labelledby="faq-headingEight" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    A assinatura inclui o envio diário de uma passagem bíblica e uma imagem inspiradora para motivar o seu dia.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingTen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseTen" aria-expanded="false" aria-controls="faq-collapseTen">
                                    O conteúdo enviado é personalizado?
                                </button>
                            </h2>
                            <div id="faq-collapseTen" class="accordion-collapse collapse" aria-labelledby="faq-headingTen" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Atualmente, as mensagens são padrão para todos os assinantes, mas estamos considerando opções de personalização no futuro.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingTwelve">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseTwelve" aria-expanded="false" aria-controls="faq-collapseTwelve">
                                    Os pagamentos são seguros?
                                </button>
                            </h2>
                            <div id="faq-collapseTwelve" class="accordion-collapse collapse" aria-labelledby="faq-headingTwelve" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Sim, utilizamos plataformas de pagamento seguras e confiáveis para garantir a proteção dos seus dados.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingThirteen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseThirteen" aria-expanded="false" aria-controls="faq-collapseThirteen">
                                    Como posso dar feedback sobre o serviço?
                                </button>
                            </h2>
                            <div id="faq-collapseThirteen" class="accordion-collapse collapse" aria-labelledby="faq-headingThirteen" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    Envie suas sugestões e feedback pelo WhatsApp. Estamos sempre abertos a ouvir e melhorar com base na opinião dos nossos assinantes.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq-headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapseFive" aria-expanded="false" aria-controls="faq-collapseFive">
                                    Posso mudar o horário de recebimento das mensagens?
                                </button>
                            </h2>
                            <div id="faq-collapseFive" class="accordion-collapse collapse" aria-labelledby="faq-headingFive" data-bs-parent="#faq-accordion">
                                <div class="accordion-body ff-secondary">
                                    No momento, o horário de envio é fixo, mas estamos trabalhando para oferecer essa opção no futuro.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end accordion -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end faqs -->

    <section class="py-5 bg-light text-center">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold">Comece hoje mesmo!</h2>
                    <p class="lead text-muted mt-3">
                        Comece a receber palavras de fé e inspiração hoje mesmo e faça da espiritualidade uma parte essencial da sua rotina diária.
                    </p>
                    <div class="mt-4">
                        <a href="<?= get_whats_api_url(5180140694, 55, 'Olá, quero conhecer mais sobre o inspiração Cristã') ?>" class="btn btn-success btn-lg btn--shake px-5 py-3 shadow-lg">Assinar Agora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Start footer -->
    <footer class="custom-footer bg-dark py-4 position-relative">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <p class="copy-rights mb-0">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © inspiracaocrista
                    </p>
                </div>
                <div>
                    <img src="<?= Media_Helper::get_asset_url('images/logo.png') ?>" alt="logo light" height="100">
                </div>
                <ul class="list-unstyled ff-secondary footer-list fs-14">
                    <li>
                        <a href="<?= home_url('/politica-de-privacidade') ?>">Política de privacidade</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

</div>
<!-- end layout wrapper -->

<!-- Modal -->
<div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyPolicyModalLabel">Política de Privacidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $politica_content ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>