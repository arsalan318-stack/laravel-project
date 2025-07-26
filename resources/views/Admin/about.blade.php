@extends('Admin.index')
@section('content')
    <div class="row">
        <!-- Main Content -->
        <main class="col-md-10 content">
            <nav aria-label="breadcrumb"style="background:#eee;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><i class="fas fa-home"></i><a href="{{ route('admin1') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add About</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-edit"></i> Add About</span>
                    <div>
                        <i class="fas fa-cog mr-2"></i>
                        <i class="fas fa-arrow-up mr-2"></i>
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                @if (session('success'))
                    <div class="text-danger fw-bold mb-3">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($about)
                    <!-- update form -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('update_about', $about->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">About Us</label>
                                <div class="col-sm-10">
                                    <textarea name="about_us" id="editor" class="form-control" rows="5">{{ $about->about_us }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Terms & Conditions</label>
                                <div class="col-sm-10">
                                    <textarea name="terms_condition" id="editor" class="form-control" rows="5">{{ $about->terms_condition }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Privacy Policy</label>
                                <div class="col-sm-10">
                                    <textarea name="privacy_policy" id="editor" class="form-control" rows="5">{{ $about->privacy_policy }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Faq</label>
                                <div class="col-sm-10">
                                    <textarea name="faq" id="editor" class="form-control" rows="5">{{ $about->faq }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Logo</label>
                                <div class="col-sm-10">
                                    <input type="file" name="image" class="form-control" placeholder="Enter image">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">phone</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" value="{{ $about->phone }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" value="{{ $about->email }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" value="{{ $about->address }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Facebook Links</label>
                                <div class="col-sm-10">
                                    <input type="text" name="facebook" value="{{ $about->facebook }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Youtube Links</label>
                                <div class="col-sm-10">
                                    <input type="text" name="youtube" value="{{ $about->youtube }}" class="form-control"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Twitter Links</label>
                                <div class="col-sm-10">
                                    <input type="text" name="twitter" value="{{ $about->twitter }}"
                                        class="form-control" placeholder="">
                                </div>
                            </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Instagram Links</label>
                        <div class="col-sm-10">
                            <input type="text" name="instagram" value="{{ $about->instagram }}" class="form-control"
                                placeholder="">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                    </form>
            </div>
        @else
            <div class="card-body">
                <form method="POST" action="{{ route('store_about') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">About Us</label>
                        <div class="col-sm-10">
                            <textarea name="about_us" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Terms & Conditions</label>
                        <div class="col-sm-10">
                            <textarea name="terms_condition" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Privacy Policy</label>
                        <div class="col-sm-10">
                            <textarea name="privacy_policy" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Faq</label>
                        <div class="col-sm-10">
                            <textarea name="faq" id="editor" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Logo</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" class="form-control" placeholder="Enter image">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">phone</label>
                        <div class="col-sm-10">
                            <input type="text" name="phone" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" name="address" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Facebook Links</label>
                        <div class="col-sm-10">
                            <input type="text" name="facebook" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Youtube Links</label>
                        <div class="col-sm-10">
                            <input type="text" name="youtube" value="" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Twitter Links</label>
                        <div class="col-sm-10">
                            <input type="text" name="twitter" value="" class="form-control" placeholder="">
                        </div>
                    </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Instagram Links</label>
                <div class="col-sm-10">
                    <input type="text" name="instagram" value="" class="form-control" placeholder="">
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
            </form>
    </div>
    @endif
    </div>
    </main>
    </div>
@endsection
