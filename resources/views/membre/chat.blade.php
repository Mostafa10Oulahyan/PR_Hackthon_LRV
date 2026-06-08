@extends('layouts.app')

@section('title', 'Support Chat - BiblioTech')

@section('content')
    <div class="max-w-3xl mx-auto h-[600px] flex flex-col glass-card rounded-2xl overflow-hidden relative shadow-2xl mt-4">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

        <!-- Chat Header -->
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
            <div class="flex items-center gap-3">
                <img src="{{ asset($admin->image_profile ?? 'images/user_avatar.png') }}" class="w-10 h-10 rounded-full border border-white/10 object-cover shadow-sm" alt="Admin Avatar">
                <div>
                    <h3 class="font-outfit font-bold text-white text-base">{{ $admin->name }}</h3>
                    <div class="text-xs text-teal-400 flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Support En Ligne
                    </div>
                </div>
            </div>
            <div class="text-xs text-gray-400 font-medium" id="sync-mode">Mode: Polling</div>
        </div>

        <!-- Chat Messages Container -->
        <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#080c14]/20">
            <div class="flex items-center justify-center h-full">
                <div class="w-8 h-8 border-2 border-white/10 border-t-indigo-500 rounded-full animate-spin"></div>
            </div>
        </div>

        <!-- Chat Input Form -->
        <form id="chat-form" onsubmit="handleSendMessage(event)" class="p-4 border-t border-white/5 bg-white/[0.01] flex gap-3 items-center">
            <input type="text" id="message-input" placeholder="Posez votre question à l'administrateur..." class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition duration-150 text-sm">
            <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-600/10 flex items-center gap-1.5 transform hover:-translate-y-0.5 transition-all duration-150 cursor-pointer">
                <span>Envoyer</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                </svg>
            </button>
        </form>
    </div>

    <!-- Scripts for Messaging Realtime & Fallback -->
    <script>
        const adminId = {{ $admin->id }};
        const authId = {{ auth()->id() }};
        let pollingInterval = null;
        let websocketConnected = false;
        let pusher = null;

        document.addEventListener('DOMContentLoaded', () => {
            // Load previous messages first
            fetchMessages();

            // Initialize WebSockets (reusing globalPusher if available)
            if (typeof globalPusher !== 'undefined' && globalPusher) {
                pusher = globalPusher;
                const channel = pusher.subscribe('chat');

                channel.bind('App\\Events\\MessageSent', function(data) {
                    if ((data.sender_id === adminId && data.receiver_id === authId) || 
                        (data.sender_id === authId && data.receiver_id === adminId)) {
                        appendMessage(data);

                        // Mark as read immediately on backend
                        if (data.sender_id === adminId) {
                            fetch(`/chat/read/${adminId}`, {
                                method: 'POST',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            }).then(() => updateUnreadBadges());
                        }
                    }
                });

                pusher.connection.bind('state_change', function(states) {
                    const badge = document.getElementById('sync-mode');
                    if (states.current === 'connected') {
                        websocketConnected = true;
                        badge.innerText = "Mode: Real-Time (WS)";
                        badge.className = "text-xs text-teal-400 font-semibold";
                        if (pollingInterval) {
                            clearInterval(pollingInterval);
                            pollingInterval = null;
                        }
                    } else {
                        websocketConnected = false;
                        badge.innerText = "Mode: Polling (Fallback)";
                        badge.className = "text-xs text-gray-400 font-medium";
                        startPolling();
                    }
                });

                // Initial state sync
                if (pusher.connection.state === 'connected') {
                    websocketConnected = true;
                    const badge = document.getElementById('sync-mode');
                    badge.innerText = "Mode: Real-Time (WS)";
                    badge.className = "text-xs text-teal-400 font-semibold";
                }
            }

            // Always start polling as fallback
            if (!websocketConnected) {
                startPolling();
            }
        });

        function startPolling() {
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(() => {
                if (!websocketConnected) {
                    fetchMessagesSilently();
                }
            }, 3000);
        }

        async function fetchMessages() {
            const container = document.getElementById('messages-container');
            container.innerHTML = `
                <div class="flex items-center justify-center h-full">
                    <div class="w-8 h-8 border-2 border-white/10 border-t-indigo-500 rounded-full animate-spin"></div>
                </div>
            `;

            try {
                const res = await fetch(`/chat/messages/${adminId}`);
                const data = await res.json();

                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = `<div class="chat-empty-state text-center text-gray-500 text-xs py-8">Aucun message échangé. Posez votre question pour démarrer la discussion.</div>`;
                } else {
                    data.forEach(msg => appendMessage(msg, false));
                    container.scrollTop = container.scrollHeight;
                }
            } catch (e) {
                console.error(e);
                container.innerHTML = `<div class="text-center text-red-400 text-xs py-8">Erreur lors de la récupération des messages.</div>`;
            }
        }

        async function fetchMessagesSilently() {
            try {
                const res = await fetch(`/chat/messages/${adminId}`);
                const data = await res.json();

                const container = document.getElementById('messages-container');
                const wasScrolledToBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 50;

                container.innerHTML = '';
                data.forEach(msg => appendMessage(msg, false));

                if (wasScrolledToBottom) {
                    container.scrollTop = container.scrollHeight;
                }
            } catch (e) {
                console.error(e);
            }
        }

        function appendMessage(msg, scroll = true) {
            const container = document.getElementById('messages-container');
            const isSelf = msg.sender_id === authId;

            if (container.querySelector('.chat-empty-state')) {
                container.innerHTML = '';
            }

            if (document.getElementById(`msg-${msg.id}`)) return;

            const alignment = isSelf ? 'justify-end' : 'justify-start';
            const bubbleBg = isSelf ? 'bg-indigo-600 text-white' : 'bg-white/5 border border-white/10 text-gray-200';
            const roundedCorner = isSelf ? 'rounded-br-none' : 'rounded-bl-none';

            const dateStr = new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

            const msgHtml = `
                <div id="msg-${msg.id}" class="flex ${alignment} w-full my-1">
                    <div class="max-w-[70%]">
                        <div class="px-4 py-2.5 rounded-2xl ${roundedCorner} ${bubbleBg} shadow-md text-sm leading-relaxed break-words font-medium">
                            ${escapeHtml(msg.message)}
                        </div>
                        <div class="text-[10px] text-gray-500 mt-1 ${isSelf ? 'text-right' : 'text-left'}">${dateStr}</div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', msgHtml);
            if (scroll) {
                container.scrollTop = container.scrollHeight;
            }
        }

        async function handleSendMessage(e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const text = input.value.trim();
            if (!text) return;

            input.value = '';

            try {
                const response = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receiver_id: adminId,
                        message: text
                    })
                });
                const data = await response.json();
                appendMessage(data);
            } catch (e) {
                console.error(e);
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            let escaped = text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");

            escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            escaped = escaped.replace(/\n/g, '<br>');
            return escaped;
        }
    </script>
@endsection

