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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#importantChats">Important</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="allChats">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <strong>Asad</strong><small>Today 15:32</small>
                            </div>
                            <small>Iphone 13 non PTA JV</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <strong>Ali</strong><small>Today 14:10</small>
                            </div>
                            <small>Car for sale - low mileage</small>
                        </a>
                    </div>

                    <div class="tab-pane fade" id="unreadChats">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <strong>Zara</strong><small>Today 12:45</small>
                            </div>
                            <small>New furniture available</small>
                            <span class="badge badge-primary float-right">1</span>
                        </a>
                    </div>

                    <div class="tab-pane fade" id="importantChats">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between">
                                <strong>Hamza</strong>
                                <i class="fa fa-star text-warning"></i>
                            </div>
                            <small>Laptop with warranty</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 d-flex flex-column" style="height: 80vh;">

            <!-- Header -->
            <div class="border-bottom p-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="/uploads/profiles/{{$conversation->product->user['image']}}" class="rounded-circle mr-2" alt="User" style="width:50px">
                    <div>
                        <strong>{{$conversation->product->user->name}}</strong><br>
                        <small>Last active 8 hours ago</small>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <div class="mb-1 d-flex align-items-center">
                        <button class="btn btn-sm btn-light mr-1" title="Report" data-toggle="modal" data-target="#reportModal">
                            <i class="fa fa-flag text-danger"></i>
                        </button>
                        <a href="tel:03339596576" class="btn btn-sm btn-light mr-1" title="Call">
                            <i class="fa fa-phone text-success"></i>
                        </a>
                        <a href="sms:03339596576" class="btn btn-sm btn-light mr-1" title="SMS">
                            <i class="fa fa-comment text-primary"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v text-dark"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item text-danger" href="#" onclick="return confirm('Are you sure to delete chat?');">
                                    <i class="fa fa-trash mr-2"></i> Delete Chat
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#reportModal">
                                    <i class="fa fa-flag text-danger mr-2"></i> Report Chat
                                </a>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary">View Ad</button>
                </div>
            </div>

            <!-- Ad Info -->
            <div class="p-2 border-bottom d-flex align-items-center">
                <img src="/uploads/products/{{$conversation->product['image1']}}" class="mr-3" alt="Ad" style="border-radius: 8px;width:50px">
                <div>
                    <strong>{{$product->title}}</strong><br>
                    <span class="text-muted">Rs {{$conversation->product->price}}</span>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-grow-1 p-3" id="chatWrapper" style="overflow-y: auto; background: #f7f7f7;">
                <div class="text-center mb-2"><small class="text-muted">TODAY</small></div>
                <div id="chatBody">
                    @foreach($messages as $msg)
                        @if ($msg->sender_id == auth()->id())
                            <!-- Sent by me (right) -->
                            <div class="text-right mb-2">
                                <span class="bg-primary text-white p-2 rounded">{{ $msg->message }}</span>
                            </div>
                        @else
                            <!-- Received from other user (left) -->
                            <div class="text-left mb-2">
                                <span class="bg-light p-2 rounded">{{ $msg->message }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                            </div>

            <!-- Chat Input -->
            <div class="p-3 border-top">
                <div class="d-flex mt-2">
                    <input type="hidden" id="conversationId" value="{{ $conversation->id }}">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type a message...">
                    <button class="btn btn-primary ml-2" id="sendBtn">Send</button>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const userId = {{ auth()->id() }};
    const conversationId = $('#conversationId').val();

    Pusher.logToConsole = true;

    const pusher = new Pusher('3816452c4ce6c199fe99', {
        cluster: 'mt1',
        forceTLS: true
    });

    const channel = pusher.subscribe('chat.' + conversationId);

    channel.bind('App\\Events\\MessageSent', function (data) {
        if (data.sender_id != userId) {
            $('#chatBody').append(`
                <div class="text-left mb-2">
                    <span class="bg-light p-2 rounded">${data.message}</span>
                </div>
            `);
            scrollToBottom();
        }
    });

    $('#sendBtn').on('click', function () {
        const message = $('#messageInput').val().trim();
        if (!message) {
            alert("Message is empty");
            return;
        }

        $.ajax({
            url: '{{ route("chat.send") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: message,
                conversation_id: conversationId
            },
            success: function (res) {
                $('#messageInput').val('');
                $('#chatBody').append(`
                    <div class="text-right mb-2">
                        <span class="bg-primary text-white p-2 rounded">${res.message.message}</span>
                    </div>
                `);
                
                scrollToBottom();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Failed to send message.");
            }
        });
    });

    function scrollToBottom() {
        $('#chatWrapper').scrollTop($('#chatWrapper')[0].scrollHeight);
    }
</script>
@endpush
@endsection
