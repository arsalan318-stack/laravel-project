@extends('Users.Navbar')

@section('content')
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-4 border-right" style="height: 80vh; overflow-y: auto;">
            <div class="p-3">
                <h5 class="font-weight-bold mb-3">INBOX</h5>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="chatTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#allChats">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#unreadChats">Unread</a>
                    </li>
                    
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="allChats">
                        @foreach($conversations as $conv)
                            @php
                                $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                            @endphp
                            <a href="{{ route('chat', [$conv->product_id, $otherUser->id]) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $otherUser->name }}</strong>
                                    <small>    {{ $conversation->latestMessage ? $conversation->latestMessage->created_at->format('h:i A') : '' }}</small>
                                </div>
                                <small>{{ $conv->product->title ?? '' }}</small>
                                @if($conv->unread_count > 0)
                                    <span class="badge badge-danger float-right">{{ $conv->unread_count }}</span>
                                @endif
                            </a>
                            
                        @endforeach
                    </div>

                    <div class="tab-pane fade" id="unreadChats">
                        @foreach($conversations->where('unread_count', '>', 0) as $conv)
                            @php
                                $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                            @endphp
                            <a href="{{ route('chat', [$conv->product_id, $otherUser->id]) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $otherUser->name }}</strong>
                                    <small>{{ $conv->latestMessage->created_at->format('H:i') ?? '' }}</small>
                                </div>
                                <small>{{ $conv->product->title ?? '' }}</small>
                                <span class="badge badge-danger float-right">{{ $conv->unread_count }}</span>
                            </a>
                        @endforeach
                    </div>

                    
                </div>
            </div>
        </div>

        <!-- Chat Window -->
        <div class="col-md-8 d-flex flex-column" style="height: 80vh;">
            <!-- Header -->
            <div class="border-bottom p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="/uploads/profiles/{{ $conversation->product->user->image }}" class="rounded-circle mr-2" style="width: 50px;">
                    <div>
                        <strong>{{ $conversation->product->user->name }}</strong><br>
                        @if($conversation->product->user->is_online)
                        <small>🟢 Online</small>
                        @else
                        <small>Last Seen {{ $conversation->product->user->last_seen ? $conversation->product->user->last_seen->diffForHumans() : 'a while ago' }}</small>
                      @endif
                    </div>
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

            <!-- Chat Body -->
            <div class="flex-grow-1 p-3" id="chatWrapper" style="overflow-y: auto; background: #f7f7f7;">
                <div class="text-center"><small class="text-muted">TODAY</small></div>
                <div id="chatBody">
                    @foreach($messages as $msg)
                        <div class="d-flex {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div class="{{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-info text-white' }} p-2 rounded">
                                {{ $msg->message }}
                                <br><small class="text-white">{{ \Carbon\Carbon::parse($msg->created_at)->format('H:i') }}</small>
                                @if($msg->sender_id == auth()->id())
                                <button class="btn btn-sm text-dark bg-primary delete-message" data-id="{{ $msg->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @endif

                                @if($msg->sender_id ==auth()->id())
                                @if($msg->is_read)
                                <span class="ml-1">✓✓</span> <!-- read -->
                            @else
                                <span class="ml-1">✓</span> <!-- sent -->
                            @endif
                            @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 border-top">
                <form id="sendMessageForm">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <input type="hidden" name="receiver_id" value="{{ $conversation->product->user_id }}">
                    <div class="d-flex">
                        <input type="text" name="message" id="messageInput" class="form-control" placeholder="Type a message...">
                        <button type="submit" class="btn btn-primary ml-2">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    const userId = {{ auth()->id() }};
    const conversationId = '{{ $conversation->id }}';

    const pusher = new Pusher('3816452c4ce6c199fe99', {
        cluster: 'mt1',
        forceTLS: true
    });

    const channel = pusher.subscribe('chat.' + conversationId);

    channel.bind('App\\Events\\MessageSent', function(data) {
        if (data.sender_id != userId) {
            $('#chatBody').append(`
                <div class="d-flex justify-content-start mb-2">
                    <div class="bg-light p-2 rounded">
                        ${data.message}<br><small class="text-muted">${data.time}</small>
                    </div>
                </div>
            `);
            scrollToBottom();
        }
    });

    $('#sendMessageForm').on('submit', function (e) {
        e.preventDefault();
        const msg = $('#messageInput').val().trim();

        if (!msg) return;

        $.ajax({
            url: '{{ route("chat.send") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function (res) {
                const time = res.message.created_at;
                
                $('#chatBody').append(`
                    <div class="d-flex justify-content-end mb-2">
                        <div class="bg-primary text-white p-2 rounded">
                            ${res.message.message}<br>
                            <small class="text-light">${time}</small>
                           
                        </div>
                        <span class="ml-1">✓</span>
                    </div>
                `);
                $('#messageInput').val('');
                scrollToBottom();
            }
        });
    });

    function scrollToBottom() {
    const chatWrapper = document.getElementById('chatBody');
    chatWrapper.scrollTop = chatWrapper.scrollHeight;
}

</script>

<script>
    let typingTimer;
$('#sendMessageForm input[name="message"]').on('input', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => {
        $.post('/typing', {
            _token: '{{ csrf_token() }}',
            conversation_id: '{{ $conversation->id }}',
        });
    }, 300);
});

    </script>

<script>

channel.bind('App\\Events\\TypingEvent', function (data) {
    if (data.userId !== {{ auth()->id() }}) {
        $('#typingIndicator').text(data.userName + ' is typing...').show();

        setTimeout(() => {
            $('#typingIndicator').fadeOut();
        }, 2000);
    }
});

    </script>

<script>
// Mark messages as read
$.ajax({
            url: '{{ route("chat.markAsRead") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                conversation_id: conversationId
            },
            success: function () {
                // Remove unread badge
                $('.conversation-link[data-conversation-id="' + conversationId + '"]').find('.badge').remove();
            }
        });
</script>

<script>
    // Setup CSRF token once
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Delete button action
    $('.delete-message').on('click', function () {
        const messageId = $(this).data('id');
    
        if (!confirm('Are you sure to delete this message?')) return;
    
        $.ajax({
            url: '/message/' + messageId,
            type: 'DELETE',
            success: function () {
                $('#message-' + messageId).remove();
            },
            error: function (xhr) {
                alert('Failed to delete. Error: ' + xhr.status);
            }
        });
    });
    
        
        </script>

<script>
    $(document).on('click', '.delete-conversation', function(e) {
        e.stopPropagation(); // Prevent triggering conversation load

        const conversationId = $(this).data('id');

        if (!confirm('Are you sure you want to delete this conversation?')) return;

        $.ajax({
            url: '/conversation/' + conversationId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if (res.success) {
                    $('.conversation-link[data-conversation-id="' + conversationId + '"]').remove();
                    $('#chatWindow').html(`
                <div class="d-flex justify-content-center align-items-center h-100 text-muted">
                    <i class="fa fa-comments fa-3x mb-3"></i>
                    <p class="ml-3">Select a chat to begin messaging</p>
                </div>
            `);
                }
            },
            error: function(err) {
                alert('Error deleting conversation.');
            }
        });
    });
</script>
@endpush
