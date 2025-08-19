@extends('layout')

@section('content')
    <form method="POST" action="/post/{{ $post->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <textarea class="form-control" name="body" rows="4">{{ old('body', $post->body) }}</textarea>
        </div>

        <div class="mb-3 d-flex flex-wrap gap-3">
            @if($post->images)
                @foreach($post->images as $image)
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="max-width: 150px;">
                        <div class="form-check position-absolute top-0 start-0 bg-white bg-opacity-75 rounded px-2">
                            <input type="checkbox" name="delete_images[]" value="{{ $image }}" class="form-check-input" id="delete_{{ md5($image) }}">
                            <label class="form-check-label small" for="delete_{{ md5($image) }}">Удалить</label>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Добавить новые изображения</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Сохранить изменения</button>
    </form>
@endsection
