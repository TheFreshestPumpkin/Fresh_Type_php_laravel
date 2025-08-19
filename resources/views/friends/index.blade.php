@extends('layout')

@section('content')
    <div class="container my-4">

        {{-- Навигация --}}
        <div class="d-flex justify-content-center mb-4">
            <a class="btn btn-outline-primary mx-2" href="{{ route('friends.requests') }}">
                📩 Заявки
            </a>
            <a class="btn btn-outline-success mx-2" href="{{ route('friends.search') }}">
                🔍 Найти друзей
            </a>
        </div>

        <h2 class="text-center mb-4">👥 Мои друзья</h2>

        @if($friends->isEmpty())
            <div class="alert alert-info text-center">
                У вас пока нет друзей 🙃
            </div>
        @else
            <div class="row">
                @foreach($friends as $friend)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">
                                    <a href="{{route('profile',$friend)}}" class="text-decoration-none text-dark">
                                        {{ $friend->name }}
                                    </a>
                                </h5>
                                <form action="{{ route('friends.remove', $friend->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger w-100">
                                        ❌ Удалить из друзей
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection

