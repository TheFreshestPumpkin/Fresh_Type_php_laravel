@extends('layout')

@section('content')
    <div class="container my-4">

        {{-- Входящие заявки --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">📥 Входящие заявки</h4>

                @forelse($incoming as $req)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <span class="fw-bold">{{ $req->user->name }}</span>

                        <form action="{{ route('friends.accept', $req->user->id) }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-success btn-sm">✅ Принять</button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted">Нет входящих заявок</p>
                @endforelse
            </div>
        </div>

        {{-- Исходящие заявки --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3">📤 Исходящие заявки</h4>

                @forelse($outgoing as $req)
                    <div class="border-bottom py-2">
                        <span class="fw-bold">{{ $req->friend->name }}</span>
                        <span class="text-muted"> — ожидает подтверждения</span>
                    </div>
                @empty
                    <p class="text-muted">Нет исходящих заявок</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection

