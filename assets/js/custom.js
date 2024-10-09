(function () {
    document.querySelectorAll(".notification-item").forEach(function (item) {
        item.addEventListener("click", function () {
            let notificationId = this.getAttribute("data-not-id");

            // Verifica se a notificação é não lida
            let wasUnread = item.classList.contains("unread");

            if (notificationId) {
                // Envia a requisição AJAX para marcar a notificação como lida
                jQuery.ajax({
                    url: sysUrls.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'mark_as_read',
                        nonce: sysUrls.mark_as_read_nonce,
                        notification_id: notificationId
                    },
                    success: function (response) {
                        if (response.success) {
                            // Atualiza o status da notificação no DOM
                            item.classList.remove("unread");
                            item.classList.add("read");

                            // Atualiza o contador de notificações não lidas somente se a notificação era não lida
                            if (wasUnread) {
                                let unreadCountElements = document.querySelectorAll('.js-unread-number');
                                unreadCountElements.forEach(function (unreadCountElement) {
                                    let unreadCount = parseInt(unreadCountElement.textContent, 10);
                                    if (unreadCount > 0) {
                                        unreadCount--;
                                        unreadCountElement.textContent = unreadCount;
                                    }
                                });
                            }
                        } else {
                            console.error(response.data.message);
                        }
                    },
                    error: function () {
                        console.error('An error occurred while marking the notification as read.');
                    }
                });
            }
        });
    });

    let removeNotificationModal = document.getElementById("removeNotificationModal");

    if (removeNotificationModal) {
        removeNotificationModal.addEventListener("show.bs.modal", function (e) {
            document.getElementById("delete-notification").addEventListener("click", function () {
                // Captura os IDs das notificações selecionadas
                let selectedNotifications = [];
                document.querySelectorAll(".notification-check input:checked").forEach(function (checkbox) {
                    let notificationItem = checkbox.closest('.notification-item');
                    if (notificationItem) {
                        selectedNotifications.push(notificationItem.getAttribute('data-not-id'));
                    }
                });

                if (selectedNotifications.length > 0) {
                    // Envia a requisição AJAX para deletar as notificações
                    jQuery.ajax({
                        url: sysUrls.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'delete_notifications',
                            nonce: sysUrls.nonce,
                            notification_ids: selectedNotifications
                        },
                        success: function (response) {
                            if (response.success) {
                                // Remove as notificações do DOM e atualiza o contador de notificações não lidas
                                selectedNotifications.forEach(function (id) {
                                    let notificationItem = document.querySelector(`.notification-item[data-not-id="${id}"]`);
                                    if (notificationItem && notificationItem.classList.contains('unread')) {
                                        // Atualiza o contador de notificações não lidas
                                        let unreadCountElements = document.querySelectorAll('.js-unread-number');
                                        unreadCountElements.forEach(function (unreadCountElement) {
                                            let unreadCount = parseInt(unreadCountElement.textContent, 10);
                                            if (unreadCount > 0) {
                                                unreadCount--;
                                                unreadCountElement.textContent = unreadCount;
                                            }
                                        });
                                    }
                                    if (notificationItem) {
                                        notificationItem.remove();
                                    }
                                });
                                alert(response.data.message);
                            } else {
                                alert(response.data.message);
                            }
                        },
                        error: function () {
                            alert('An error occurred while deleting notifications.');
                        }
                    });
                } else {
                    // alert('No notifications selected');
                }

                H();
                document.getElementById("NotificationModalbtn-close").click();
            });
        });
    }
})();

(function () {
    var Preloader = (function () {
        var htmlTag = document.documentElement;
        var preloader = document.getElementById('preloader');
        preloader.style.transition = 'all 0.4s';

        return {
            enable: function () {
                htmlTag.setAttribute('data-preloader', 'enabled');
                preloader.style.visibility = 'visible';
                preloader.style.opacity = '0.4';
            },
            disable: function () {
                htmlTag.setAttribute('data-preloader', 'disabled');
                preloader.style.visibility = 'hidden';
                preloader.style.opacity = '0';
            },
            init: function () {
                if (htmlTag.getAttribute('data-preloader') === 'enabled') {
                    preloader.style.visibility = 'visible';
                    preloader.style.opacity = '0.4';
                } else {
                    preloader.style.visibility = 'hidden';
                    preloader.style.opacity = '0';
                }
            }
        };
    })();


    window.Preloader = Preloader;

    document.addEventListener("DOMContentLoaded", function () {
        Preloader.init();

        // Esconder o preloader assim que a página estiver completamente carregada
        window.onload = function () {
            Preloader.disable();
        };
    });
})();

(function () {
    var inputFiles = document.querySelectorAll('.js-input-file');

    // Verifica se existem elementos com essa classe
    if (inputFiles.length > 0) {
        // Itera sobre todos os elementos encontrados
        inputFiles.forEach(function (input) {
            input.addEventListener('change', function (event) {
                var label = input.nextElementSibling; // O próximo elemento, que é o label
                var fileName = '';

                // Se múltiplos arquivos forem selecionados
                if (input.files && input.files.length > 1) {
                    fileName = (input.getAttribute('data-multiple-caption') || '').replace('{count}', input.files.length);
                } else if (input.files.length === 1) {
                    fileName = input.files[0].name;
                }

                // Se o nome do arquivo foi atualizado, atribuí-lo ao label
                if (fileName) {
                    label.textContent = fileName;
                } else {
                    label.textContent = 'Upload CSV'; // Caso contrário, volta ao texto padrão
                }
            });
        });
    }
})();