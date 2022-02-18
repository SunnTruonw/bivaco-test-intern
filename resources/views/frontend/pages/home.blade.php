@extends('frontend.layouts.main')
@section('title', 'Laravel')
@section('image', '')
@section('keywords', '')
@section('description', '')
@section('abstract', '')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            <!-- <h1 class="d-none">
                {h1trangchu}
            </h1>
            <h2 class="d-none">
                {h2trangchu}
            </h2> -->
            <div class="bg-home">
                <div class="slide">
                    @isset($slider)
                    <div class="box-slide faded cate-arrows-1 d-none d-md-block">
                        @foreach ($slider as $item)
                        <div class="item-slide">
                            <a href=""><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                        </div>
                        @endforeach
                    </div>
                    @endisset
                    @isset($slidersM)
                    <div class="box-slide faded cate-arrows-1 d-block d-md-none" >
                        @foreach ($slidersM as $item)
                        <div class="item-slide">
                            <a href=""><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                        </div>
                        @endforeach
                    </div>
                    @endisset
                </div>
				@if (isset($camket)&&$camket)
				<div class="section-10">
					<div class="service_header d-lg-block d-none clearfix">
						<div class="container">
							<div class="row">
								<div class="col-lg-6 col-12">
									<div class="images_gioithieu">
                                        <img src="{{ asset($camket->image_path) }}" alt="{{ $camket->name }}">
                                    </div>
								</div>
                                <div class="col-lg-6 col-12 col-service">
                                    <div class="service-item">
                                        <div class="content-service">
                                            <span class="title-service">
                                                {{ $camket->slug }}
                                            </span>
											<span class="title-service1">
                                                {{ $camket->value }}
                                            </span>
                                            <span class="summary-service">
                                                {!! $camket->description !!}
                                            </span>
											<div class="xemthem_in">
												<a href="/danh-muc-tin-tuc/gioi-thieu">Xem thêm ></a>
											</div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
				@endif
				{{--
                <div class="cate_home">
                    <div class="container">
                        <div class="row">
                            <div class="list_cate">
								<div class="cate_info">
                                    <div class="name">Sản phẩm</div>
								</div>
                                <div class="slide_cate cate-dot-1">
                                    @if (isset($categoryProductHome)&&$categoryProductHome)
                                    @foreach ($categoryProductHome->childs()->where('active',1)->orderby('order')->latest()->limit(10)->get() as $item)
                                    <div class="item">
                                        <a href="{{ $item->slug_full }}">
                                            <div class="box">
                                                <div class="content">
                                                    <h4>{{ $item->name }}</h4>
													<div class="desc_home">
														{!! $item->description !!}
													</div>
                                                </div>
                                                <div class="image">
                                                    <img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}">
                                                </div>
                                            </div>
                                        </a>                                        
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="list_cate list_cate2">
                                @if (isset($categoryProductHome2)&&$categoryProductHome2)
                                @foreach ($categoryProductHome2 as $item)
                                <div class="item">
                                    <div class="box">
                                        <div class="image">
                                            <img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}">
                                        </div>
                                        <div class="content">
                                            <h4>{{ $item->name }}</h4>
                                            <ul class="category-list">
                                                @foreach($item->childs()->where('active',1)->orderby('order')->latest()->get() as $item2 )
                                                <li><a href="{{ $item2->slug_full }}">{{ $item2->name }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>--}}
				<div class="wrap-pro-tab-home">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="" role="tablist">
									<div class="group-title2">
										<h2 class="block-title">
											<span class="block-title-inner">Sản phẩm nổi bật</span>
										</h2>
									</div>
                                </ul>
                                <div class="tab-content" id="">
                                    <div class="tab-pane fade show active" id="pro-tab-1" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="list-product">
                                            <div class="row">
                                                @if (isset($productsBest)&&$productsBest)
                                                    @foreach ($productsBest as $product)
                                                    @php
                                                        $tran=$product->translationsLanguage()->first();
                                                        $link=$product->slug_full;
                                                    @endphp
                                                    <div class="col-12 col-product-item col-lg-3 col-md-4 col-sm-6 col-6">
                                                        <div class="product-item">
                                                            <div class="box">
                                                                <div class="image">
                                                                    <a href="{{ $link }}">
                                                                        <img src="{{ asset($product->avatar_path) }}" alt="{{ $tran->name }}">
                                                                        @if ($product->old_price)
                                                                            <span class="sale"> {{  ceil(100 - ($product->old_price/$product->price)*100)." %"}}</span>
                                                                        @endif
                                                                        @if($product->baohanh)
                                                                            <div class="km">
                                                                                {{ $product->baohanh }}
                                                                            </div>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="content">
                                                                    <h3><a href="{{ $link }}">{{ $tran->name }}</a></h3>
																	<div class="sao">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </div>
                                                                    <div class="box-price">
                                                                        <span class="new-price">Giá: {{ $product->price?number_format($product->price)." ".$unit:"Liên hệ" }}</span>
                                                                        @if ($product->old_price>0)
                                                                            <span class="old-price">{{ number_format($product->old_price) }} {{ $unit  }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="dathang">
                                                                    <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id]) }}">THÊM VÀO GIỎ HÀNG</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@php
                    $categoryProduct = new App\Models\CategoryProduct;
                    $product = new App\Models\Product;
                @endphp

                @if( isset($listCateHot) && $listCateHot->count()>0 )
                @foreach($listCateHot as $item)
                    @php
                        $listCateIn = $categoryProduct->getALlCategoryChildrenAndSelf($item->id);
                        $listPro = $product->whereIn('category_id', $listCateIn)->where('active',1)->orderByDesc('created_at')->limit(10)->get();
                        $cateTrans = $item->translationsLanguage()->first();
                    @endphp
				<div class="wrap-pro-tab-home">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="" role="tablist">
									<div class="group-title2">
										<h2 class="block-title">
											<span class="block-title-inner">{{ $cateTrans->name }}</span>
										</h2>
									</div>
                                </ul>
                                <div class="tab-content" id="">
                                    <div class="tab-pane fade show active" id="pro-tab-1" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="list-product">
                                            <div class="row">
												<div class="col-12">
													<div class="list-product-slide autoplay5-pro category-slide-1 category-dot-1">
													@foreach ($listPro as $product)
														@php
															$tran=$product->translationsLanguage()->first();
															$link=$product->slug_full;
														@endphp
														<div class="col-product-item col-lg-3 col-md-4 col-sm-6 col-6">
															<div class="product-item">
																<div class="box">
																	<div class="image">
																		<a href="{{ $link }}">
																			<img src="{{ asset($product->avatar_path) }}" alt="{{ $tran->name }}">
																			@if ($product->old_price)
                                                                            <span class="sale"> {{  ceil(100 - ($product->old_price/$product->price)*100)." %"}}</span>
                                                                            @endif
																			@if($product->baohanh)
																				<div class="km">{{ $product->baohanh }}</div>
																			@endif
																		</a>
																	</div>
																	<div class="content">
																		<h3><a href="{{ $link }}">{{ $tran->name }}</a></h3>
																		<div class="sao">
																			<i class="fa fa-star" aria-hidden="true"></i>
																			<i class="fa fa-star" aria-hidden="true"></i>
																			<i class="fa fa-star" aria-hidden="true"></i>
																			<i class="fa fa-star" aria-hidden="true"></i>
																			<i class="fa fa-star" aria-hidden="true"></i>
																		</div>
																		<div class="box-price">
                                                                            <span class="new-price">Giá: {{ $product->price?number_format($product->price)." ".$unit:"Liên hệ " }}</span>
                                                                            @if ($product->old_price>0)
                                                                                <span class="old-price">{{ number_format($product->old_price) }} {{ $unit  }}</span>
                                                                            @endif
                                                                        </div>
																	</div>
                                                                    <div class="dathang">
                                                                        <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id]) }}">THÊM VÀO GIỎ HÀNG</a>
                                                                    </div>
																</div>
															</div>
														</div>
														@endforeach
													</div>
												</div>
												{{--<div class="col-12">
													<div class="dathang">
                                                        <a href="{{ $item->slug_full }}"><i class="fas fa-angle-double-right"></i> Xem thêm</a>
                                                    </div>
												</div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@endforeach
                @endif

                <div class="wrap-post-home wow fadeInUp">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                @if (isset($titlePostNew)&&$titlePostNew)
                                <div class="group-title">
                                    <div class="title title-img">{{ $titlePostNew->name }}</div>
                                    <div class="img-title">
                                        <img src="{{ asset('frontend/images/b.png') }}" alt="icon">
                                    </div>
                                </div>
                                @endif
                                <div class="row list-post-home">
                                    @if(isset($postNew)&&$postNew)
                                    @foreach ($postNew as $post)
                                    @php
                                        $tran=$post->translationsLanguage()->first();
                                        $link=$post->slug_full;
                                    @endphp
									<div class="col-6 col-sm-6">
										<div class="item-post">
											<div class="box">
											 <div class="image">
												 <a href="{{ $link }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $tran->name }}"></a>
												 <div class="info">
													 <span>{{ date_format($post->created_at,'d/m/Y') }}</span>
												 </div>
											 </div>
											 <div class="content">
												 <div class="name"><a href="{{ $link }}">{{ $tran->name }}</a></div>
												 <div class="desc">
													 {!! $tran->description !!}
												 </div>
												 <div class="text-left">
													<a href="{{ $link }}" class="link-detail">Chi tiết <i class="fas fa-long-arrow-alt-right"></i></a>
												 </div>
											 </div>
											</div>
										 </div>
									</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="feedback">
					<div class="container">
						<div class="row">
							 @if (isset($camnhan)&&$camnhan)
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="group_title">
									<h2>{{ $camnhan->name }}</h2>
									<div class="sub_title">
										{{ $camnhan->value }}
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="row">
									<div class="list_feedback slider slide_feedback">
										@foreach ($camnhan->childs()->where('active',1)->orderby('order')->latest()->get() as $item)
											@php
											$tran=$item->translationsLanguage()->first();
										@endphp
										<div class="item">
											<div class="box">
												<div class="box_content">
													{!! $tran->value !!}
												</div>
												<div class="box_info">
													<div class="avatar">
														<div class="image">
															<img src="{{ asset($item->image_path) }}" alt="{{ $tran->name }}">
														</div>
														<i class="fa fa-quote-left" aria-hidden="true"></i>
													</div>
													<div class="box_author">
														<div class="author">{{ $tran->name }}</div>
														<span class="chucvu">{{ $tran->slug }}</span>
													</div>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
                <div class="parallax-section2"></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function(){
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
              $('.autoplay4-pro').slick('setPosition');
            });
        });

       setTimeout(() => $('#modal-first').modal('show'), 10000);
    </script>
    <script>
        $(function() {
            var now = new Date();
            var date = now.getDate();
            var month = (now.getMonth()+1);
            var year =  now.getFullYear();
            var timer;
                var then = year+'/'+month+'/'+date+' 23:59:59';
                var now = new Date();
                var compareDate = new Date(then) - now.getDate();
                timer = setInterval(function () {
                    timeBetweenDates(compareDate);
                }, 1000);
                function timeBetweenDates(toDate) {
                    var dateEntered = new Date(toDate);
                    var now = new Date();
                    var difference = dateEntered.getTime() - now.getTime();
                    if (difference <= 0) {
                        clearInterval(timer);
                    } else {
                        var seconds = Math.floor(difference / 1000);
                        var minutes = Math.floor(seconds / 60);
                        var hours = Math.floor(minutes / 60);
                        var days = Math.floor(hours / 24);
                        hours %= 24;
                        minutes %= 60;
                        seconds %= 60;
                        $("#days").text(days);
                        $("#hours").text(hours);
                        $("#minutes").text(minutes);
                        $("#seconds").text(seconds);
                    }
                }
            });
    </script>
@endsection
