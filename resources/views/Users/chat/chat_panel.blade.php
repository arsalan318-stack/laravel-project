<div class="d-flex flex-column" style="height: 80vh;">
    <!-- Header -->
    <div class="border-bottom p-3 d-flex justify-content-between">
        <div>
            <img src="/uploads/profiles/{{ $otherUser->image }}" class="rounded-circle mr-2" style="width: 50px;">
            <strong>{{ $otherUser->name }}</strong><br>
            @if($otherUser->isOnline())
            <small> Online</small>
            @else
            <small>Last seen {{ $otherUser->last_seen ? $otherUser->last_seen->diffForHumans() : 'a while ago' }}</small>
            @endif
        </div>
        <div class="d-flex flex-column align-items-end">
            <div class="d-flex align-items-center mb-1">
                <button class="btn btn-sm btn-light mr-1" title="Report">
                    <i class="fa fa-flag text-danger"></i>
                </button>
                <a href="tel:{{ $conversation->product->user->phone }}" class="btn btn-sm btn-light mr-1"><i class="fa fa-phone text-success"></i></a>
                <a href="sms:{{ $conversation->product->user->phone }}" class="btn btn-sm btn-light mr-1"><i class="fa fa-comment text-primary"></i></a>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-toggle="dropdown">
                        <i class="fa fa-ellipsis-v text-dark"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item text-danger delete-conversation" data-id="{{$conversation->id}}" href="#"><i class="fa fa-trash mr-2"></i> Delete Chat</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-flag mr-2 text-danger"></i> Report Chat</a>
                    </div>
                </div>
            </div>
            <a href="{{ route('get_product_details', $conversation->product->id) }}" class="btn btn-sm btn-outline-primary">View Ad</a>
        </div>
    </div>
 <!-- Ad Info -->
 <div class="p-2 border-bottom d-flex align-items-center">
    <img src="/uploads/products/{{ $conversation->product->image1 }}" class="mr-3" style="width: 50px; border-radius: 8px;">
    <div>
        <strong>{{ $product->title }}</strong><br>
        <span class="text-muted">Rs {{ $product->price }}</span>
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
