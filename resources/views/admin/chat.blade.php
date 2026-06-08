@extends('layouts.app')

@section('title', 'Support Chat Admin - BiblioTech')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-outfit font-extrabold bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">Support Client Real-Time</h1>
    <p class="text-gray-400 text-sm mt-1">Discutez en direct avec les membres de la bibliothèque.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-[600px] max-h-[70vh]">
    
    <!-- Users list Sidebar (1/4 width) -->
    <div class="lg:col-span-1 glass-card rounded-2xl p-4 flex flex-col overflow-y-auto">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-2">Membres</h3>
        <div class="flex flex-col gap-2" id="users-list">
            @foreach($users as $user)
                <button onclick="selectUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ asset($user->image_profile ?? 'images/user_avatar.png') }}')" id="user-tab-{{ $user->id }}" class="w-full flex items-center justify-between p-3 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/5 transition-all duration-200 cursor-pointer text-left group">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="{{ asset($user->image_profile ?? 'images/user_avatar.png') }}" class="w-10 h-10 rounded-full border border-white/10 flex-shrink-0 object-cover group-hover:scale-105 transition-transform duration-200 shadow-sm" alt="Avatar">
                        <div class="min-w-0">
                            <div class="font-semibold text-sm text-white truncate">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400 truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                    <!-- Unread Count Badge for this member -->
                    <span id="unread-badge-{{ $user->id }}" class="hidden px-2 py-0.5 text-[10px] font-bold bg-red-500 text-white rounded-full min-w-[20px] text-center shadow-md shadow-red-500/20">0</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Active Chat Box (3/4 width) -->
    <div class="lg:col-span-3 glass-card rounded-2xl flex flex-col overflow-hidden relative">
        <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 to-teal-500"></div>

        <!-- Chat Header -->
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between bg-white/[0.01]">
            <div class="flex items-center gap-3">
                <img id="active-user-avatar" src="{{ asset('images/user_avatar.png') }}" class="w-10 h-10 rounded-full border border-white/10 object-cover hidden shadow-sm" alt="Avatar">
                <div>
                    <h3 id="active-user-name" class="font-outfit font-bold text-white text-base">Sélectionnez un membre pour commencer</h3>
                    <div id="active-user-status" class="text-xs text-emerald-400 flex items-center gap-1.5 mt-0.5 hidden">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        En ligne
                    </div>
                </div>
            </div>
            <div class="text-xs text-gray-400 font-medium" id="sync-mode">Mode: Polling</div>
        </div>

        <!-- Chat Messages Container -->
        <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#080c14]/20">
            <div class="flex flex-col items-center justify-center h-full text-center text-gray-400">
                <svg class="w-12 h-12 text-indigo-500/30 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 18a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 13.717 3.75 12.878 3.75 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path>
                </svg>
                <p class="text-sm">Cliquez sur un membre à gauche pour ouvrir la boîte de dialogue.</p>
            </div>
        </div>

        <!-- Chat Input Form -->
        <form id="chat-form" onsubmit="handleSendMessage(event)" class="p-4 border-t border-white/5 bg-white/[0.01] flex gap-3 items-center hidden">
            <input type="text" id="message-input" placeholder="Saisissez votre message d'assistance..." class="flex-1 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 transition duration-150 text-sm">
            <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 shadow shadow-indigo-600/10 flex items-center gap-1.5 transform hover:-translate-y-0.5 transition-all duration-150 cursor-pointer">
                <span>Envoyer</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Scripts for Messaging Realtime & Fallback -->
