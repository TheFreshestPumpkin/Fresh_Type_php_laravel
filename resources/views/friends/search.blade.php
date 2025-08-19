@extends('layout')

@section('content')
    <div class="container my-4">

        {{-- Поиск --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('friends.search') }}" class="row g-2">
                    <div class="col-md-9">
                        <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="🔍 Поиск пользователей..." class="form-control">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-primary">Найти</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Список пользователей --}}
        <div class="row">
            @forelse($users as $user)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">
                                <a href="/" class="text-decoration-none text-dark">
                                    {{ $user->name }}
                                </a>
                            </h5>

                            <div class="mt-3">
                                @if(Auth::user()->isFriendWith($user->id))
                                    <form action="{{ route('friends.remove', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger w-100">❌ Удалить из друзей</button>
                                    </form>
                                @elseif(Auth::user()->friendRequestsSent->contains('friend_id', $user->id))
                                    <span class="badge bg-secondary w-100 py-2">📤 Заявка отправлена</span>
                                @elseif(Auth::user()->friendRequestsReceived->contains('user_id', $user->id))
                                    <form action="{{ route('friends.accept', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success w-100">✅ Принять заявку</button>
                                    </form>
                                @else
                                    <form action="{{ route('friends.add', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary w-100">➕ Добавить в друзья</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Никто не найден 🙃
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $users->links() }}
        </div>

    </div>
@endsection
