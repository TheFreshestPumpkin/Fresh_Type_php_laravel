@extends('layout')

@section('content')

    <div class="container w-50 text-center mx-auto p-2">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <form class="singlePost" action="/post" method="POST" enctype="multipart/form-data">
                @csrf

                <textarea class="mx-auto p-2" name="body" placeholder="Текст поста"></textarea>
                <br>
                <input class="mx-auto p-2" type="file" name="images[]" multiple>
                <br>
                <button class="btn btn-primary mx-auto p-2" type="submit">Опубликовать</button>
            </form>
        </div>

        @foreach($posts as $post)
            <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary position-relative">
                @include('post.layout.postLayout', ['post' => $post])
                <hr>
                <div>
                    @include('post.layout.commentsBlock', ['post' => $post])
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center my-4">
            {{-- Кнопка "Назад" --}}
            @if ($posts->onFirstPage())
                <button class="btn btn-secondary me-2" disabled>Назад</button>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="btn btn-primary me-2">Назад</a>
            @endif

            {{-- Номер текущей страницы --}}
            <span class="align-self-center">Страница {{ $posts->currentPage() }} из {{ $posts->lastPage() }}</span>

            {{-- Кнопка "Вперёд" --}}
            @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="btn btn-primary ms-2">Вперёд</a>
            @else
                <button class="btn btn-secondary ms-2" disabled>Вперёд</button>
            @endif
        </div>
    </div>
@endsection

