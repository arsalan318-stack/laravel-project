@extends('Users.Navbar')

@section('content')
<h3>Conversation</h3>
<div>
    @foreach($conversation->messages as $msg)
        <div style="margin-bottom: 10px">
            <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
        </div>
    @endforeach
</div>

<form action="{{ route('chat.send') }}" method="POST">
    @csrf
    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
    <input type="text" name="message" required>
    <button type="submit">Send</button>
</form>
@endsection
