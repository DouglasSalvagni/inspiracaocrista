(function ($) {
    class ModalHandler {
        constructor() {
            this.initialize();
        }

        initialize() {
            this.bindEvents();
        }

        bindEvents() {
            $(document).on('click', '.js-dynamic-modal', this.handleModalOpen.bind(this));
        }

        handleModalOpen(event) {
            const button = $(event.currentTarget);
            // Forçar a atualização para pegar os dados mais recentes
            button.removeData('params');
            const contentId = button.data('content');
            const modalTarget = button.data('bs-target');
            const modal = $(modalTarget);
            const modalBody = modal.find('.modal-body');
            const params = button.data('params') || {};

            this.loadModalContent(contentId, modalBody, params, () => {
                this.loadAdditionalScripts();
            });
        }


        loadModalContent(contentId, modalBody, params, callback) {
            Preloader.enable();
            modalBody.html('');

            $.ajax({
                url: sysUrls.ajax_url,
                method: 'POST',
                data: {
                    action: 'load_modal_content',
                    content_id: contentId,
                    params: params
                },
                success: (response) => {
                    if (response.success) {
                        modalBody.html(response.data);
                        if (typeof callback === 'function') {
                            callback();
                        }
                    } else {
                        modalBody.html(`<p>Error: ${response.data}</p>`);
                    }
                    Preloader.disable();
                },
                error: () => {
                    modalBody.html('<p>Error loading modal content. </p>');
                    Preloader.disable();
                }
            });
        }

        loadAdditionalScripts() {
            // Load the Choices.js library
            if (typeof Choices === 'undefined') {
                $.getScript('https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js', () => {
                    this.initializeChoices();
                });
            } else {
                this.initializeChoices();
            }


            // new FormHandler('#edit-assinante-form', {
            //     action: 'submit_edit_assinante',
            //     beforeSendCallback: function () {
            //         Preloader.enable();
            //     },
            //     successCallback: function (response) {
            //         alert('Dados atualizados com sucesso!');
            //         $('#modalFooter').modal('hide');
            //         Preloader.disable();
            //     },
            //     errorCallback: function (response) {
            //         alert('Erro ao atualizar os dados: ' + response.data);
            //         Preloader.disable();
            //     }
            // });
        }

        initializeChoices() {
            // Initialize Choices.js on relevant elements
            const choiceElements = document.querySelectorAll('[data-choices]');
            choiceElements.forEach((element) => {
                new Choices(element);
            });
        }
    }

    $(document).ready(() => {
        new ModalHandler();
    });
})(jQuery);

(function ($) {
    class FormHandler {
        constructor(formSelector, options = {}) {
            this.form = $(formSelector);
            this.settings = $.extend({
                ajaxUrl: sysUrls.ajax_url,
                successCallback: null,
                errorCallback: null,
                beforeSendCallback: null,
                action: '',
                additionalData: {}
            }, options);

            this.bindEvents();
        }

        bindEvents() {
            this.form.on('submit', this.handleSubmit.bind(this));
        }

        handleSubmit(event) {
            event.preventDefault();

            // Obter o ID do produto de referência
            let inputElement = this.form.find('input[name=id]');
            let inputValue = inputElement.val();
            let dataRefId = this.form.attr('data-ref-id');
            let theId = inputValue ? inputValue : dataRefId;

            let formData = [];
            formData = this.form.serializeArray();
            console.log(formData)
            formData.push({ name: 'action', value: this.settings.action });

            // Append additional data if provided
            formData.push({ name: 'assinante_id', value: theId });
            for (const key in this.settings.additionalData) {
                if (this.settings.additionalData.hasOwnProperty(key)) {
                    formData.push({ name: key, value: this.settings.additionalData[key] });
                }
            }

            $.ajax({
                url: this.settings.ajaxUrl,
                method: 'POST',
                data: formData,
                beforeSend: () => {
                    if (typeof this.settings.beforeSendCallback === 'function') {
                        this.settings.beforeSendCallback();
                    }
                },
                success: (response) => {
                    if (response.success) {
                        if (typeof this.settings.successCallback === 'function') {
                            this.settings.successCallback(response);
                        }
                    } else {
                        if (typeof this.settings.errorCallback === 'function') {
                            this.settings.errorCallback(response);
                        }
                    }
                },
                error: () => {
                    if (typeof this.settings.errorCallback === 'function') {
                        this.settings.errorCallback({ success: false, data: 'Erro ao enviar o formulário.' });
                    }
                }
            });
        }
    }


    window.FormHandler = FormHandler;

    $(document).ready(function () {
        new FormHandler('#edit-assinante-form', {
            action: 'submit_edit_assinante',
            beforeSendCallback: function () {
                Preloader.enable();
            },
            successCallback: function (response) {
                alert('Dados atualizados com sucesso!');
                $('#modalFooter').modal('hide');
                Preloader.disable();
            },
            errorCallback: function (response) {
                alert('Erro ao atualizar os dados: ' + response.data);
                Preloader.disable();
            }
        });
    });
})(jQuery);

