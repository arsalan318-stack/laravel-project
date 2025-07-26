@extends('Users.Navbar')

@section('content')

<div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ms-0" href="#" target="">Profile</a>
    </nav>
    <hr class="mt-0 mb-4">
    @if (count($errors) > 0)
          <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                      @foreach($errors->all() as $error)
                      {{ $error }} <br>
                      @endforeach      
                  </div>
              </div>
          </div>
        @endif
    <form action="{{url('/profile-update')}}" method="POST" enctype="multipart/form-data">
     @csrf
     <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" name="image" src="/uploads/profiles/{{$data['image']}}" alt="">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                  <!--  <button class="btn btn-primary" type="file">Upload new image</button> -->
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)
                        <div class="mb-3">
                            <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                            <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="username">
                        </div> -->
                        
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">First name</label>
                                <input class="form-control" name="fname" id="inputFirstName" type="text" placeholder="Enter your first name" value="{{old('fname',$data->fname??'')}}">
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Last name</label>
                                <input class="form-control" name="lname" id="inputLastName" type="text" placeholder="Enter your last name" value="{{old('lname',$data->lname??'')}}">
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (telephone)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Telephone</label>
                                <input class="form-control" name="tel" id="inputOrgName" type="text" placeholder="Enter your telephone" value="{{old('tel',$data->tel??'')}}">
                            </div>
                            <!-- Form Group (post code)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Post code</label>
                                <input class="form-control" name="postcode" id="inputLocation" type="text" placeholder="Enter your post code" value="{{old('postcode',$data->postcode??'')}}">
                            </div>
                        </div>
                        <!-- Form Group (address)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Address</label>
                            <input class="form-control" name="address" id="inputEmailAddress" type="text" placeholder="Enter your address" value="{{old('address',$data->address??'')}}">
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Phone number</label>
                                <input class="form-control" name="phone" id="inputPhone" type="tel" placeholder="Enter your phone number" value="{{old('phone',$data->phone??'')}}">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Birthday</label>
                                <input type="date" name="dob" class="form-control" name="dob" value="{{old('dob',$data->dob??'')}}" required>
                            </div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (cnic number)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">Cnic number</label>
                                <input class="form-control" name="cnic" id="inputPhone" type="tel" placeholder="Enter your cnic number" value="{{old('cnic',$data->cnic??'')}}">
                            </div>
                            <!-- Form Group (gender)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Gender</label>
                                <select class="form-control" name="gender" aria-label="Default select example">
                                   <option selected>Select Gender</option>
                                   <option value="male"{{old('gender',$data->gender??'')=='male'?'selected':''}}>Male</option>
                                   <option value="female"{{old('gender',$data->gender??'')=='female'?'selected':''}}>Female</option>
                                </select>                           
                            
                            </div>
                        </div>
                         <!-- Form Row-->
                         <div class="row gx-3 mb-3">
                            <!-- Form Group (city)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputPhone">City</label>
                                <input class="form-control" name="city" id="inputPhone" type="tel" placeholder="Enter your city name" value="{{old('city',$data->city??'')}}">
                            </div>
                            <!-- Form Group (country)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputBirthday">Country</label>
                                <input class="form-control" name="country" id="inputBirthday" type="text" name="birthday" placeholder="Enter your country name" value="{{old('country',$data->country??'')}}">
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
     </div>
    </Form>
</div>

@endsection