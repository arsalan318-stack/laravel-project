Pusher.logToConsole = true;

const pusher = new Pusher('3816452c4ce6c199fe99', {
    cluster: 'mt1',
    forceTLS: true
});

let authUserId = AUTH_USER_ID;
let channel = pusher.subscribe('user.' + authUserId);

// Listen for incoming messages
channel.bind('App\\Events\\MessageSent', function (data) {
    const conversationId = data.conversation_id;
    const senderName = data.sender_name;
    const productTitle = data.product_title;

    let chatItem = $(`.conversation-link[data-conversation-id="${conversationId}"]`);

    if (chatItem.length) {
        // Already in sidebar – update badge
        let badge = chatItem.find('.badge');
        if (badge.length) {
            let count = parseInt(badge.text()) + 1;
            badge.text(count);
        } else {
            chatItem.find('.d-flex').append(`<span class="badge badge-danger">1</span>`);
        }
    } else {
        // New conversation
        $('#conversationList').prepend(`
            <a href="#" class="list-group-item list-group-item-action conversation-link" data-conversation-id="${conversationId}">
                <div class="d-flex justify-content-between">
                    <strong>${senderName}</strong>
                    <span class="badge badge-danger">1</span>
                </div>
                <small>${productTitle}</small>
            </a>
        `);
    }

    // Update unread count
    let current = parseInt($('#unreadCount').text());
    $('#unreadCount').text(current + 1);
});

// Listen for deletions
channel.bind('message.deleted', function (data) {
    $('#message-' + data.messageId).fadeOut(200, function () {
        $(this).remove();
    });
});

// Listen for typing
channel.bind('App\\Events\\TypingEvent', function (data) {
    if (data.userId !== authUserId) {
        $('#typingIndicator').text(data.userName + ' is typing...').show();
        setTimeout(() => $('#typingIndicator').fadeOut(), 2000);
    }
});

// Call this after loading chat_panel.blade via AJAX
function initChatPanel(conversationId) {
    // CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Send Message
    $('#sendMessageForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: SEND_MESSAGE_ROUTE,
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                const text = res.message.message;
                const time = res.message.created_at;
                const id = res.message.id;

                $('#chatBody').append(`
                    <div id="message-${id}" class="d-flex justify-content-end mb-2">
                        <div class="bg-primary text-white p-2 rounded">
                            ${text}
                            <br><small class="text-light">${time}</small>
                            <button class="btn btn-sm text-dark bg-primary delete-message" data-id="${id}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                        <span class="ml-1">✓</span>
                    </div>
                `);
                $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
                $('input[name="message"]').val('');
            },
            error: function (xhr) {
                console.error('Send failed:', xhr.responseText);
                alert('Send failed');
            }
        });
    });

    // Typing
    let typingTimer;
    $('#sendMessageForm input[name="message"]').on('input', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            $.post('/typing', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                conversation_id: conversationId,
            });
        }, 300);
    });

    // Delete message (delegated)
    $('#chatBody').on('click', '.delete-message', function () {
        const messageId = $(this).data('id');

        if (!confirm('Are you sure to delete this message?')) return;

        $.ajax({
            url: '/message/' + messageId,
            type: 'DELETE',
            success: function () {
                $('#message-' + messageId).fadeOut(200, function () {
                    $(this).remove();
                });
            },
            error: function (xhr) {
                alert('Failed to delete. Error: ' + xhr.status);
            }
        });
    });
}

// Global function for sidebar clicks
function loadChatPanel(conversationId) {
    $.get('/load/' + conversationId, function (res) {
        $('#chatWindow').html(res);
        initChatPanel(conversationId); // Re-init JS after AJAX
    });
}
