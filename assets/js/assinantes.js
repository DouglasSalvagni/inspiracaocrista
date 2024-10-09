(function($) {
    class Assinantes {
        constructor() {
            this.debounceTimer = null;
            this.initialize();
        }

        initialize() {
            this.bindEvents();
            this.loadAssinantes();
        }

        bindEvents() {
            $('#search-assinantes').on('keyup', this.handleSearch.bind(this));
            $('#assinante-status-filter').on('change', this.handleStatusFilter.bind(this));
            $(document).on('click', '.page-link', this.handlePagination.bind(this));
            $(document).on('click', '.assinante-link', this.loadAssinanteDetail.bind(this));
        }

        handleSearch(event) {
            const search = $(event.target).val();
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.loadAssinantes(search, $('#assinante-status-filter').val());
            }, 300);
        }

        handleStatusFilter(event) {
            const status = $(event.target).val();
            this.loadAssinantes($('#search-assinantes').val(), status);
        }

        handlePagination(event) {
            event.preventDefault();
            const page = $(event.currentTarget).data('page');
            this.loadAssinantes($('#search-assinantes').val(), $('#assinante-status-filter').val(), page);
        }

        loadAssinantes(search = '', status = '', page = 1) {
            Preloader.enable(); // Ativa o loader
            $.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'load_assinantes',
                    search: search,
                    status: status,
                    page: page
                },
                success: (response) => {
                    if (response.success) {
                        $('#assinantes-list').html(response.data.html);
                        $('#pagination').html(response.data.pagination);

                        // Carrega os detalhes do primeiro assinante da lista
                        const firstAssinante = $('#assinantes-list .assinante-item:first-child .assinante-link');
                        if (firstAssinante.length > 0) {
                            this.loadAssinanteDetail({ 
                                preventDefault: () => {}, 
                                currentTarget: firstAssinante[0] 
                            });
                        }
                    } else {
                        alert('Erro ao carregar assinantes');
                    }
                    Preloader.disable(); // Desativa o loader
                },
                error: () => {
                    alert('Erro no Ajax');
                    Preloader.disable(); // Desativa o loader em caso de erro
                }
            });
        }

        loadAssinanteDetail(event) {
            event.preventDefault();
            const assinanteId = $(event.currentTarget).data('id');
            Preloader.enable(); // Ativa o loader
            $.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'get_assinante_detail',
                    id: assinanteId
                },
                success: (response) => {
                    if (response.success) {
                        const data = response.data;
                        $('#assinante-name').text(data.name);
                        $('#assinante-email').text(data.email);
                        $('#assinante-phone-link').attr('href', `tel:${data.phone}`);
                        $('#assinante-email-link').attr('href', `mailto:${data.email}`);

                        // Aplicar máscaras
                        const cpfCnpj = data.cpf_cnpj;
                        const phone = data.phone;

                        $('#assinante-cpf_cnpj').unmask();
                        if (cpfCnpj.length === 11) {
                            $('#assinante-cpf_cnpj').text(cpfCnpj).mask('000.000.000-00');
                        } else if (cpfCnpj.length === 14) {
                            $('#assinante-cpf_cnpj').text(cpfCnpj).mask('00.000.000/0000-00');
                        }

                        $('#assinante-phone').unmask().text(phone).mask('(00) 00000-0000');

                        // Adicionar email nas informações pessoais
                        $('#assinante-email-info').text(data.email);

                        // Atualizar botão de editar lead com o ID do assinante
                        $('#assinante-edit-link').attr('data-params', JSON.stringify({ assinante_id: assinanteId }));
                    } else {
                        alert('Erro ao carregar detalhes do assinante');
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
        new Assinantes();
    });
})(jQuery);
