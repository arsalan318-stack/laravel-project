<div class="d-flex flex-column" style="height: 80vh;">
    <!-- Header -->
    <div class="border-bottom p-3 d-flex justify-content-between">
        <div>
            <strong>{{ $otherUser->name }}</strong><br>
            <small>{{ $product->title }}</small>
        </div>
    </div>

    <!-- Messages -->
    <div class="flex-grow-1 p-3" id="chatBody" style="overflow-y: auto; background: #f7f7f7;">
        <div id="typingIndicator" class="text-muted small" style="display: none;">Typing...</div>
        @foreach ($messages as $msg)
            <div
                class="d-flex {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                <div
                    class="{{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-info text-white' }} p-2 rounded">
                    {{ $msg->message }}
                    <br><small class="text-white">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}</small>
                    @if ($msg->sender_id == auth()->id())
                        <button class="btn btn-sm text-dark bg-primary delete-message" data-id="{{ $msg->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    @endif
                </div>
                @if ($msg->sender_id == auth()->id())
                    @if ($msg->is_read)
                        <span class="ml-1">✓✓</span> <!-- read -->
                    @else
                        <span class="ml-1">✓</span> <!-- sent -->
                    @endif
                @endif

            </div>
        @endforeach
    </div>

    <!-- Input -->
    <div class="border-top p-3">
        <form id="sendMessageForm">
            @csrf
            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
            <div class="d-flex">
                <input type="text" name="message" class="form-control" placeholder="Type...">
                <button class="btn btn-primary ml-2">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
function initChatPanel() {
    // CSRF setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Send Message
    $('#sendMessageForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route('chat.send') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
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
            }
        });
    });

    // Delete Message (delegated)
    $('#chatBody').on('click', '.delete-message', function() {
        const messageId = $(this).data('id');
        if (!confirm('Are you sure to delete this message?')) return;

        $.ajax({
            url: '/message/' + messageId,
            type: 'DELETE',
            success: function() {
                $('#message-' + messageId).fadeOut(200, function() {
                    $(this).remove();
                });
            }
        });
    });

    // Typing
    let typingTimer;
    $('#sendMessageForm input[name="message"]').on('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            $.post('/typing', {
                _token: '{{ csrf_token() }}',
                conversation_id: '{{ $conversation->id }}',
            });
        }, 300);
    });

    // Typing Indicator
    channel.bind('App\\Events\\TypingEvent', function(data) {
        if (data.userId !== {{ auth()->id() }}) {
            $('#typingIndicator').text(data.userName + ' is typing...').show();
            setTimeout(() => $('#typingIndicator').fadeOut(), 2000);
        }
    });
}

</script>    
