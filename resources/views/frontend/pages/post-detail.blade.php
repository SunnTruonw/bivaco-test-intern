@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            <div class="blog-news-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12  block-content-right">
                            <div class="news-detail">
                                <div class="title-detail">
                                    {{ $data->name }}
                                </div>
                                <div class="author">
                                    <div class="date">
                                        <div class="year"><i class="fas fa-calendar-week"></i> {{ date_format($data->created_at,"d/m/Y") }}</div>
                                    </div>
                                    <div class="changeFontSize">
                                        <a class="mormalSize">Cỡ chữ</a>
                                        <a class="prevSize" ><i class="fas fa-minus"></i></a>
                                        <a class="nextSize" ><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                {{-- <div class="image">
                                    <img src=" {{ $data->avatar_path }}" alt="{{ $data->name }}">
                                </div> --}}
                                <div class="box_content" id="wrapSizeChange">

                                    <div class="content-news">

                                        {!! $data->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @isset($dataRelate)
                        @if ($dataRelate)
                            @if ($dataRelate->count())
                                <div class="row p-75">
                                    <div class="col-xs-12  p-75">
                                        <div class="side-bar wrap-relate shadow">
                                            <div class="title-sider-bar">
                                                <span>{{ __('post-detail.tin_tuc_lien_quan') }}</span>
                                            </div>
                                            <div class="list-trending">
                                                <ul class="d-flex">
                                                    @foreach ($dataRelate as $item)
                                                    <li class="col-sm-6 col-xs-12">
                                                        <div class="box">
                                                            <div class="icon">
                                                                <a href="{{ makeLink('post',$item->id,$item->slug) }}"><img src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a>
                                                            </div>
                                                            <div class="content">

                                                                <h3 class="name">
                                                                    <a href="{{ makeLink('post',$item->id,$item->slug) }}">{{ $item->name }}</a>
                                                                </h3>
                                                                <div class="desc">
                                                                    {{ $item->description }}
                                                                </div>
                                                                <div class="text-right">
                                                                    <div class="date">
                                                                        {{ date_format($item->created_at,"d/m/Y") }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endisset
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
<script>
    $(function(){

        let normalSize=parseFloat($('#wrapSizeChange').css('fontSize'));
        $(document).on('click','.prevSize',function(){
            let font=$('#wrapSizeChange').css('fontSize');
            console.log(parseFloat(font));
            let prevFont;
            if(parseFloat(font)<=10){
                prevFont =parseFloat(font);
            }else{
                 prevFont= parseFloat(font) -1;
            }
            $('#wrapSizeChange').css({'fontSize':prevFont});
        });
        $(document).on('click','.nextSize',function(){
            let font=$('#wrapSizeChange').css('fontSize');
            console.log(parseFloat(font));
            let nextFont;
            nextFont= parseFloat(font) + 1;
            $('#wrapSizeChange').css({'fontSize':nextFont});
        });
        $(document).on('click','.mormalSize',function(){
            $('#wrapSizeChange').css({'fontSize':normalSize});
        });
    })
</script>
<script src="{{ asset('frontend/js/Comment.js') }}">
</script>
{{-- <script>
    console.log($('div').createFormComment());
</script> --}}
@endsection
