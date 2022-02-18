@extends('frontend.layouts.main')
@section('title', 'Trang chủ')
@section('css')
   <style>
       .btn-light{
        color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    background-color: #a3a3a3;
       }
   </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="text-left wrap-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumbs-item">
                                    <a href="{{ makeLink('home') }}">Trang chủ</a>
                                </li>
                                <li class="breadcrumbs-item active"><a href="#" class="currentcat">Đặt hàng online</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container container-cart">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            @include('frontend.components.cart-component',[
                            ])
                        </div>
                        <div class="bg-cart">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-buy">
                                        <form action="{{ route('cart.order.submit') }}" method="POST" enctype="multipart/form-data" id="buynow">
                                            @csrf
                                            <div class="row">
                                                @guest
                                                <div class="col-md-6 col-sm-12 col-xs-12 col-12">
                                                    <h2 class="title-cart">
                                                        Thông tin khách hàng
                                                    </h2>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Họ và tên <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control   @error('name')is-invalid   @enderror" id="" name="name" placeholder="Họ và tên">
                                                        </div>

                                                        <div class="col-sm-12">
                                                            @error('name')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Email <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <input type="email" class="form-control  @error('email')is-invalid   @enderror" id="" name="email" placeholder="Email">
                                                        </div>

                                                        <div class="col-sm-12">
                                                            @error('email')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Số điện thoại <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control   @error('phone')is-invalid   @enderror" id="" name="phone" placeholder="Số điện thoại">
                                                        </div>
                                                        <div class="col-sm-12">
                                                            @error('phone')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Tỉnh/TP <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <select name="city_id" id="city" class="form-control @error('city_id') is-invalid   @enderror"  data-url="{{ route('ajax.address.districts') }}" required="required">
                                                                <option value="">Chọn tỉnh/Thành phố</option>
                                                                {!! $cities !!}
                                                            </select>
                                                        </div>

                                                       <div class="col-sm-12">
                                                            @error('city_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                       </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Quận/huyện <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <select name="district_id" id="district" class="form-control    @error('district_id') is-invalid   @enderror"  data-url="{{ route('ajax.address.communes') }}"  required="required">
                                                                <option value="">Chọn quận/huyện</option>
                                                            </select>
                                                        </div>

                                                        @error('district_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Xã/phường <strong>*</strong></label>
                                                        <div class="col-sm-9">
                                                            <select name="commune_id" id="commune" class="form-control   @error('commune_id')is-invalid   @enderror"  required="required">
                                                                <option value="">Chọn xã/phường/thị trấn</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            @error('commune_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Địa chỉ giao hàng *</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="address_detail" class="form-control @error('address_detail')is-invalid @enderror" id="" placeholder="Địa chỉ giao hàng bắt buộc" required>
                                                        </div>
                                                        @error('address_detail')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-3">Yêu cầu khác </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="note" class="form-control   @error('note')is-invalid   @enderror" id="" placeholder="Yêu cầu khác (không bắt buộc)">
                                                        </div>

                                                       <div class="col-sm-12">
                                                            @error('note')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                       </div>
                                                    </div>
                                                    <div class="group-btn">
                                                        <button type="submit" class="btn btn-primary">Hoàn tất đơn hàng</button>
                                                    </div>
                                                </div>
                                                @else
                                                    <div class="col-md-6 col-sm-12 col-xs-12 col-12">
                                                        <h2 class="title-cart">
                                                            Thông tin khách hàng
                                                        </h2>
                                                        @if(Auth::guard('web')->check())
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Họ và tên <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control   @error('name')is-invalid @enderror" id="" name="name" value="{{ Auth::guard()->user()->name ??'' }}" placeholder="Họ và tên">
                                                            </div>

                                                            <div class="col-sm-12">
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Email <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <input type="email" class="form-control  @error('email')is-invalid @enderror" id="" name="email" value="{{ Auth::guard()->user()->email ??'' }}" placeholder="Email">
                                                            </div>

                                                            <div class="col-sm-12">
                                                                @error('email')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Số điện thoại <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control   @error('phone')is-invalid   @enderror" id="" name="phone" value="{{ Auth::guard()->user()->phone ?? '' }}" placeholder="Số điện thoại">
                                                            </div>
                                                            <div class="col-sm-12">
                                                                @error('phone')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Tỉnh/TP <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <select name="city_id" id="city" class="form-control @error('city_id') is-invalid   @enderror"  data-url="{{ route('ajax.address.districts') }}" required="required">
                                                                    <option value="">Chọn tỉnh/Thành phố</option>
                                                                    {!! $cities !!}
                                                                </select>
                                                            </div>

                                                           <div class="col-sm-12">
                                                                @error('city_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                           </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Quận/huyện <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <select name="district_id" id="district" class="form-control    @error('district_id') is-invalid   @enderror"  data-url="{{ route('ajax.address.communes') }}"  required="required">
                                                                    <option value="">Chọn quận/huyện</option>
                                                                </select>
                                                            </div>

                                                            @error('district_id')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Xã/phường <strong>*</strong></label>
                                                            <div class="col-sm-9">
                                                                <select name="commune_id" id="commune" class="form-control   @error('commune_id')is-invalid   @enderror"  required="required">
                                                                    <option value="">Chọn xã/phường/thị trấn</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                @error('commune_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Địa chỉ giao hàng *</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="address_detail" class="form-control    @error('address_detail')is-invalid   @enderror" value="{{ Auth::guard()->user()->address ?? '' }}" id="" placeholder="Địa chỉ giao hàng bắt buộc" required>
                                                            </div>
                                                            @error('address_detail')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="" class="col-sm-3">Yêu cầu khác </label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="note" class="form-control   @error('note')is-invalid   @enderror" id="" placeholder="Yêu cầu khác (không bắt buộc)">
                                                            </div>

                                                           <div class="col-sm-12">
                                                                @error('note')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                           </div>
                                                        </div>
                                                        @endif
                                                        <div class="group-btn">
                                                            <button type="submit" class="btn btn-primary">Hoàn tất đơn hàng</button>
                                                        </div>
                                                    </div>
                                                @endguest




                                                <div class="col-md-6 ol-sm-12 col-xs-12 col-12">
                                                    <div class="row">
                                                        <div class="col-md-12 col-sm-12 col-xs-12 col-12">

                                                            @if (isset($vanchuyen)&&$vanchuyen)
                                                            <h2 class="title-cart">
                                                               {{ $vanchuyen->name }}
                                                             </h2>
                                                              <div class="desc-collapse">
                                                                {!!  $vanchuyen->description !!}
                                                              </div>
                                                              @endif
                                                              <h2 class="title-cart">
                                                                {{ $thanhtoan->name }}
                                                               </h2>
                                                               @if (isset($thanhtoan)&&$thanhtoan)
                                                               <input type="hidden"  name="httt" id="hinhthuc" required value="{{ optional($thanhtoan->childs()->orderby('order')->orderByDesc('created_at')->first())->id }}">
                                                               @endif
                                                              <div id="list-thanhtoan">
                                                                  @if (isset($thanhtoan)&&$thanhtoan)
                                                                      @foreach ($thanhtoan->childs()->orderby('order')->orderByDesc('created_at')->get() as $item)

                                                                      <div class="card colsap @if ($loop->first) active @endif" data-value='{{ $item->id }}'>
                                                                        <div class="card-header btn-colsap @if ($loop->first) active @endif">
                                                                            {{ $item->name }}
                                                                        </div>
                                                                        <div class="card-body content-colsap">
                                                                            {!!  $item->description !!}
                                                                        </div>
                                                                    </div>
                                                                      @endforeach
                                                                  @endif
                                                             </div>
                                                        </div>
                                                        {{-- <div class="col-md-6 col-sm-12 col-xs-12 col-12">

                                                            <select name="cn" id="chinhanh" class="form-control" required>
                                                                <option value="0">Chọn chi nhánh *</option>
                                                                @if (isset($chinhanh)&&$chinhanh)
                                                                    @foreach ($chinhanh->childs()->orderby('order')->orderByDesc('created_at')->get() as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="list-chinhanh">
                                                                @if (isset($chinhanh)&&$chinhanh)
                                                                    @foreach ($chinhanh->childs()->orderby('order')->orderByDesc('created_at')->get() as $item)
                                                                    <div class="item" id="cn_{{ $item->id }}">
                                                                        <div class="name">{{ $item->name }}</div>
                                                                        <div class="diachi">
                                                                           {!! $item->description !!}
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="group-btn">
                                                                <a href="{{ route('home.index') }}" class="btn btn-light">Tiếp tục mua hàng</a>
                                                                <button type="submit" class="btn btn-primary">Gửi đơn hàng</button>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
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
@endsection

@section('js')
<script src="{{ asset('frontend/js/load-address.js') }}"></script>
<script>
    $(document).on('click','.btn-colsap',function(){
        $('#list-thanhtoan').find('.active').removeClass('active');
        $(this).addClass('active');
        $(this).parent('.colsap').addClass('active');
        let value= $(this).parent('.colsap.active').data('value');
        $('#hinhthuc').val(value);
        console.log(value);
        $('#list-thanhtoan').find('.colsap:not(".active") .content-colsap').slideUp();
            $(this).parent('.colsap.active').find('.content-colsap').slideDown();
    });
    $("#chinhanh").change(function () {
        var id = $(this).val();
        if (id != "0") {
            $(".list-chinhanh #cn_" + id).addClass("active").siblings().removeClass("active");
        }
        else
            $(".list-chinhanh .item").removeClass("active");
    });
</script>
@endsection
