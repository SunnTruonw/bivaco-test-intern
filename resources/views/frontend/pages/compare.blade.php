@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
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
                                <li class="breadcrumbs-item active"><a href="#" class="currentcat">Compare</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block-compare">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            @isset($data)
                                <div class="wrap-list-compare">
                                    <div class="list-compare">
                                        <div class="row compare-wrapper">
                                            <div class="col-md-12">
                                                @if ($data->count()>0)
                                                    <h2 class="title-compare">Tổng số {{ $data->count() }} sản phẩm <a data-url="{{ route('compare.clear') }}" class="clear-compare btn btn-danger">Xóa all</a></h2>
                                                @endif
                                            </div>
                                            @foreach($data as $product)
                                            <div class="col-md-6 col-compare">
                                                <div class="compare-card">
                                                    <div class="box">
                                                        <div class="image">
                                                            <a href="{{ $product->slug_full }}"><img src="{{ asset($product->avatar_path) }}" alt="{{ asset($product->name) }}"></a>
                                                            @if ($product->sale)
                                                            <span class="sale">-{{ $product->sale }}%</span>
                                                            @endif
                                                            <a data-url="{{ route('compare.remove',['id'=>$product->id]) }}" class="remove-compare"><i class="fas fa-times-circle"></i></a>
                                                        </div>
                                                        <div class="content">
                                                            <h3 class="name"><a href="{{ $product->slug_full }}">{{$product->name}}</a></h3>
                                                            <div class="view-more"><a href="{{ $product->slug_full }}" class="btn btn-primary">Xem ngay</a></div>
                                                            <div class="box-price">
                                                                <span class="new-price">{{ $product->price_after_sale?number_format($product->price_after_sale)." ".$unit:"Liên hệ" }} </span>
                                                                @if ($product->sale>0)
                                                                <span class="old-price">{{ $product->price }} {{ $unit  }}</span>
                                                                @endif
                                                            </div>
                                                            <hr>
                                                            <div class="info">
                                                                <h3>Thông tin chính</h3>
                                                                <ul>
                                                                    <li>
                                                                        <strong>Model:</strong> {{ $product->model?$product->model:"Chưa xác định" }}
                                                                    </li>
                                                                    <li>
                                                                        <strong>Tình trạng:</strong> {{ $product->tinhtrang?$product->tinhtrang:"Chưa xác định" }}
                                                                    </li>
                                                                    <li>
                                                                        <strong>Bảo hành:</strong> {{ $product->baohanh?$product->baohanh:"Chưa xác định" }}
                                                                    </li>
                                                                    <li>
                                                                        <strong>Xuất sứ:</strong> {{ $product->xuatsu?$product->xuatsu:"Chưa xác định" }}
                                                                    </li>

                                                                </ul>
                                                            </div>
                                                            <hr>
                                                            <div class="info">
                                                                <h3>Thuộc tính</h3>
                                                                <ul>
                                                                    @foreach ($attribute as $item)
                                                                    <li>
                                                                        <strong>{{ $item->name }}</strong>
                                                                        @php
                                                                            $tex="Chưa xác định";
                                                                        @endphp
                                                                        @foreach ($item->childs()->orderby('order')->get() as  $attr)
                                                                            @php
                                                                                if($product->attributes()->get()->pluck('id')->contains($attr->id)){
                                                                                    $tex=$attr->name ;
                                                                                }
                                                                            @endphp
                                                                        @endforeach
                                                                        {{ $tex }}
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endisset

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(function(){

    });
</script>
@endsection
