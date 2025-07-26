@extends('Users.Navbar')

@section('content')
<h3>Inbox</h3>
<ul>
@foreach($conversations as $convo)
    <li>
        <a href="{{ route('chat.show', $convo->id) }}">
            Chat with {{ auth()->id() === $convo->sender_id ? $convo->receiver->name : $convo->sender->name }}
        </a>
    </li>
@endforeach
</ul>
@endsection
