@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="disk-title">Библиотека</h1>
        <div class="title-menu">
            @if(explode(':/', $folders->path)[1] == 'Библиотека')
                <h2 class="disk-subtitle">Выберите тематику</h2>
            @else
                <h2 class="disk-subtitle">Категории</h2>
            @endif
            <input id="fileInput" type="file" style="display:none;">
            <input id="currentPath" type="hidden" value="{{$folders->path}}">
            <button id="uploadFile" class="upload-btn">Загрузить макет</button>
        </div>

        <div class="content">
            @if(explode(':/', $folders->path)[1] != 'Библиотека')
                <ul class="navigation">
                    @foreach($navigation as $item)
                        @if($item->type == 'dir')
                            <li>
                                <a href="{{route('folder', ['folder' => $item->path])}}" class="nav-item {{explode(':/Библиотека/', $item->path)[1] == explode(':/Библиотека/', $folders->path)[1] ? 'active' : ''}}">{{$item->name}}</a>
                                <div class="subnav-items"></div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <div>
                @if(explode(':/', $folders->path)[1] != 'Библиотека')
                    <h2 class="disk-subtitle">{{explode(':/Библиотека/', $folders->path)[1]}}</h2>
                @endif
                <div class="files">
                    @foreach($folders as $item)
                        @if($item->type == 'dir')
                            <div class="file-item js-open-dir" data-link="{{route('folder', ['folder' => $item->path])}}">
                                <img src="img/dir.png" alt="">
                                <p>{{$item->name}}</p>
                            </div>
                        @else
                            <div data-file="{{$item->file}}" class="file-item js-get-file">
                                <img src="{{isset($item->preview) ? $item->preview : \App\Helpers\FilesHelper::getPreview($item->name)}}" data-path="{{$item->path}}" alt="">
                                <p>{{$item->name}}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
