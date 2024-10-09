(function($) {
    class Sales {
        constructor() {
            this.debounceTimer = null;
            this.initialize();
        }

        initialize() {
            this.bindEvents();
            this.loadSales();
        }

        bindEvents() {
            $('#search-sales').on('keyup', this.handleSearch.bind(this));
            $('#sale-status-filter').on('change', this.handleStatusFilter.bind(this));
            $(document).on('click', '.page-link', this.handlePagination.bind(this));
        }

        handleSearch(event) {
            const search = $(event.target).val();
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.loadSales(search, $('#sale-status-filter').val());
            }, 300);
        }

        handleStatusFilter(event) {
            const status = $(event.target).val();
            this.loadSales($('#search-sales').val(), status);
        }

        handlePagination(event) {
            event.preventDefault();
            const page = $(event.currentTarget).data('page');
            this.loadSales($('#search-sales').val(), $('#sale-status-filter').val(), page);
        }

        loadSales(search = '', status = '', page = 1) {
            Preloader.enable(); // Ativa o loader
            $.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'load_sales',
                    search: search,
                    status: status,
                    page: page
                },
                success: (response) => {
                    if (response.success) {
                        $('#sales-list').html(response.data.html);
                        $('#pagination').html(response.data.pagination);
                    } else {
                        alert('Erro ao carregar vendas');
                    }
                    Preloader.disable(); // Desativa o loader
                },
                error: () => {
                    alert('Erro no Ajax');
                    Preloader.disable(); // Desativa o loader em caso de erro
                }
            });
        }
    }

    $(document).ready(() => {
        new Sales();
    });
})(jQuery);
