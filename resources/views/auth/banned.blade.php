@extends('Users.Navbar') {{-- or your master layout --}}

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <h2>Your Account Has Been Banned</h2>

        @if(isset($until) && $until)
            <p>You are temporarily banned until: <strong>{{ $until }}</strong></p>
        @endif

        @if(isset($reason) && $reason)
            <p><strong>Reason:</strong> {{ $reason }}</p>
        @endif

        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Go Back to Login</a>
    </div>
</div>
@endsection
