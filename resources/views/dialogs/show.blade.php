@extends('layout')

@section('content')
    <div class="container w-50 mx-auto">
        <div class="card shadow-sm">
            {{-- Заголовок --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $dialog->title }}</h5>
            </div>

            {{-- Список сообщений --}}
            <div id="messages" class="card-body bg-light" style="height: 450px; overflow-y: auto;">
                @foreach($messages as $message)
                    <div class="mb-3 {{ $message->user_id === auth()->id() ? 'text-end' : 'text-start' }}">
                        <div class="d-inline-block p-2 px-3 rounded-3
                            {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-white border' }}">
                            {{ $message->body }}
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $message->created_at->format('H:i') }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Форма нового сообщения --}}
            <div class="card-footer bg-white">
                <form id="messageForm" action="{{ route('messages.store', $dialog) }}" method="POST" class="d-flex">
                    @csrf
                    <input type="text" name="body" class="form-control me-2" placeholder="Введите сообщение..." required>
                    <button class="btn btn-success" type="submit">➤</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let lastCheck = "{{ now() }}";

        function fetchMessages() {
            fetch("{{ route('messages.fetch', $dialog->id) }}?last_check=" + encodeURIComponent(lastCheck))
                .then(response => response.json())
                .then(data => {
                    if (data.messages.length > 0) {
                        let messagesDiv = document.getElementById('messages');
                        data.messages.forEach(msg => {
                            let wrapper = document.createElement('div');
                            wrapper.className = "mb-3 " + (msg.user_id === {{ auth()->id() }} ? "text-end" : "text-start");

                            wrapper.innerHTML = `
                                <div class="d-inline-block p-2 px-3 rounded-3 ${msg.user_id === {{ auth()->id() }} ? 'bg-primary text-white' : 'bg-white border'}">
                                    ${msg.body}
                                </div>
                                <div class="small text-muted mt-1">${msg.created_at}</div>
                            `;
                            messagesDiv.appendChild(wrapper);
                        });

                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                        lastCheck = data.now;
                    }
                });
        }

        // Автообновление каждые 5 секунд
        setInterval(fetchMessages, 5000);

        // AJAX отправка формы
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    let messagesDiv = document.getElementById('messages');

                    // создаём блок для нового сообщения
                    let div = document.createElement('div');
                    div.className = "mb-2 " + (data.message.user_id === {{ auth()->id() }} ? "text-end" : "text-start");
                    div.innerHTML = `
            <div class="d-inline-block p-2 rounded ${data.message.user_id === {{ auth()->id() }} ? 'bg-primary text-white' : 'bg-light'}">
                ${data.message.body}
            </div>
            <div class="small text-muted">${new Date(data.message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
        `;

                    messagesDiv.appendChild(div);
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;

                    // сбрасываем форму
                    e.target.reset();
                });
        });
    </script>
@endsection

