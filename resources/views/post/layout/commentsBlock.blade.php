<div class="comments mt-4">
    <h5 class="mb-3">Комментарии ({{ $post->comments->count() }})</h5>

    {{-- Список комментариев --}}
    @forelse($post->comments as $comment)
        <div class="border rounded p-3 mb-2 text-start bg-light position-relative">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>{{ $comment->user->name }}</strong>
                <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
            </div>
            @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::id() === $post->user_id))
                <form action="{{ route('comments.destroy', [$post->id, $comment->id]) }}"
                      method="POST"
                      class="position-absolute top-1 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Удалить комментарий?')">
                        Удалить
                    </button>
                </form>
            @endif
            <p class="mb-0">{{ $comment->body }}</p>
        </div>
    @empty
        <p class="text-muted">Комментариев пока нет.</p>
    @endforelse

    {{-- Форма добавления комментария --}}
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="mb-2">
            <textarea name="body" class="form-control" rows="3" placeholder="Напишите комментарий..." required></textarea>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Отправить</button>
    </form>
</div>
