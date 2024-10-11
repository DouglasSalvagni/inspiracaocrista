<footer class="custom-footer bg-dark py-4 position-relative">
    <div class="container">
        <div class="w-100 d-flex justify-content-center">
            <div>
                <!-- Dark Logo-->
                <a href="<?= home_url() ?>"  target="_blank"  class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo Media_Helper::get_asset_url('images/logo.png') ?>" alt="" height="42">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo Media_Helper::get_asset_url('images/logo.png') ?>" alt="" height="42">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="<?= home_url() ?>"  target="_blank"  class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo Media_Helper::get_asset_url('images/logo.png') ?>" alt="" height="42">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo Media_Helper::get_asset_url('images/logo.png') ?>" alt="" height="42">
                    </span>
                </a>
            </div>
        </div>

        <div class="row text-center text-sm-start align-items-center mt-2">
            <div class="col-sm-6">

                <div>
                    <p class="copy-rights mb-0">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © inspiracaocrista
                    </p>
                </div>
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</footer>