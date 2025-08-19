@extends('layout')

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Создать новый диалог</h4>

                <form method="POST" action="{{ route('dialogs.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Название беседы</label>
                        <input type="text" class="form-control" name="title" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Выберите друзей</label>
                        @foreach($friends as $friend)
                            <div class="form-check">
                                <input type="checkbox" name="friends[]" value="{{ $friend->id }}" id="friend{{ $friend->id }}" class="form-check-input">
                                <label class="form-check-label" for="friend{{ $friend->id }}">
                                    {{ $friend->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
