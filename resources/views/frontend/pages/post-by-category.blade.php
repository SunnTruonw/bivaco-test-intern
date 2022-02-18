@extends('frontend.layouts.main')



@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('css')
<style type="text/css">
    .wrap-breadcrumbs{
        margin-bottom: 0;
    }

    .title-template-in .title-inner{
        padding-top: 30px;
        display: block;
    }
</style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="main">
            @if ($category->id==13)

            @else
                @isset($breadcrumbs,$typeBreadcrumb)
                    @include('frontend.components.breadcrumbs',[
                        'breadcrumbs'=>$breadcrumbs,
                        'type'=>$typeBreadcrumb,
                    ])
                @endisset
            @endif
                <div class="block-news">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <h1 class="title-template-in">
                                    @if ($category->id==13)

                                    <!-- <div class="img_about">
                                        <a href="{{ $category->description }}">
                                            <img class="" src="{{ asset($category->avatar_path) }}" alt="{{ $category->name }}">
                                        </a>
                                    </div> -->
                                    @else
                                    <span class="title-inner"> {{ $category->name??"" }} </span>
                                    @endif

                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12  block-content-right">

                                @isset($data)
                                    <div class="wrap-list-news">
                                        <div class="list-card-news-horizontal">
                                            <div class="row">
                                                @foreach($data as $post_item)
                                                <div class="col-card-news-horizontal col-sm-3">
                                                    <div class="card-news-horizontal card-news-horizontal-2">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}"><img src="{{asset($post_item->avatar_path)}}" alt="{{$post_item->name}}"></a>
                                                            </div>
                                                            <div class="content">
                                                                <h3><a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}">{{$post_item->name}}</a></h3>
                                                                 <div class="date"><i class="far fa-calendar-alt"></i> {{ Illuminate\Support\Carbon::parse($post_item->created_at)->format('d/m/Y') }} - Đăng bởi Admin</div>
                                                                <div class="desc">
                                                                    {{$post_item->description}}
                                                                </div>
                                                               <div class="text-right">
                                                                <a href="{{ makeLink('post',$post_item->id,$post_item->slug) }}" class="btn-viewmore btn btn-light"><i class="fas fa-angle-double-right"></i> Xem thêm</a>
                                                               </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            @if (count($data))
                                            {{$data->appends(request()->all())->links()}}
                                            @endif
                                        </div>
                                    </div>
                                @endisset
                                @if ($category->content)
                                <div class="content-category" id="wrapSizeChange">
                                    {!! $category->content !!}
                                </div>
                                @endif
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

    })
</script>
@endsection
