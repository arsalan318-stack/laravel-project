@extends('Admin.index')
@section('content')
       <div class="row">
        <!-- Main Content -->
        <main class="col-md-10 content">
            <nav aria-label="breadcrumb"style="background:#eee;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home"></i><a href="{{route('admin1')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add SubCategory</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-edit"></i> Add SubCategory</span>
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
                    <form method="POST" action="{{route('store_subcategory')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category_id" class="form-control">
                                    @foreach ($category as $category)
                                    <option value="{{ $category->id }}"{{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">SubCategory Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Enter category name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Add Custom Fields</label>
                            <div class="col-sm-10">
                                <div id="dynamic-field-container">
                                    <div class="row mb-2 dynamic-field-group">
                                        <div class="col-md-4">
                                            <input type="text" name="fields[0][field_name]" class="form-control" placeholder="Field Name">
                                        </div>
                                        <div class="col-md-4">
                                            <select name="fields[0][field_type]" class="form-control">
                                                <option value="text">Text</option>
                                                <option value="select">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="fields[0][field_options]" class="form-control" placeholder="Options (comma separated)">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-success mt-2" id="add-field-btn">Add Field</button>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">SubCategory Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" id="editor" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" class="form-control" placeholder="Enter image">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Publication Status</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control">
                                    <option value="Published">Published</option>
                                    <option value="Unpublished">Unpublished</option>
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