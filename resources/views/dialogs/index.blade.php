@extends('layout')

@section('content')
    <div class="container w-50">
        <h3 class="mb-4">Диалоги</h3>
        <a href="{{route('dialogs.create')}}">Новая беседа</a>
        @foreach($dialogs as $dialog)
            <div class="d-flex align-items-center justify-content-between p-3 mb-2 border rounded">
                {{-- Название или собеседник --}}
                <div>
                    <a href="{{ route('dialogs.show', $dialog->id) }}" class="fw-bold text-decoration-none">
                        {{ $dialog->title ?? 'Диалог #'.$dialog->id }}
                    </a>
                    <p class="text-muted small mb-0">
                        Последнее сообщение: {{ optional($dialog->messages->last())->body }}
                    </p>
                </div>

                {{-- Непрочитанные сообщения --}}
                @if($dialog->unread_count > 0)
                    <span class="badge bg-danger rounded-pill">
                    {{ $dialog->unread_count }}
                </span>
                @endif
            </div>
        @endforeach
    </div>
@endsection
