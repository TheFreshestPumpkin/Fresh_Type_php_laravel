@extends('layout')

@section('content')
    <div class="container w-50 text-center mx-auto p-2">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary position-relative">
            <p class="fs-6 text-start fw-bold">{{ $post->user->name }}</p>
            <p class="fs-6 text-start fst-italic">{{ $post->created_at->format('d.m.Y H:i') }}</p>
            <div class="position-absolute top-0 end-0">
                <form method="post" action="/post/{{$post->id}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Удалить пост?')">Удалить</button>
                </form>
            </div>
            <div class="position-absolute top-1 end-0">
                <form method="get" action="/post/{{$post->id}}/edit">
                    @csrf
                    @method('get')
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </form>
            </div>

            @if($post->images && count($post->images) > 0)
                <div  class="mx-auto" style="max-width: 500px;">
                    <div class="carousel-inner">
                        @foreach($post->images as $index => $image)
                                <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded" alt="post image">
                        @endforeach
                    </div>
                </div>
            @endif


            {{-- Текст поста --}}
            <div class="text-center">
                <p class="lead">{{ $post->body }}</p>
            </div>
            <hr>
            <div>
                @include('post.layout.commentsBlock', ['post' => $post])
            </div>

        </div>
    </div>
@endsection
