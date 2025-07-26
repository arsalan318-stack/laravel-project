@extends('Admin.index')
@section('content')
       <div class="row">
        <!-- Main Content -->
        <main class="col-md-10 content">
            <nav aria-label="breadcrumb"style="background:#eee;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home"></i><a href="{{route('admin1')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-edit"></i> Edit Category</span>
                    <div>
                        <i class="fas fa-cog mr-2"></i>
                        <i class="fas fa-arrow-up mr-2"></i>
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <div class="card-body">
                    <form method="POST" action="{{route('category_update',$category->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" value="{{$category->name}}" class="form-control" placeholder="Enter category name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" id="editor" class="form-control" rows="5">{{$category->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image"value="{{$category->image}}" class="form-control" placeholder="Enter image">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Publication Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="Published"{{ old('status', $category->status) == 'Published' ? 'selected' : ''}}>Published</option>
                                    <option value="Unpublished"{{ old('status', $category->status) == 'unPublished' ? 'selected' : ''}}>Unpublished</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection