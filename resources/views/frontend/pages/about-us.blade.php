@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
            ])

            <div class="blog-about-us">

                <div class="wrap-about-us">
                    <div class="container">
                        <div class="row d-flex before-after-unset">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="about-text">
                                    <div class="group-title">
                                        <div class="title title-red text-left">
                                            {{$about_us->name}}
                                        </div>
                                    </div>
                                    <div class="desc-about">
                                       {!! $about_us->content !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="image-about-us">
                                    <img src="{{ $about_us->avatar_path }}" alt="{{$about_us->name}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap-tam-nhin" style="background-image: url({{$bgtamnhin->avatar_path}});">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-tam-nhin">

                                    @isset($tamnhin)
                                    @foreach ($tamnhin as $item)
                                    <div class="item-tam-nhin wow {{ $item->description }}" data-wow-duration="0.5s" data-wow-delay="0.3s">
                                        <div class="title-tam-nhin">
                                            <img src="{{ $item->avatar_path }}" alt="{{ $item->name }}">{{ $item->name }}
                                        </div>
                                        <div class="desc">
                                            {!! $item->content !!}
                                        </div>
                                        <div class="line-tam-nhin"></div>
                                    </div>
                                    @endforeach
                                    @endisset

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap-ls">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="group-title">
                                    <div class="title title-red text-center">
                                        {{$history->name}}
                                    </div>
                                </div>
                                <div class="slider slider-single slide-ls">
                                    @isset($historyList)
                                    @foreach ($historyList as $item)
                                    <div class="item-ls">
                                        <div class="row">

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="image-ls">
                                                    <img src="{{ $item->avatar_path }}" alt="{{ $item->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="ls-text">
                                                    <div class="title-ls">{{ $item->name }}</div>
                                                    <div class="desc-ls">
                                                        {!! $item->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endisset
                                </div>

                                <div class="bg-line"></div>

                                <div class="slider slider-nav slide-ls-sm cate-arrows-1 cate-arrows-1-sm">
                                    @isset($historyList)
                                    @foreach ($historyList as $item)
                                    <div class="item-ls-sm">
                                        <div class="box">
                                            {{ $item->description }}
                                        </div>
                                    </div>
                                    @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="wrap-partner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="group-title">
                                    <h3 class="title title-while text-left">{{ __('about-us.doi_tac_chien_luoc') }}</h3>
                                </div>
                                <div class="list-item autoplay3-doitac cate-dot-1  cate-dot-while-1 cate-arrows-1">

                                    @isset($partner)
                                    @foreach ($partner as $item)
                                    <div class="item">
                                        <div class="box">
                                            <a href="{{ $item->slug }}">
                                                <img src="{{ $item->image_path }}" alt="{{ $item->name }}">
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.slider-single').slick({
                slidesToShow: 1,
                autoplay: true,
                slidesToScroll: 1,
                arrows: false,
                dot: false,

                fade: false, //lam phai màu mờ dần
                adaptiveHeight: true,
                autoplaySpeed: 3000, // default 3000 tu dong chay sau 2000milisecon
                infinite: true,
                useTransform: true,
                speed: 400,
                cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',

            });

            $('.slider-nav')
                .on('init', function(event, slick) {
                    $('.slider-nav .slick-slide.slick-current').addClass('is-active');
                })
                .slick({
                    slidesToShow: 9,
                    slidesToScroll: 1,
                    dots: false,
                    focusOnSelect: false,
                    infinite: true,
                    arrows: true,
                    center: true,
                    autoplay: false,
                    responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 6,
                        }
                    }, {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 4,
                        }
                    }, {
                        breakpoint: 420,
                        settings: {
                            slidesToShow: 3,
                        }
                    }],
                });
            $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
                $('.slider-nav').slick('slickGoTo', currentSlide);
                var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
                $('.slider-nav .slick-slide.is-active').removeClass('is-active');
                $(currrentNavSlideElem).addClass('is-active');
            });
            $('.slider-nav').on('click', '.slick-slide', function(event) {
                event.preventDefault();
                var goToSingleSlide = $(this).data('slick-index');
                $('.slider-single').slick('slickGoTo', goToSingleSlide);
            });
        });
    </script>
@endsection
@section('js')

@endsection
