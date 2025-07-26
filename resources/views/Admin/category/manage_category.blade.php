@extends('Admin.index')
@section('content')
<nav aria-label="breadcrumb"style="background:#eee;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><i class="fas fa-home"></i><a href="{{route('admin1')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Category</li>
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
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $key => $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{strip_tags($category->description) }}</td>
                    <td>{{ $category->status }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('uploads/categories/' . $category->image) }}" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{route('category-edit',$category->id)}}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{route('category-delete',$category->id)}}" class="btn btn-sm btn-danger">Delete</a>    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
  

@endsection
