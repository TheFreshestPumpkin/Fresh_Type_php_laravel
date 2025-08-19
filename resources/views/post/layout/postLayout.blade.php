<p class="fs-6 text-start fw-bold">{{ $post->user->name }}</p>
<p class="fs-6 text-start fst-italic">{{ $post->created_at->format('d.m.Y H:i') }}</p>
<a href="/post/{{$post->id}}">Подробнее</a>
@if($post->images && count($post->images) > 0)
    <div id="carouselPost{{ $post->id }}" class="carousel slide mx-auto" style="max-width: 500px;">
        <div class="carousel-inner">
            @foreach($post->images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded" alt="post image">
                </div>
            @endforeach
        </div>

        @if(count($post->images) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPost{{ $post->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
@endif


{{-- Текст поста --}}
<div class="text-center">
    <p class="lead">{{ $post->body }}</p>
</div>
