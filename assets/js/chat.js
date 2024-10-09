document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.chat-user-list a').forEach(function (chatUser) {
        chatUser.addEventListener('click', function (event) {
            event.preventDefault();
            var leadId = this.getAttribute('data-lead-id');
            var leadTitle = this.querySelector('.text-truncate').innerText;

            if (leadId && leadTitle) {
                document.getElementById('current_lead_id').value = leadId; // Atualize o campo hidden com o lead ID
                loadMessages(leadId, leadTitle);
            }
        });
    });

    // Função para carregar mensagens
    function loadMessages(leadId, leadTitle, append = false, onlyUnread = false) {
        console.log(`Loading messages for leadId: ${leadId}, append: ${append}, onlyUnread: ${onlyUnread}`); // Log para depuração
        var xhr = new XMLHttpRequest();
        xhr.open('POST', sysUrls.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log('Response from server:', response); // Log para depuração

                if (response.success) {
                    renderMessages(response.data, leadTitle, append);
                } else {
                    console.error('Error loading messages:', response.data);
                }
            } else {
                console.error('Error:', xhr.status, xhr.statusText);
            }
        };

        var params = new URLSearchParams({
            action: 'load_messages',
            lead_id: leadId,
            lead_title: leadTitle,
            only_unread: onlyUnread, // Envia parâmetro adicional
            security: sysUrls.general_nonce
        }).toString();

        xhr.send(params);
    }

    // Função para renderizar mensagens
    function renderMessages(messages, leadTitle, append = false) {
        if (!Array.isArray(messages)) {
            console.error('Messages is not an array:', messages); // Log para depuração
            return;
        }

        var conversationList = document.getElementById('users-conversation');
        if (!append) {
            conversationList.innerHTML = '';
        }

        messages.forEach(function (message) {
            var messageItem = document.createElement('li');
            messageItem.className = 'chat-list ' + (message.sender === leadTitle ? 'left' : 'right');

            var messageContent = `
                <div class="conversation-list">
                    <div class="user-chat-content">
                        <div class="ctext-wrap">
                            <div class="ctext-wrap-content">
                                <p class="mb-0 ctext-content">${message.message}</p>
                            </div>
                        </div>
                        <div class="conversation-name">
                            <span class="d-none name">${message.sender}</span>
                            <small class="text-muted time">${new Date(message.date).toLocaleTimeString()}</small>
                            <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                        </div>
                    </div>
                </div>`;

            messageItem.innerHTML = messageContent;
            conversationList.appendChild(messageItem);
        });

        updateChatHeader(leadTitle);
        setTimeout(scrollToBottom, 0); // Adicione um pequeno atraso para garantir que o conteúdo seja renderizado
    }

    function scrollToBottom() {
        var conversationList = document.getElementById('users-conversation');
        var lastMessage = conversationList.querySelector('li:last-child');
        if (lastMessage) {
            lastMessage.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function updateChatHeader(leadTitle) {
        document.querySelector('.username').innerText = leadTitle;
        document.querySelector('.username').setAttribute('data-id', leadTitle);
    }

    document.getElementById('chatinput-form').addEventListener('submit', function (event) {
        event.preventDefault();
        var messageInput = document.getElementById('chat-input');
        var message = messageInput.value.trim();
        var leadId = document.getElementById('current_lead_id').value;

        if (message !== '' && leadId) {
            sendMessage(leadId, message);
        }
    });

    function sendMessage(leadId, message) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', sysUrls.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                if (response.success) {
                    var conversationList = document.getElementById('users-conversation');
                    var newMessage = response.data;
                    var messageItem = document.createElement('li');
                    messageItem.className = 'chat-list right';

                    var messageContent = `
                            <div class="conversation-list">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <p class="mb-0 ctext-content">${newMessage.message}</p>
                                        </div>
                                    </div>
                                    <div class="conversation-name">
                                        <span class="d-none name">${newMessage.sender}</span>
                                        <small class="text-muted time">${new Date(newMessage.date).toLocaleTimeString()}</small>
                                        <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                                    </div>
                                </div>
                            </div>`;

                    messageItem.innerHTML = messageContent;
                    conversationList.appendChild(messageItem);
                    document.getElementById('chat-input').value = ''; // Limpa o campo de entrada de mensagem
                    setTimeout(scrollToBottom, 0); // Adicione um pequeno atraso para garantir que o conteúdo seja renderizado
                } else {
                    console.error('Error sending message:', response.data);
                }
            } else {
                console.error('Error:', xhr.status, xhr.statusText);
            }
        };

        var params = new URLSearchParams({
            action: 'send_message',
            lead_id: leadId,
            message: message,
            security: sysUrls.general_nonce
        }).toString();

        xhr.send(params);
    }

    // Função para verificar mensagens não lidas
    function checkUnreadMessages() {
        var leadIds = Array.from(document.querySelectorAll('.chat-user-list a')).map(function (chatUser) {
            return chatUser.getAttribute('data-lead-id');
        });

        var xhr = new XMLHttpRequest();
        xhr.open('POST', sysUrls.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log('Unread messages response:', response); // Log para depuração

                if (response.success) {
                    var currentLeadId = document.getElementById('current_lead_id').value;
                    var unreadCounts = response.data;

                    updateUnreadMessages(unreadCounts);

                    // Verifica se há novas mensagens para a janela de chat aberta atualmente
                    if (unreadCounts[currentLeadId] > 0) {
                        console.log(`New unread messages for leadId: ${currentLeadId}`); // Log para depuração
                        loadMessages(currentLeadId, document.querySelector('.username').innerText, true, true);
                    }

                    // Reordenar a lista de leads
                    reorderLeads(unreadCounts);
                } else {
                    console.error('Error checking unread messages:', response.data);
                }
            } else {
                console.error('Error:', xhr.status, xhr.statusText);
            }
        };

        var params = new URLSearchParams({
            action: 'check_unread_messages',
            leads: JSON.stringify(leadIds),
            security: sysUrls.general_nonce
        }).toString();

        xhr.send(params);
    }

    function updateUnreadMessages(unreadCounts) {
        document.querySelectorAll('.chat-user-list a').forEach(function (chatUser) {
            var leadId = chatUser.getAttribute('data-lead-id');
            var unreadCount = unreadCounts[leadId] || 0;
            var badge = chatUser.querySelector('.badge');

            if (unreadCount > 0) {
                badge.innerText = unreadCount;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        });
    }

    // Função para reordenar a lista de leads
    function reorderLeads(unreadCounts) {
        var leadList = document.querySelector('.chat-user-list');
        var leads = Array.from(leadList.children);

        leads.sort(function (a, b) {
            var leadIdA = a.querySelector('a').getAttribute('data-lead-id');
            var leadIdB = b.querySelector('a').getAttribute('data-lead-id');
            var unreadCountA = unreadCounts[leadIdA] || 0;
            var unreadCountB = unreadCounts[leadIdB] || 0;

            if (unreadCountA === unreadCountB) {
                // Se ambos têm a mesma contagem de não lidos, mantenha a ordem atual
                return 0;
            }
            return unreadCountB - unreadCountA; // Ordem decrescente de mensagens não lidas
        });

        leads.forEach(function (lead) {
            leadList.appendChild(lead);
        });
    }

    // Verificar mensagens não lidas periodicamente (por exemplo, a cada 2,5 segundos)
    setInterval(checkUnreadMessages, 2500);
});
