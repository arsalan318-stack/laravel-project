@extends('Users.Navbar')

@section('content')
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-4 border-right" style="height: 80vh; overflow-y: auto;">
            <div class="p-3">
                <h5 class="font-weight-bold mb-3">INBOX</h5>

                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#all">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#unread">Unread
                            <span class="badge badge-danger ml-1" id="unreadCount">
                                {{ $conversations->where('unread_count', '>', 0)->count() }}
                            </span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all">
                        <div id="conversationList">
                            @foreach($conversations as $conv)
                                @php
                                    $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                                @endphp
                                <a href="#" class="list-group-item list-group-item-action conversation-link"
                                   data-conversation-id="{{ $conv->id }}">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $otherUser->name }}</strong>
                                        <small>    {{ $conv->latestMessage ? $conv->latestMessage->created_at->format('h:i A') : '' }}</small>
                                        @if($conv->unread_count > 0)
                                            <span class="badge badge-danger">{{ $conv->unread_count }}</span>
                                        @endif
                                    </div>
                                    <small>{{ $conv->product->title ?? '' }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="unread">
                        <div id="unreadList">
                            @foreach($conversations->where('unread_count', '>', 0) as $conv)
                                @php
                                    $otherUser = $conv->sender_id == auth()->id() ? $conv->receiver : $conv->sender;
                                @endphp
                                <a href="#" class="list-group-item list-group-item-action conversation-link"
                                   data-conversation-id="{{ $conv->id }}">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $otherUser->name }}</strong>
                                        <span class="badge badge-danger">{{ $conv->unread_count }}</span>
                                        <small>    {{ $conv->latestMessage ? $conv->latestMessage->created_at->format('h:i A') : '' }}</small>
                                    </div>
                                    <small>{{ $conv->product->title ?? '' }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Window -->
        <div class="col-md-8" id="chatWindow">
            <div class="d-flex justify-content-center align-items-center h-100 text-muted">
                <i class="fa fa-comments fa-3x mb-3"></i>
                <p class="ml-3">Select a chat to begin messaging</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Click on chat
    $(document).on('click', '.conversation-link', function (e) {
        e.preventDefault();

        let conversationId = $(this).data('conversation-id');

        // Load chat window
        $.ajax({
            url: '/load/' + conversationId,
            type: 'GET',
            success: function (res) {
                $('#chatWindow').html(res);
            }
        });

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
    });
});
</script>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
Pusher.logToConsole = true;

var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
    forceTLS: true
});

let authUserId = {{ auth()->id() }};
let channel = pusher.subscribe('user.' + authUserId);

// Real-time update: add/update chat
channel.bind('App\\Events\\MessageSent', function(data) {
    const conversationId = data.conversation_id;
    const senderName = data.sender_name;
    const productTitle = data.product_title;

    let chatItem = $(`.conversation-link[data-conversation-id="${conversationId}"]`);
    if (chatItem.length) {
        // Already in sidebar – just update badge
        let badge = chatItem.find('.badge');
        if (badge.length) {
            let count = parseInt(badge.text()) + 1;
            badge.text(count);
        } else {
            chatItem.find('.d-flex').append(`<span class="badge badge-danger">1</span>`);
        }
    } else {
        // New chat item – prepend
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

    // Update unread tab count
    let current = parseInt($('#unreadCount').text());
    $('#unreadCount').text(current + 1);
});
</script>

    
@endpush
