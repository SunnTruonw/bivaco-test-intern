@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
<style>
</style>
@section('content')

    <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
    @if(Session::has('msg'))
    <script type="text/javascript">
        alert("{{ Session::get('msg') }}");
    </script>
    @endif
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            <div class="blog-product-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <div class="row" >
                                <div class="col-sm-12" id="dataProductSearch">
                                    <div class="box-product-main">
                                        <div class="row" >
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="box-image-product">
                                                    <div class="image-main block">
                                                        <a class="hrefImg" href="{{ asset($data->avatar_path) }}" data-lightbox="image">
                                                            <i class="fas fa-expand-alt"></i>
                                                            <img id="expandedImg" src="{{  asset($data->avatar_path) }}">
                                                        </a>
                                                    </div>
                                                    {{-- <div class="share">
                                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                                        <div class="addthis_inline_share_toolbox"></div>
                                                    </div> --}}
                                                    @if ($data->images()->count())
                                                    <div class="list-small-image">
                                                        <div class="pt-box autoplay5-product-detail">
                                                            <div class="small-image column">
                                                                <img src="{{ asset($data->avatar_path) }}" alt="{{ asset($data->name) }}">
                                                            </div>
                                                            @foreach ($data->images as $image)
                                                            <div class="small-image column">
                                                                <img src="{{ asset($image->image_path) }}" alt="{{ asset($image->name) }}">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 product-detail-infor">
												<div class="title_sp_detail">
                                                    <h1>{{ $data->name }}</h1>
												</div>
                                                <div class="reviewstyle">
                                                    <a href="#danhgia">Hãy là người đầu tiên nhận xét sản phẩm này</a>
                                                </div>
                                                <div class="sku">
                                                    Mã Sản Phẩm: {{ $data->masp }}
                                                </div>
                                                <div class="box-infor">
                                                    <div class="wrap-price">
                                                        <div class="list-attr">
                                                            <div class="attr-item price_detail">
                                                                @if ($data->old_price)
                                                                    <div class="price">
                                                                        <span>Giá niêm yết:</span> <span id="old_priceChange">{{ number_format($data->old_price) }} ₫</span>
                                                                    </div>
                                                                    <div class="price">
                                                                        <span>Giá khuyến mãi:</span> <span id="priceChange">{{ number_format($data->price) }} ₫</span>
                                                                    </div>
                                                                    <div class="tinh_trang">
                                                                        <span>Tình trạng:</span>
                                                                        <span>{{ $data->tinhtrang }}</span>
                                                                    </div>
                                                                @elseif($data->price)
                                                                    <div class="price">
                                                                        <span>Giá bán lẻ:</span> <span id="priceChange">{{ number_format($data->price) }} ₫</span>
                                                                    </div>
                                                                    <div class="tinh_trang">
                                                                        <span>Tình trạng:</span>
                                                                        <span>{{ $data->tinhtrang }}</span>
                                                                    </div>
                                                                @else
                                                                <div class="price">
                                                                    Giá: Liên hệ (0945.268.833 để biết thêm thông tin)
                                                                </div>
                                                                @endif
                                                            </div>
															<div class="info-desc">
																<div class="col_2_desc">
																	<div class="desc">
																		{!! $data->description !!}
																	</div>
																</div>
																<div class="col_2_desc">
																	<div class="desc">
																		{!! $data->content4 !!}
																	</div>
																</div>
															</div>
                                                            <div class="attr-item shipping_product">
                                                                <div class="label_shipping">{{ $vanchuyen->slug }}</div>
                                                                <div class="content_shipping">
                                                                    {{ $vanchuyen->value }}
                                                                </div>
                                                            </div>
															

                                                            <div class="attr-item">
                                                                <div class="form-group">
                                                                    <label for="">Chọn loại</label>
                                                                    <div class="select_size">
                                                                        <div class="group-control">
                                                                            <input id="{{ $data->price??0 }}-0" class="optionChange" checked="checked" type="radio" name="size" value="{{ $data->price??0 }}-0" data-old_price="{{ $data->old_price??0 }}-0">
                                                                            <label for="{{ $data->price??0 }}-0">
                                                                                {{ $data->size??'Mặc định'.$data->size }}
                                                                            </label>
                                                                        </div>
                                                                        @foreach ($data->options as $item)
                                                                        <div class="group-control">
                                                                            <input id="{{ $item->price??0 }}-{{ $item->id }}" class="optionChange" type="radio" name="size" value="{{ $item->price??0 }}-{{ $item->id }}" data-old_price="{{ $item->old_price??0 }}-{{ $item->id }}">
                                                                            <label for="{{ $item->price??0 }}-{{ $item->id }}">
                                                                                {{ $item->size }}
                                                                            </label>
                                                                        </div>
                                                                        @endforeach
                                                                    </div>
                                                                    {{--
                                                                    <label for="">Chọn loại</label>
                                                                    <select name="" id="optionChange" class="form-control optionChange" required="required" >
                                                                        <option value="{{ $data->price??0 }}-0" data-old_price="{{ $data->old_price??0 }}-0">{{ $data->size??'Mặc định '.$data->size }}</option>
                                                                        @foreach ($data->options as $item)
                                                                             <option value="{{ $item->price??0 }}-{{ $item->id }}"  data-old_price="{{ $item->old_price??0 }}-{{ $item->id }}">{{ $item->size }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    --}}
                                                                </div>
                                                            </div>
                                                            <div class="attr-item1">
                                                                <div class="form-group">
                                                                    <label for="">Số lượng</label>
                                                                    <div class="wrap-add-cart" id="product_add_to_cart">
                                                                        <div class="box-add-cart">

                                                                            <div class="pro_mun">
                                                                                <a class="cart_qty_reduce cart_reduce">
                                                                                    <span class="iconfont icon fas fa-minus" aria-hidden="true"></span>
                                                                                </a>
                                                                                <input type="text" value="1" class="" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="5" min="1" id="cart_quantity" placeholder="">

                                                                                <a class="cart_qty_add">
                                                                                    <span class="iconfont icon fas fa-plus" aria-hidden="true"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="box-buy">
                                                                <a class="add-to-cart" id="addCart" data-url="{{ route('cart.add',['id' => $data->id,]) }}" data-start="{{ route('cart.add',['id' => $data->id,]) }}">Thêm vào giỏ hàng</a>
                                                            </div>

                                                            {{-- <div class="attr-item">
                                                                <div class="form-group">
                                                                    <label for="">Size cổ tay</label>
                                                                    <input type="number" min="0" max="21" step="0.5" class="form-control" value="12">
                                                                </div>
                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                    <div class="wrap-price">
                                                        {{--<div class="list-attr1">
                                                            <div class="attr-item" style="display: inline-block; margin-left: 20px;">
                                                                <div class="form-group">
                                                                    <label for="">Số lượng</label>
                                                                    <div class="wrap-add-cart" id="product_add_to_cart">
                                                                        <div class="box-add-cart">

                                                                            <div class="pro_mun">
                                                                                <a class="cart_qty_reduce cart_reduce">
                                                                                    <span class="iconfont icon fas fa-minus" aria-hidden="true"></span>
                                                                                </a>
                                                                                <input type="text" value="1" class="" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="5" min="1" id="cart_quantity" placeholder="">

                                                                                <a class="cart_qty_add">
                                                                                    <span class="iconfont icon fas fa-plus" aria-hidden="true"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="attr-item">
                                                                <div class="form-group">
                                                                    <label for="">Chọn Loại</label>
                                                                    <input type="number" min="0" max="21" step="0.5" class="form-control" value="12">
                                                                </div>
                                                            </div>
                                                        </div>--}}
                                                    </div>
													
                                                    {{--
                                                    <div class="list-attr">
                                                        <div class="attr-item">
                                                            <h3>Chọn loại giá để xem giá sản phẩm</h3>
															<div class="price">
                                                                    @if ($data->price_after_sale)
                                                                    <span>Giá:</span> <span id="priceChange">{{ number_format($data->price_after_sale) }} <span class="donvi">VNĐ</span></span>
                                                                    @else
                                                                    Liên hệ
                                                                    @endif
                                                                </div>
                                                            <div class="price">
                                                                @if ($data->price)
                                                                    @if ($data->price_after_sale)
                                                                        <span id="priceChange">Giá: {{ number_format($data->price_after_sale) }} <span class="donvi">đ</span></span>
                                                                    @endif

                                                                    @if ($data->sale>0)
                                                                        <span class="title_giacu">Giá cũ: </span>
                                                                        <span class="old-price">{{ number_format($data->price) }} {{ $unit  }}</span>

                                                                        <div class="tiet_kiem">
                                                                            <div class="g2">(Tiết kiệm: <b>{{ number_format(
                                                                                ($data->price - $data->price_after_sale)) }}</b>)</div>
                                                                            <div class="tk">
                                                                                <b>-{{ $data->sale }}%</b>
                                                                            </div>
                                                                        </div>
                                                                    @endif                                   
                                                                @else
                                                                Giá: Liên hệ
                                                                @endif                                                                
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    --}}
                                                    {{--
                                                    <div class="masp">
														<i class="far fa-check-square"></i> Mã sản phẩm: <strong>{{ $data->masp }}</strong>
													</div>
                                                    --}}
                                                    @if ( $data->model )
                                                    <div class="status"><i class="far fa-check-square"></i> Thương hiệu:
                                                       <span> <strong>{{ $data->model }}</strong> </span>
                                                    </div>
                                                    @endif
                                                    {{--
                                                    @if ( $data->tinhtrang )
                                                    <div class="status"><i class="far fa-check-square"></i> Trạng thái:
                                                        <span> <strong>{{ $data->tinhtrang }}</strong> </span>
                                                    </div>
                                                    @endif
                                                    --}}
                                                    @foreach ($data->attributes()->latest()->get() as $item)
                                                    <div class="status">
                                                        <strong><i class="far fa-check-square"></i> {{ optional($item->parent)->name }}: </strong>
                                                       <span> {{ $item->name }} </span>
                                                    </div>
                                                    @endforeach
                                                    @if ( $data->xuatsu )
                                                    <div class="status">
                                                        <strong><i class="far fa-check-square"></i> Phụ kiện kèm theo: </strong>
                                                        <span> {{ $data->xuatsu }} </span>
                                                    </div>
                                                    @endif
                                                    @if($data->content3 != null)
                                                    <div class="quatang">
                                                        <div class="title">
                                                            Quà tặng khi mua sản phẩm
                                                        </div>
                                                        <div class="box_quatang">
                                                            {!! $data->content3 !!}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    {{--
													@if (isset($diachi) && $diachi)
                                                    <div class="quatang">
                                                        <div class="title">
                                                            THÔNG TIN LIÊN HỆ
                                                        </div>
                                                        <div class="box_quatang1">
                                                            <div class="list-address-footer">
															<ul>
																@foreach ($diachi->childs()->where('active',1)->orderby('order')->latest()->get() as $item)
																	<li>
																		<strong>{{ $item->name }}</strong>
																		<span>: {{ $item->value }}</span>
																	</li>
																@endforeach
															</ul>
														</div>
                                                        </div>
                                                    </div>
													@endif
                                                    <hr>
                                                    --}}
													
                                                    <div class="modal fade modal-First" id="modal-first" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content"  image="">
                                                                <div class="modal-body">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                    <div class="image-modal">
                                                                        <div class="info_product_modal">
                                                                            <div class="title">
                                                                                {{ $data->name }}
                                                                            </div>
                                                                            <div class="image">
                                                                                <img src="{{ asset($data->avatar_path) }}" alt="{{ $data->name }}">
                                                                            </div>
                                                                            <div class="list-attr">
                                                                                <div class="attr-item">
                                                                                    <div class="price">
                                                                                        @if ($data->price)
                                                                                            @if ($data->price_after_sale)
                                                                                                <span id="priceChange">{{ number_format($data->price_after_sale) }} <span class="donvi">đ</span></span>
                                                                                            @endif

                                                                                            @if ($data->sale>0)
                                                                                                <span class="title_giacu">Giá cũ: </span>
                                                                                                <span class="old-price">{{ number_format($data->price) }} {{ $unit  }}</span>

                                                                                                <div class="tiet_kiem">
                                                                                                    <div class="g2">(Tiết kiệm: <b>{{ number_format(
                                                                                                        ($data->price - $data->price_after_sale)) }}</b>)</div>
                                                                                                    <div class="tk">
                                                                                                        <b>-{{ $data->sale }}%</b>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @else
                                                                                        Liên hệ
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="newsletter-content">
                                                                            <h2>ĐẶT LỊCH ĐẾN SHOWROOM</h2>
                                                                            <div class="dec">(Để chúng tôi phục vụ chu đáo hơn)</div>
                                                                            <form action="{{ route('contact.storeAjax2') }}"  data-url="{{ route('contact.storeAjax2') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST" class="input-wrapper input-wrapper-inline input-wrapper-round">
                                                                                @csrf
                                                                                <input type="text" class="form-control" name="content" placeholder="Sản phẩm muốn xem *" value="{{ $data->name }}" required>
                                                                                <input type="text" class="form-control" name="name" placeholder="Họ tên *">
                                                                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại *" required>
                                                                                <label>Ngày đến</label>
                                                                                <input type="date" class="form-control ngay_den" name="date_start" placeholder="Ngày đến xem" required>
                                                                                
                                                                                <button>Đăng ký ngay</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade modal-First" id="sign_now" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content"  image="">
                                                                <div class="modal-body">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                    <div class="image-modal">
                                                                        <div class="info_product_modal">
                                                                            <div class="title">
                                                                                {{ $data->name }}
                                                                            </div>
                                                                            <div class="image">
                                                                                <img src="{{ asset($data->avatar_path) }}" alt="{{ $data->name }}">
                                                                            </div>
                                                                            <div class="list-attr">
                                                                                <div class="attr-item">
                                                                                    <div class="price">
                                                                                        @if ($data->price)
                                                                                            @if ($data->price_after_sale)
                                                                                                <span id="priceChange">{{ number_format($data->price_after_sale) }} <span class="donvi">đ</span></span>
                                                                                            @endif

                                                                                            @if ($data->sale>0)
                                                                                                <span class="title_giacu">Giá cũ: </span>
                                                                                                <span class="old-price">{{ number_format($data->price) }} {{ $unit  }}</span>

                                                                                                <div class="tiet_kiem">
                                                                                                    <div class="g2">(Tiết kiệm: <b>{{ number_format(
                                                                                                        ($data->price - $data->price_after_sale)) }}</b>)</div>
                                                                                                    <div class="tk">
                                                                                                        <b>-{{ $data->sale }}%</b>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @endif
                                                                                        @else
                                                                                        Liên hệ
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="newsletter-content">
                                                                            <h2>ĐĂNG KÝ NGAY</h2>
                                                                            <div class="dec">(Điền đầy thủ thông tin vào ô nhập thông tin)</div>
                                                                            <form action="{{ route('contact.storeAjax1') }}"  data-url="{{ route('contact.storeAjax1') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST" class="input-wrapper input-wrapper-inline input-wrapper-round">
                                                                                @csrf
                                                                                <input type="text" class="form-control" name="content" placeholder="Sản phẩm muốn xem *" value="{{ $data->name }}" required>
                                                                                <input type="text" class="form-control" name="name" placeholder="Họ tên *">
                                                                                <input type="text" class="form-control" name="phone" placeholder="Số điện thoại *" required>
                                                                                <input type="text" class="form-control" name="address_detail" placeholder="Địa chỉ" required>
                                                                                
                                                                                <textarea class="form-control" name="content2" placeholder="Nội dung"></textarea>
                                                                                <button>Đăng ký ngay</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-product">
                                        <div role="tabpanel">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                <li class="nav-item">
                                                  <a class="nav-link active"  data-toggle="tab" href="#mota" role="tab" aria-controls="profile" aria-selected="false">Thông Số Kỹ Thuật</a>
                                                </li>
                                                {{--
                                                <li class="nav-item">
                                                    <a class="nav-link"  data-toggle="tab" href="#chinhsach" role="tab" aria-controls="home" aria-selected="true">Bảo Hành Đổi Trả</a>
                                                </li>
												<li class="nav-item">
                                                    <a class="nav-link"  data-toggle="tab" href="#kichthuoc" role="tab" aria-controls="tabkichthuoc" aria-selected="true">Hướng Dẫn Đo Size</a>
                                                </li>
                                                --}}
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade  show active" id="mota" role="tabpanel" aria-labelledby="profile-tab">
                                                    {!! $data->content !!}
                                                </div>
                                                <div class="tab-pane fade" id="chinhsach" role="tabpanel" aria-labelledby="home-tab">
                                                    {!! $data->content2 !!}
                                                </div>
                                                {{--
												<div class="tab-pane fade" id="kichthuoc" role="tabpanel" aria-labelledby="tabkichthuoc-tab">
                                                    {!! optional($huongDan)->description !!}
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                        {{-- <div class="tab-link">
                                            <ul>
                                                <li><a href="#chinhsach" class="active">Chính sách</a></li>
                                                <li><a href="#mota" class="">Mô tả sản phẩm</a></li>
                                                <li><a href="#thongso">Thông số kỹ thuật</a></li>
                                                <li><a href="#chinhsachvanchuyen">Chính sách vận chuyển</a></li>
                                                <li><a href="#chinhsachbaohanh">Chính sách bảo hành</a></li>
                                            </ul>
                                        </div>

                                        <div class="tab-pro-content" id="wrapSizeChange">
                                            <div class="tab-item" id="chinhsach">
                                                Đang cập nhập
                                            </div>
                                            <div class="tab-item" id="mota">
                                                {!! $data->content !!}
                                            </div>
                                            <div class="tab-item" id="thongso">
                                                {!! $data->content2 !!}
                                            </div>
                                            <div class="tab-item" id="chinhsachvanchuyen">
                                                {!! $data->content3 !!}
                                            </div>
                                            <div class="tab-item" id="chinhsachbaohanh">
                                                {!! $data->content4 !!}
                                            </div>
                                        </div> --}}

                                        @if($data->stars()->count()>0)
										<div class="list-star js-list-star">
                                            <div class="js-load" style="display: none;">
                                                <div class="spinner-border text-info"></div>
                                            </div>
                                            
                                            @foreach($data->stars()->where('active',1)->orderBy('created_at')->get() as $item)
                                            <div class="item-star">
                                                <div class="box">
                                                    <div class="auth-star">
                                                        <div class="icon">{{ $item->name_tat($item->name) }}</div>
                                                        <div class="text-star">
                                                            <div class="name">{{ $item->name }}</div>
                                                            <div class="date-create">{{ Carbon::parse($item->created_at)->format('d-m-Y') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="content-star">
                                                        <h3>{{ $item->title }}</h3>
                                                        <div class="desc">
                                                            {{ $item->content }}
                                                        </div>
                                                    </div>
                                                    @if($item->star)
                                                    <div class="point-star">
                                                        {{ $item->star }}
                                                        <span class="point">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            <div class="pagination-star js-pagination-ajax mt-3">
                                            </div>
                                        </div>
                                        @endif
										<div id="danhgia" class="danhgia_sao">
											<div class="contact-form">
												<div class="form">
													<form action="{{ route('product.rating',['id' => $data->id]) }}" method="POST" method="POST">
														@csrf
														<div class="form_danhgia">
															<label>Đánh giá <span>*</span></label>
                                                            <div id="rating">
                                                                <input type="radio" id="star5" name="rating" value="5" />
                                                                <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                                <input type="radio" id="star4half" name="rating" value="4.5" />
                                                                <label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                                <input type="radio" id="star4" name="rating" value="4" />
                                                                <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                                <input type="radio" id="star3half" name="rating" value="3.5" />
                                                                <label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                                <input type="radio" id="star3" name="rating" value="3" />
                                                                <label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                                <input type="radio" id="star2half" name="rating" value="2.5" />
                                                                <label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                                <input type="radio" id="star2" name="rating" value="2" />
                                                                <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                                <input type="radio" id="star1half" name="rating" value="1.5" />
                                                                <label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                                <input type="radio" id="star1" name="rating" value="1" />
                                                                <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                                <input type="radio" id="starhalf" name="rating" value="0.5" />
                                                                <label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                            </div>
														</div>
														<div class="form_danhgia">
															<label>Khách hàng <span>*</span></label>
															<input type="text" placeholder="Khách hàng" required="required" name="name">
														</div>
														<div class="form_danhgia">
															<label>Email</label>
															<input type="email" placeholder="Email" required="required" name="email">
														</div>
														<div class="form_danhgia">
															<label>Điện thoại <span>*</span></label>
															<input type="number" placeholder="Điện thoại" required="required" name="phone">
														</div>
														<div class="form_danhgia">
															<label>Tiêu đề <span>*</span></label>
															<input type="text" placeholder="Tiêu đề" required="required" name="title">
														</div>
														<div class="form_danhgia">
															<label>Nội dung <span>*</span></label>
															<textarea name="content" placeholder="Nội dung" id="noidung" cols="30" rows="5"></textarea>
														</div>
														<div class="form_danhgia">
															<label></label>
															<div class="sao_danhgia">
																<button type="submit" name="submit">Đánh giá</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										
                                    </div>
									<div class="product-relate">
                                        <div class="title_sp_lienquan">
                                            <h2>Sản phẩm liên quan</h2>
                                        </div>
                                        <div class="row">
                                            @isset($dataRelate)
                                                @if ($dataRelate->count())
                                                    <div class="list-product-card autoplay_height category-slide-1" style="width:100%;">
                                                        @foreach ($dataRelate as $product)
                                                            @php
                                                                $tran=$product->translationsLanguage()->first();
                                                                $link=$product->slug_full;
                                                            @endphp
                                                            <div class="col-product-item">
                                                                <div class="product-item">
                                                                    <div class="box">
                                                                        <div class="image">
                                                                            <a href="{{ $link }}">
                                                                                <img src="{{ asset($product->avatar_path) }}" alt="{{ $tran->name }}">
                                                                                @if ($product->old_price)
                                                                                <span class="sale"> {{  ceil(100 - ($product->old_price/$product->price)*100)." %"}}</span>
                                                                                @endif
                                                                            </a>
                                                                        </div>
                                                                        <div class="content">
                                                                            <h3>
                                                                                <a href="{{ $link }}">{{ $tran->name }}</a>
                                                                            </h3>
                                                                            <div class="box-price">
                                                                                <span class="new-price">Giá: {{ $product->price?number_format($product->price)." ".$unit:"Liên hệ" }}</span>
                                                                                @if ($product->old_price>0)
                                                                                    <span class="old-price">{{ number_format($product->old_price) }} {{ $unit  }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="dathang">
                                                                                <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id]) }}">Đặt hàng ngay</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                            @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                    "categoryPost"=>$sidebar['categoryPost'],
                                    'fill'=>true,
                                    'product'=>true,
                                    'post'=>false,
                                    'urlActive'=>makeLink('category_products',$data->category->id,$data->category->slug) ,
                                ])
                            @endisset

                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="get" name="formfill" id="formfill" class="d-none">
        @csrf
    </form>
    <script type="text/javascript">
        function calcRate(r) {
         const f = ~~r,//Tương tự Math.floor(r)
         id = 'star' + f + (r % f ? 'half' : '')
         id && (document.getElementById(id).checked = !0)
        }

        $(document).ready(function() {
            $('.autoplay1').slick({
                dots: false,
                arrows: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                speed: 300,
                autoplaySpeed: 3000,
            });
            $('.column').click(function() {
                var src = $(this).find('img').attr('src');
                $(".hrefImg").attr("href", src);
                $("#expandedImg").attr("src", src);
            });
            $('.slide_small').slick({
                dots: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 2000,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                }]
            });


            $(document).on('click','.tab-link ul li a',function(){
                    $('.tab-link ul li a').removeClass('active');
                    $(this).addClass('active');
            });
            $('.autoplay5-product-detail').slick({
                dots: false,
                vertical:true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 551,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            vertical: false,
                        }
                    }
                ]
            });

            $(document).on('change','.field-form',function(){
          // $( "#formfill" ).submit();

                let contentWrap = $('#dataProductSearch');

                let urlRequest = '{{ makeLinkById('category_products',$data->category->id) }}';
                let data=$("#formfill").serialize();
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    data:data,
                    success: function(data) {
                        if (data.code == 200) {
                            let html = data.html;
                            contentWrap.html(html);
                        }
                    }
                });
            });
            // load ajax phaan trang
            $(document).on('click','.pagination a',function(){
                event.preventDefault();
                let contentWrap = $('#dataProductSearch');
                let href=$(this).attr('href');
                //alert(href);
                $.ajax({
                    type: "Get",
                    url: href,
                // data: "data",
                    dataType: "JSON",
                    success: function (response) {
                        let html = response.html;

                        contentWrap.html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var boxnumber = $('.box-add-cart input').val();
            parseInt(boxnumber);
            $('.cart_qty_add').click(function() {
                if ($(this).parent().parent().find('input').val() < 50) {
                    var a = $(this).parent().parent().find('input').val(+$(this).parent().parent().find(
                        'input').val() + 1);
                        // let url = $('#addCart').data('start');
                        // url += "?quantity=" + $('#cart_quantity').val();
                        // $('#addCart').attr('data-url',url);
                        $(".optionChange").trigger('change');
                }
            });
            $('.cart_qty_reduce').click(function() {
                if ($(this).parent().parent().find('input').val() > 1) {
                    if ($(this).parent().parent().find('input').val() > 1) $(this).parent().parent().find(
                        'input').val(+$(this).parent().parent().find('input').val() - 1);
                        //  let url = $('#addCart').data('start');
                        // url += "?quantity=" + $('#cart_quantity').val();

                        // $('#addCart').attr('data-url',url);
                        $(".optionChange").trigger('change');
                }
            });

            $(document).on('change','#cart_quantity',function(){
                if ($(this).parent().parent().find('input').val() > 1) {
                    var a = $(this).val();
                        $(".optionChange").trigger('change');
                }
            });

            $(document).on('change','.optionChange',function(){
                let val= ($(this).val());
                let arrPriceAndId = val.split("-").map(function(value,index){
                    return parseInt(value);
                });

                //Giá cũ
                let old_price = $(this).data('old_price')
                let arrPriceAndId2 = old_price.split("-").map(function(value2,index){
                    return parseInt(value2);
                });
 
                var nf = Intl.NumberFormat();

                let text= 'Liên hệ';
                let text2= '';
                let url = $('#addCart').data('start');
                url += "?quantity=" + $('#cart_quantity').val();
                if(arrPriceAndId[1]){
                    url += "&option=" + arrPriceAndId[1];
                }
                if(arrPriceAndId[0]>0){
                    let price= nf.format(arrPriceAndId[0]);
                    text=price+' ₫';
                }
                if(arrPriceAndId2[0]>0){
                    let price2= nf.format(arrPriceAndId2[0]);
                    text2=price2+' ₫';
                }
                $('#addCart').attr('data-url',url);
                $('#priceChange').html(text);
                $('#old_priceChange').html(text2);
            });
        });
    </script>
@endsection
@section('js')
@endsection
