<!-- Begin page -->
<div class="layout-wrapper landing">
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">
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
            <div class=" text-muted mt-lg-5 pt-5">
                <?php

                echo $politica_content;

                ?>
            </div>
        </div>
    </section>
</div>

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