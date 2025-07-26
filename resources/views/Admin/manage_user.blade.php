@extends('Admin.index')
@section('content')
<nav aria-label="breadcrumb"style="background:#eee;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><i class="fas fa-home"></i><a href="{{route('admin1')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage SubCategory</li>
    </ol>
</nav>
@if (session('success'))
    <div class="text-danger fw-bold mb-3">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="text-danger fw-bold mb-3">
        {{ session('error') }}
    </div>
@endif
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Address</th>
                <th>User Type</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ strip_tags($user->email) }}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        @if($user->role=='admin')
                        Admin
                        @elseif($user->email_verified_at)
                        Verified
                        @else
                        Unverified
                        @endif
                    </td>
                    <td>
                        @if($user->image)
                            <img src="{{ asset('uploads/profiles/' . $user->image) }}" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if (!$user->is_banned)
                        <form method="POST" action="{{ route('user_ban', $user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Ban</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('user_unban', $user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Unban</button>
                        </form>
                    @endif
                        <a href="{{route('product_delete',$user->id)}}" class="btn btn-sm btn-danger">Delete</a>    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
  

@endsection
