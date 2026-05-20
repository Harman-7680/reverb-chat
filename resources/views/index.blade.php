<x-app-layout>

    @vite(['resources/js/app.js'])

    <div class="max-w-7xl mx-auto py-6 flex gap-6">

        <!-- Users -->
        <div class="w-1/4 bg-white shadow rounded p-4">
            <h2 class="font-bold mb-4">Users</h2>

            @foreach ($users as $u)
               <a href="{{ route('reverb-chat.index', $u->id) }}" class="block p-2 rounded hover:bg-gray-100">
                    {{ $u->name }}
                </a>
            @endforeach
        </div>

        <!-- Chat -->
        <div class="flex-1 bg-white shadow rounded p-4">

            <h2 class="font-bold mb-4">
                Chat with {{ $user->name }}
            </h2>

            <div id="messages" class="h-[400px] overflow-y-auto border rounded p-4 mb-4 space-y-2">

                @foreach ($messages as $msg)
                    <div class="{{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">

                        <div class="inline-block px-4 py-2 rounded bg-gray-200">
                            {{ $msg->message }}
                        </div>

                    </div>
                @endforeach

            </div>

            <div class="flex gap-2">

                <input type="text" id="message" class="border rounded w-full p-2" placeholder="Type message...">

                <button id="sendBtn" class="bg-black text-white px-4 rounded">
                    Send
                </button>

            </div>

        </div>

    </div>

    <script>
        window.chatUserId = {{ $user->id }};
        window.authUserId = {{ auth()->id() }};
    </script>

    <script>
        const messagesDiv = document.getElementById('messages');

        function appendMessage(message, mine = false) {
            const div = document.createElement('div');

            div.className = mine ? 'text-right' : 'text-left';

            div.innerHTML = `
                <div class="inline-block px-4 py-2 rounded bg-gray-200">
                    ${message}
                </div>
            `;

            messagesDiv.appendChild(div);

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        document.getElementById('sendBtn')
            .addEventListener('click', async () => {

                const input = document.getElementById('message');

                if (!input.value.trim()) return;

                const message = input.value;

                appendMessage(message, true);

                input.value = '';

                await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: {{ $user->id }},
                        message: message
                    })
                });

            });

        // IMPORTANT
        window.addEventListener('load', () => {

            console.log(window.Echo);

            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('.message.sent', (e) => {

                    console.log("REALTIME EVENT", e);

                    appendMessage(e.message.message, false);
                });

        });
    </script>

</x-app-layout>
