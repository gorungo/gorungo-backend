@extends ('layouts.app')

@section('title', 'Справочная информация')
@section('description', 'Использование ресурса Dvstaff.ru')
@section('keywords', '')

@section('content')
    <div class="container margin-top">
        @if(isset($item->title))
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="active"><a href="{{URL::route('pages.show', '')}}">О проекте</a></li>
                    <li><a href="{{URL::route('pages.show', 'rules')}}">Правила сайта</a></li>
                    <li><a href="{{URL::route('pages.show', 'confidential-policy')}}">Политика конфиденциальности</a></li>
                </ul>

            </div>

        <div class="col-sm-9 col-md-10 main" style="padding-bottom: 20px;">
            <article>
                <h1>{{$item->title}}</h1>
                <p class="margin-top" style="text-align: justify;">{!! nl2br(strip_tags($item->description,'<a><br><strong><img><h1><h2><h3><p><s><em><ul><blockquote><ol><li>')) !!}</p>
            </article>
        </div>

        @endif

    </div>



@endsection