<script>
    let activeUserId = null;
    let pollingInterval = null;
    let websocketConnected = false;
    let pusher = null;

    document.addEventListener('DOMContentLoaded', () => {
        // Handle unread badges count updates in sidebar
        window.addEventListener('unreadCountUpdated', (e) => {
            const breakdown = e.detail.breakdown || {};
            @foreach($users as $user)
                {
                    const userId = {{ $user->id }};
                    const badge = document.getElementById(`unread-badge-${userId}`);
                    if (badge) {
                        const count = breakdown[userId] || 0;
                        if (count > 0 && activeUserId !== userId) {
                            badge.innerText = count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                }
            @endforeach
        });

        // Initialize WebSockets (reusing globalPusher if available)
        if (typeof globalPusher !== 'undefined' && globalPusher) {
            pusher = globalPusher;
            const channel = pusher.subscribe('chat');
            
            channel.bind('App\\Events\\MessageSent', function(data) {
                console.log('Event received (admin): ', data);
                if (data.receiver_id === {{ auth()->id() }}) {
                    if (activeUserId && data.sender_id === activeUserId) {
                        appendMessage(data);
                        // Mark as read immediately on backend
                        fetch(`/chat/read/${activeUserId}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        }).then(() => updateUnreadBadges());
                    } else {
                        updateUnreadBadges();
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
        } else {
            startPolling();
        }
    });

    function startPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(() => {
            if (activeUserId && !websocketConnected) {
                fetchMessagesSilently();
            }
        }, 3000);
    }

    function selectUser(id, name, avatarUrl) {
        activeUserId = id;
        
        // Clear badge locally
        const badge = document.getElementById(`unread-badge-${id}`);
        if (badge) badge.classList.add('hidden');

        // Mark messages as read in backend
        fetch(`/chat/read/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => updateUnreadBadges());

        // UI updates
        document.querySelectorAll('#users-list button').forEach(btn => btn.classList.remove('bg-white/10', 'border-white/10'));
        document.getElementById(`user-tab-${id}`).classList.add('bg-white/10', 'border-white/10');
        
        const avatarEl = document.getElementById('active-user-avatar');
        avatarEl.src = avatarUrl;
        avatarEl.classList.remove('hidden');
        document.getElementById('active-user-name').innerText = name;
        document.getElementById('active-user-status').classList.remove('hidden');
        
        document.getElementById('chat-form').classList.remove('hidden');
        
        fetchMessages();
        
        if (!websocketConnected) {
            startPolling();
        }
    }

    async function fetchMessages() {
        if (!activeUserId) return;
        const container = document.getElementById('messages-container');
        container.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <div class="w-8 h-8 border-2 border-white/10 border-t-indigo-500 rounded-full animate-spin"></div>
            </div>
        `;
        
        try {
            const res = await fetch(`/chat/messages/${activeUserId}`);
            const data = await res.json();
            
            container.innerHTML = '';
            if (data.length === 0) {
                container.innerHTML = `<div class="chat-empty-state text-center text-gray-500 text-xs py-8">Aucun message échangé. Écrivez un message pour démarrer la discussion.</div>`;
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
        if (!activeUserId) return;
        try {
            const res = await fetch(`/chat/messages/${activeUserId}`);
            const data = await res.json();
            
            const container = document.getElementById('messages-container');
            const wasScrolledToBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 50;
            
            // Re-render message list
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
        const isSelf = msg.sender_id === {{ auth()->id() }};
        
        // Remove empty state message if exists
        if (container.querySelector('.chat-empty-state')) {
            container.innerHTML = '';
        }
        
        // Check if message is already rendered to avoid duplicates
        if (document.getElementById(`msg-${msg.id}`)) return;
        
        const alignment = isSelf ? 'justify-end' : 'justify-start';
        const bubbleBg = isSelf ? 'bg-indigo-600 text-white' : 'bg-white/5 border border-white/10 text-gray-200';
        const roundedCorner = isSelf ? 'rounded-br-none' : 'rounded-bl-none';
        
        const dateStr = new Date(msg.created_at).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        
        const msgHtml = `
            <div id="msg-${msg.id}" class="flex ${alignment} w-full">
                <div class="max-w-[70%]">
                    <div class="px-4 py-2.5 rounded-2xl ${roundedCorner} ${bubbleBg} shadow-md text-sm leading-relaxed break-words">
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
        if (!text || !activeUserId) return;
        
        input.value = '';
        
        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    receiver_id: activeUserId,
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
