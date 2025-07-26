 @extends('Users.Navbar')
 @section('content')
     <!-- Product Area Start Here -->
     <section class="s-space-bottom-full bg-accent-shadow-body">
         <div class="container">
             <div class="breadcrumbs-area">
                 <ul>
                     <li><a href="#">Home</a> -</li>
                     <li><a href="#">Electronics</a> -</li>
                     <li class="active">Computer</li>
                 </ul>
             </div>
         </div>
         <div class="container">
             <div class="row">
                 <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 col-12">
                     <div class="gradient-wrapper item-mb">
                         <div class="gradient-title">
                             <h2>{{ $products->title }}</h2>
                         </div>
                         <div class="gradient-padding reduce-padding">
                             <div class="single-product-img-layout1 d-flex mb-50">
                                 <ul class="nav tab-nav tab-nav-list">
                                     <li class="nav-item">
                                         <a class="active" href="#related1" data-toggle="tab" aria-expanded="false">
                                             <img alt="related1" src="/uploads/products/{{ $products['image1'] }}"
                                                 class="img-fluid" style="height:100px;object-fit:cover;"></a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="#related2" data-toggle="tab" aria-expanded="false"><img alt="related2"
                                                 src="/uploads/products/{{ $products['image2'] }}" class="img-fluid"style="height:100px;object-fit:cover;"></a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="#related3" data-toggle="tab" aria-expanded="false"><img alt="related3"
                                                 src="/uploads/products/{{ $products['image3'] }}" class="img-fluid"style="height:100px;object-fit:cover;"></a>
                                     </li>
                                     <li class="nav-item">
                                         <a href="#related4" data-toggle="tab" aria-expanded="false"><img alt="related4"
                                                 src="/uploads/products/{{ $products['image3'] }}" class="img-fluid"style="height:100px;object-fit:cover;"></a>
                                     </li>
                                 </ul>
                                 <div class="tab-content">
                                     <span class="price">{{ $products->price }}</span>
                                     <div class="tab-pane fade active show" id="related1">
                                         <a href="#" class="zoom ex1"><img alt="single"
                                                 src="/uploads/products/{{ $products['image1'] }}" class="img-fluid"style="height:400px;object-fit:cover"></a>
                                     </div>
                                     <div class="tab-pane fade" id="related2">
                                         <a href="#" class="zoom ex1"><img alt="single"
                                                 src="/uploads/products/{{ $products['image2'] }}" class="img-fluid"style="height:400px;object-fit:cover;"></a>
                                     </div>
                                     <div class="tab-pane fade" id="related3">
                                         <a href="#" class="zoom ex1"><img alt="single"
                                                 src="/uploads/products/{{ $products['image3'] }}" class="img-fluid"style="height: 400px;object-fit:cover;"></a>
                                     </div>
                                     <div class="tab-pane fade" id="related4">
                                         <a href="#" class="zoom ex1"><img alt="single"
                                                 src="/uploads/products/{{ $products['image3'] }}" class="img-fluid"style="height: 400px;object-fit:cover;"></a>
                                     </div>
                                 </div>
                             </div>
                             <div class="section-title-left-dark child-size-xl title-bar item-mb">
                                 <h3>Product Details:</h3>
                                 <p class="text-medium-dark">{{ $products->description }}
                                 </p>
                             </div>
                             <div class="row">
                                 <div class="col-lg-8 col-md-7 col-sm-12 col-12">
                                     <div class="section-title-left-primary child-size-xl">
                                         <h3>Specification:</h3>
                                     </div>
                                     @if ($products->features)
                                         <ul class="specification-layout2 mb-40">
                                             @foreach ($products->features as $key => $value)
                                                 <li>
                                                     <strong>{{ ucfirst($key) }}:</strong>
                                                     @if (is_array($value))
                                                         {{ implode(', ', $value) }}
                                                     @else
                                                         {{ $value }}
                                                     @endif
                                                 </li>
                                             @endforeach
                                         </ul>
                                     @endif
                                 </div>
                                 <div class="col-lg-4 col-md-5 col-sm-12 col-12 mb--sm">
                                     <div class="section-title-left-primary child-size-xl">
                                         <h3>Item Details:</h3>
                                     </div>
                                     <ul class="sidebar-item-details p-none">
                                         <li>Condition:<span>New</span></li>
                                         <li>Brand:<span>Apple</span></li>
                                         <li>Color:<span>White</span></li>
                                         <li>Warranty:<span>1 Year</span></li>
                                         <li>
                                             <ul class="sidebar-social">
                                                 <li>Share:</li>
                                                 <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                 </li>
                                                 <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                                 </li>
                                                 <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                                 </li>
                                                 <li><a href="#"><i class="fa fa-pinterest"
                                                             aria-hidden="true"></i></a></li>
                                             </ul>
                                         </li>
                                     </ul>
                                 </div>
                             </div>
                             <ul class="item-actions border-top">
                                 <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i>Save Ad</a></li>
                                 <li><a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i>Share ad</a></li>
                                 <li><a href="#"><i class="fa fa-exclamation-triangle"
                                             aria-hidden="true"></i>Report abuse</a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 item-mb">
                     <div class="sidebar-item-box">
                         <div class="gradient-wrapper">
                             <div class="gradient-title">
                                 <h3>Seller Information</h3>
                             </div>
                             <ul class="sidebar-seller-information">
                                 <li>
                                     <div class="media">
                                        @if($products->user->image)
                                         <img src="/uploads/profiles/{{ $products->user['image'] }}"style="width:50px"
                                             alt="user" class="img-fluid pull-left">
                                             @else
                                             <img src="{{asset('img/user/user1.png')}}"style="width:50px"
                                             alt="user" class="img-fluid pull-left">
                                             @endif
                                         <div class="media-body">
                                             <span>Posted By</span>
                                             <h4>{{ $products->user->name }}</h4>
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="media">
                                         <img src="{{ asset('img/user/user2.png') }}" alt="user"
                                             class="img-fluid pull-left">
                                         <div class="media-body">
                                             <span>Location</span>
                                             @if($products->user->address)
                                             <h4>{{ $products->user->address }}</h4>
                                             @else
                                             <h4>N.A</h4>
                                             @endif
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="media">
                                         <img src="{{ asset('img/user/user3.png') }}" alt="user"
                                             class="img-fluid pull-left">
                                         <div class="media-body">
                                             <span>Contact Number</span>
                                             @if($products->hide_phone=='1')
                                             <h4>**********</h4>
                                             @else
                                             <h4>{{$products->phone}}</h4>
                                             @endif
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="media">
                                         <img src="{{ asset('img/user/user4.png') }}" alt="user"
                                             class="img-fluid pull-left">
                                         <div class="media-body">
                                             <span>Want To Live Chat</span>
                                             <h4><a href="{{route('chat',['id' => $products->id,'receiverId' => $products->user_id])}}">Chat Now!</a></h4>
                                         </div>
                                     </div>
                                 </li>
                                 <li>
                                     <div class="media">
                                         <img src="{{ asset('img/user/user5') }}.png" alt="user"
                                             class="img-fluid pull-left">
                                         <div class="media-body">
                                             <span>User Type</span>
                                             @if($products->user->email_verified_at)
                                             <h4>Verified</h4>
                                             @else
                                             <h4>Unverified</h4>
                                             @endif
                                         </div>
                                     </div>
                                 </li>
                             </ul>
                         </div>
                     </div>
                     <div class="sidebar-item-box">
                         <div class="gradient-wrapper">
                             <div class="gradient-title">
                                 <h3>Item Details</h3>
                             </div>
                             <ul class="sidebar-item-details">
                                 <li>Condition:<span>New</span></li>
                                 <li>Brand:<span>Apple</span></li>
                                 <li>Color:<span>White</span></li>
                                 <li>Warranty:<span>1 Year</span></li>
                                 <li>
                                     <ul class="sidebar-social">
                                         <li>Share:</li>
                                         <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                         <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                         <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                         <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                                         </li>
                                     </ul>
                                 </li>
                             </ul>
                         </div>
                     </div>
                     <div class="sidebar-item-box">
                         <div class="gradient-wrapper">
                             <div class="gradient-title">
                                 <h3>Safety Tips for Buyers</h3>
                             </div>
                             <ul class="sidebar-safety-tips">
                                 <li>Meet seller at a public place</li>
                                 <li>Check The item before you buy</li>
                                 <li>Pay only after collecting The item</li>
                             </ul>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="gradient-wrapper">
                 <div class="gradient-title">
                     <h2>More Ads From This User </h2>
                 </div>
                 <div class="gradient-padding">

                     <div class="cp-carousel nav-control-middle category-grid-layout1" data-loop="" data-items="5"
                         data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000"
                         data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1"
                         data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2"
                         data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="3"
                         data-r-small-nav="true" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="true"
                         data-r-medium-dots="false" data-r-Large="5" data-r-Large-nav="true" data-r-Large-dots="false">

                         @foreach ($userAds as $ad)
                             <div class="product-box item-mb zoom-gallery">
                                 <div class="item-mask-wrapper">
                                     <div class="item-mask secondary-bg-box">
                                         <img src="{{ asset('uploads/products/' . $ad->image1) }}"
                                             alt="{{ $ad->title }}" class="img-fluid" style="width:100%;height:100px;object-fit:cover;">
                                         <div class="trending-sign active" data-tips="Featured">
                                             <i class="fa fa-bolt" aria-hidden="true"></i>
                                         </div>
                                         <div class="title-ctg">{{ $ad->category->name ?? 'N/A' }}</div>
                                         <ul class="info-link">
                                             <li><a href="{{ asset('uploads/products/' . $ad->image1) }}"
                                                     class="elv-zoom" data-fancybox-group="gallery"
                                                     title="{{ $ad->title }}"><i class="fa fa-arrows-alt"></i></a>
                                             </li>
                                             <li><a href="{{ route('get_product_details', $ad->id) }}"><i
                                                         class="fa fa-link"></i></a></li>
                                         </ul>
                                         <div class="symbol-featured">
                                             <img src="{{ asset('img/banner/symbol-featured.png') }}" alt="symbol"
                                                 class="img-fluid">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="item-content">
                                     <div class="title-ctg">{{ $ad->category->name ?? 'N/A' }}</div>
                                     <h3 class="short-title">
                                         <a
                                             href="{{ route('get_product_details', $ad->id) }}">{{ Str::limit($ad->title, 6) }}</a>
                                     </h3>
                                     <h3 class="long-title">
                                         <a href="{{ route('get_product_details', $ad->id) }}">{{ $ad->title }}</a>
                                     </h3>
                                     <ul class="upload-info">
                                         <li class="date"><i
                                                 class="fa fa-clock-o"></i>{{ $ad->created_at->format('d M, Y') }}</li>
                                         <li class="place"><i
                                                 class="fa fa-map-marker"></i>{{ $ad->location ?? 'Unknown' }}</li>
                                         <li class="tag-ctg"><i class="fa fa-tag"></i>{{ $ad->category->name ?? 'N/A' }}
                                         </li>
                                     </ul>
                                     <p>{{ Str::limit($ad->description, 100) }}</p>
                                     <div class="price">${{ $ad->price }}</div>
                                     <a href="{{ route('get_product_details', $ad->id) }}"
                                         class="product-details-btn">Details</a>
                                 </div>
                             </div>
                         @endforeach
                     </div>

                 </div>
             </div>
         </div>
     </section>
     <!-- Product Area End Here -->
 @endsection
