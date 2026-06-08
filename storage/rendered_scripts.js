--- SCRIPT BLOCK 3 ---
<script>
            const authId = 6;
            const isAdmin = false;
            const adminId = 5;
            let globalPusher = null;
            let notifDropdownOpen = false;

            // Initialize global Pusher immediately so page-specific scripts can reuse it in DOMContentLoaded
            try {
                const isProductionPusher = 'pusher' === 'pusher';
                const pusherKey = 'adfb91ce187216651045';
                const config = isProductionPusher ? {
                    cluster: 'eu',
                    forceTLS: true
                } : {
                    wsHost: window.location.hostname,
                    wsPort: 8080,
                    wssPort: 8080,
                    forceTLS: false,
                    encrypted: false,
                    disableStats: true,
                    enabledTransports: ['ws', 'wss']
                };

                globalPusher = new Pusher(pusherKey, config);
            } catch (e) {
                console.error("Global Pusher init failed:", e);
            }

            // ───────── Chat Unread Badges ─────────
            async function updateUnreadBadges() {
                try {
                    const res = await fetch('/chat/unread-count');
                    const data = await res.json();
                    const total = data.total;

                    const navBadge = document.getElementById('nav-unread-badge');
                    if (navBadge) {
                        if (total > 0) {
                            navBadge.innerText = total;
                            navBadge.classList.remove('hidden');
                        } else {
                            navBadge.classList.add('hidden');
                        }
                    }

                    const widgetBadge = document.getElementById('widget-unread-badge');
                    if (widgetBadge) {
                        if (total > 0) {
                            widgetBadge.innerText = total;
                            widgetBadge.classList.remove('hidden');
                        } else {
                            widgetBadge.classList.add('hidden');
                        }
                    }

                    window.dispatchEvent(new CustomEvent('unreadCountUpdated', { detail: data }));
                } catch (e) {
                    console.error("Unread count fetch failed:", e);
                }
            }

            // ───────── Notification System ─────────
            async function updateNotifBadge() {
                try {
                    const res = await fetch('/notifications/unread-count');
                    const data = await res.json();
                    const badge = document.getElementById('notif-count-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.innerText = data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                } catch (e) { }
            }

            function toggleNotifications() {
                const dropdown = document.getElementById('notification-dropdown');
                notifDropdownOpen = !notifDropdownOpen;
                if (notifDropdownOpen) {
                    dropdown.classList.remove('hidden');
                    fetchNotifications();
                } else {
                    dropdown.classList.add('hidden');
                }
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                const wrapper = document.getElementById('notification-wrapper');
                if (wrapper && !wrapper.contains(e.target)) {
                    const dropdown = document.getElementById('notification-dropdown');
                    if (dropdown) {
                        dropdown.classList.add('hidden');
                        notifDropdownOpen = false;
                    }
                }
            });

            async function fetchNotifications() {
                const list = document.getElementById('notification-list');
                try {
                    const res = await fetch('/notifications');
                    const data = await res.json();
                    if (data.length === 0) {
                        list.innerHTML = `<div class="text-center text-gray-500 text-xs py-6">Aucune notification pour le moment.</div>`;
                        return;
                    }
                    list.innerHTML = '';
                    data.forEach(n => {
                        list.insertAdjacentHTML('beforeend', renderNotifItem(n));
                    });
                } catch (e) {
                    list.innerHTML = `<div class="text-center text-red-400 text-xs py-6">Erreur de chargement.</div>`;
                }
            }

            function renderNotifItem(n) {
                const iconMap = {
                    success: { bg: 'bg-emerald-500/10', text: 'text-emerald-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' },
                    error: { bg: 'bg-red-500/10', text: 'text-red-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' },
                    warning: { bg: 'bg-amber-500/10', text: 'text-amber-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>' },
                    info: { bg: 'bg-indigo-500/10', text: 'text-indigo-400', svg: '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>' },
                };
                const icon = iconMap[n.icon] || iconMap.info;
                const unreadDot = !n.is_read ? '<span class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 animate-pulse"></span>' : '';
                const opacity = n.is_read ? 'opacity-60' : '';

                return `
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-white/5 transition-all duration-150 cursor-default ${opacity}" onclick="markNotifRead(${n.id}, this)">
                            <div class="w-8 h-8 rounded-full ${icon.bg} ${icon.text} flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">${icon.svg}</svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-white truncate">${escapeNotifHtml(n.title)}</span>
                                    ${unreadDot}
                                </div>
                                <p class="text-[11px] text-gray-400 mt-0.5 leading-relaxed">${escapeNotifHtml(n.message)}</p>
                                <span class="text-[9px] text-gray-500 mt-1 block">${n.time_ago}</span>
                            </div>
                        </div>
                    `;
            }

            function escapeNotifHtml(text) {
                return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            }

            async function markNotifRead(id, el) {
                try {
                    await fetch(`/notifications/${id}/mark-read`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': 'qIswqqkIDfbHg9guMvKruzxXN1oMF2RPeBAsuCgC' }
                    });
                    if (el) el.classList.add('opacity-60');
                    updateNotifBadge();
                } catch (e) { }
            }

            async function markAllNotificationsRead() {
                try {
                    await fetch('/notifications/mark-all-read', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': 'qIswqqkIDfbHg9guMvKruzxXN1oMF2RPeBAsuCgC' }
                    });
                    updateNotifBadge();
                    fetchNotifications();
                } catch (e) { }
            }

            // ───────── Toast Notification ─────────
            function showToastNotification(notif) {
                const iconMap = {
                    success: { color: 'border-emerald-500', bg: 'from-emerald-500/20', icon: '✅' },
                    error: { color: 'border-red-500', bg: 'from-red-500/20', icon: '❌' },
                    warning: { color: 'border-amber-500', bg: 'from-amber-500/20', icon: '🔄' },
                    info: { color: 'border-indigo-500', bg: 'from-indigo-500/20', icon: '📚' },
                };
                const style = iconMap[notif.icon] || iconMap.info;
                const toastId = 'toast-' + Date.now();

                const toastHtml = `
                        <div id="${toastId}" class="toast-item glass-card rounded-xl border-l-4 ${style.color} p-4 flex items-start gap-3 w-[340px] shadow-2xl transform translate-x-full transition-all duration-500 ease-out cursor-pointer" onclick="this.remove(); updateNotifBadge();">
                            <div class="text-xl flex-shrink-0">${style.icon}</div>
                            <div class="flex-1 min-w-0">
                                <div class="text-xs font-bold text-white">${escapeNotifHtml(notif.title)}</div>
                                <div class="text-[11px] text-gray-300 mt-0.5 leading-relaxed">${escapeNotifHtml(notif.message)}</div>
                            </div>
                            <button class="text-gray-500 hover:text-white text-xs transition cursor-pointer flex-shrink-0" onclick="event.stopPropagation(); document.getElementById('${toastId}').remove();">✕</button>
                        </div>
                    `;

                let container = document.getElementById('toast-container');
                if (!container) {
                    const div = document.createElement('div');
                    div.id = 'toast-container';
                    div.className = 'fixed top-24 right-6 z-[9999] flex flex-col gap-3';
                    document.body.appendChild(div);
                    container = div;
                }

                container.insertAdjacentHTML('beforeend', toastHtml);
                const toast = document.getElementById(toastId);

                // Animate in
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        toast.classList.remove('translate-x-full');
                        toast.classList.add('translate-x-0');
                    });
                });

                // Auto-remove after 6s
                setTimeout(() => {
                    if (toast) {
                        toast.classList.add('translate-x-full', 'opacity-0');
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 6000);
            }

            // ───────── Init ─────────
            document.addEventListener('DOMContentLoaded', () => {
                updateUnreadBadges();
                updateNotifBadge();

                // Set up subscriptions if globalPusher is initialized
                if (globalPusher) {
                    try {
                        // Chat channel
                        const globalChannel = globalPusher.subscribe('chat');
                        globalChannel.bind('App\\Events\\MessageSent', function (data) {
                            if (data.receiver_id === authId) {
                                if (typeof activeUserId !== 'undefined' && activeUserId === data.sender_id) {
                                    return;
                                }
                                if (window.location.pathname === '/membre/chat') {
                                    return;
                                }
                                if (typeof widgetOpen !== 'undefined' && widgetOpen && data.sender_id === adminId) {
                                    appendWidgetMessage(data);
                                    fetch(`/chat/read/${adminId}`, {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': 'qIswqqkIDfbHg9guMvKruzxXN1oMF2RPeBAsuCgC' }
                                    });
                                    return;
                                }
                                updateUnreadBadges();
                            }
                        });

                        // Notifications channel
                        const notifChannel = globalPusher.subscribe('notifications');
                        notifChannel.bind('App\\Events\\NotificationSent', function (data) {
                            if (data.user_id === authId) {
                                // Show toast
                                showToastNotification(data);
                                // Update badge
                                updateNotifBadge();
                                // Update dropdown if open
                                if (notifDropdownOpen) {
                                    fetchNotifications();
                                }
                            }
                        });
                    } catch (e) {
                        console.error("Global Pusher subscription failed:", e);
                    }
                }

                // Poll notifications every 15 seconds as fallback
                setInterval(() => { updateNotifBadge(); }, 15000);
            });
        </script>

--- SCRIPT BLOCK 4 ---
<script>
                let widgetOpen = false;
                let botHistory = [];

                // Load history from sessionStorage
                if (sessionStorage.getItem('biblio_bot_history')) {
                    try {
                        botHistory = JSON.parse(sessionStorage.getItem('biblio_bot_history'));
                    } catch (e) {
                        botHistory = [];
                    }
                }

                // Listen for unreadCountUpdated to toggle the admin notification banner inside the widget
                window.addEventListener('unreadCountUpdated', (e) => {
                    const total = e.detail.total || 0;
                    const banner = document.getElementById('widget-admin-notif-banner');
                    if (banner) {
                        if (total > 0) {
                            banner.classList.remove('hidden');
                        } else {
                            banner.classList.add('hidden');
                        }
                    }
                });

                function toggleChatWidget() {
                    const windowEl = document.getElementById('chat-widget-window');
                    widgetOpen = !widgetOpen;

                    if (widgetOpen) {
                        windowEl.classList.remove('hidden');
                        renderBotChat();
                        // Update unread count immediately to refresh banner status
                        updateUnreadBadges();
                    } else {
                        windowEl.classList.add('hidden');
                    }
                }

                function saveBotHistory() {
                    sessionStorage.setItem('biblio_bot_history', JSON.stringify(botHistory));
                }

                function renderBotChat() {
                    const container = document.getElementById('widget-messages-container');
                    container.innerHTML = '';

                    if (botHistory.length === 0) {
                        botHistory.push({
                            id: 'welcome',
                            isBot: true,
                            message: "Bonjour ! Je suis l'assistant virtuel de BiblioTech. 🤖\nComment puis-je vous aider aujourd'hui ? Sélectionnez l'une des options ci-dessous ou posez-moi votre question directement.",
                            showOptions: true
                        });
                        saveBotHistory();
                    }

                    botHistory.forEach(msg => {
                        appendBotMessageHtml(msg);
                    });

                    container.scrollTop = container.scrollHeight;
                }

                function appendBotMessageHtml(msg) {
                    const container = document.getElementById('widget-messages-container');
                    const alignment = !msg.isBot ? 'justify-end' : 'justify-start';
                    const bubbleBg = !msg.isBot ? 'bg-indigo-600 text-white' : 'bg-white/5 border border-white/10 text-gray-200';
                    const roundedCorner = !msg.isBot ? 'rounded-br-none' : 'rounded-bl-none';

                    let optionsHtml = '';
                    if (msg.isBot && msg.showOptions) {
                        optionsHtml = `
                            <div class="flex flex-col gap-1.5 mt-3 chatbot-options-list">
                                <button onclick="handleBotOption('books')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer">📚 Trouver/Rechercher un livre</button>
                                <button onclick="handleBotOption('loans')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer">⏱️ Règles des emprunts</button>
                                <button onclick="handleBotOption('profile')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer">👤 Gérer mon profil</button>
                                <button onclick="handleBotOption('alerts')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer">🔔 Système d'alertes</button>
                                <button onclick="handleBotOption('human')" class="w-full text-left px-3 py-1.5 rounded-xl bg-white/5 hover:bg-indigo-600/20 border border-white/10 hover:border-indigo-500/30 text-[10px] text-white transition-all cursor-pointer">💬 Contacter l'administrateur</button>
                            </div>
                        `;
                    }

                    const timeStr = msg.time || new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });

                    const msgHtml = `
                        <div class="flex ${alignment} w-full my-1 bot-msg-bubble">
                            <div class="max-w-[80%]">
                                <div class="px-3 py-2 rounded-xl ${roundedCorner} ${bubbleBg} shadow text-xs leading-relaxed break-words font-medium">
                                    ${escapeWidgetHtml(msg.message)}
                                    ${optionsHtml}
                                </div>
                                <div class="text-[9px] text-gray-500 mt-0.5 ${!msg.isBot ? 'text-right' : 'text-left'}">${timeStr}</div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', msgHtml);
                }

                function showTypingIndicator() {
                    const container = document.getElementById('widget-messages-container');
                    const indicatorHtml = `
                        <div id="bot-typing-indicator" class="flex justify-start w-full my-1">
                            <div class="max-w-[80%]">
                                <div class="px-3 py-2.5 rounded-xl rounded-bl-none bg-white/5 border border-white/10 text-gray-200 shadow text-xs flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 0ms"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 150ms"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-bounce" style="animation-delay: 300ms"></span>
                                </div>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', indicatorHtml);
                    container.scrollTop = container.scrollHeight;
                }

                function removeTypingIndicator() {
                    const el = document.getElementById('bot-typing-indicator');
                    if (el) el.remove();
                }

                function handleBotOption(option) {
                    document.querySelectorAll('.chatbot-options-list').forEach(list => {
                        list.classList.add('pointer-events-none', 'opacity-50');
                    });

                    let userMsgText = "";
                    let botReplyText = "";
                    let showMenuAfter = true;

                    switch (option) {
                        case 'books':
                            userMsgText = "Comment rechercher ou trouver un livre ?";
                            botReplyText = "📚 **Recherche & Disponibilité des Livres**\n\n1. Allez dans l'onglet **Livres** du menu principal.\n2. Saisissez votre recherche (titre, auteur, genre) dans la barre de recherche instantanée.\n3. **Indicateur de Stock** : Si un livre affiche **0 exemplaire restant**, un bouton bleu **'Infos Prêt'** apparaît. Cliquez dessus pour voir la date de retour prévue.";
                            break;
                        case 'loans':
                            userMsgText = "Quelles sont les règles d'emprunt ?";
                            botReplyText = "⏱️ **Règles et Durées d'Emprunts**\n\n• **Durée standard** : Un emprunt dure **14 jours**.\n• **Demande** : Cliquez sur le bouton 'Emprunter' sur la fiche du livre. L'administrateur reçoit votre demande.\n• **Validation** : Dès que l'administrateur accepte ou refuse, un badge de notification s'incrémente en haut à droite, et un 'toast' de confirmation apparaît.";
                            break;
                        case 'profile':
                            userMsgText = "Comment gérer mon profil ?";
                            botReplyText = "👤 **Gestion de votre Compte**\n\n• Pour mettre à jour vos informations, allez dans l'onglet **Mon Profil**.\n• Vous pouvez y téléverser une photo de profil personnalisée (elle est hébergée sur **Cloudinary**).\n• Vous pouvez également modifier votre mot de passe en toute sécurité depuis cet écran.";
                            break;
                        case 'alerts':
                            userMsgText = "Comment fonctionnent les alertes ?";
                            botReplyText = "🔔 **Notifications en Temps Réel**\n\n• **Cloche en haut à droite** : Elle affiche le nombre de notifications d'emprunts non lues.\n• **Toasts** : Des alertes de succès ou d'erreur glissent depuis le côté droit de l'écran en temps réel (propulsées par WebSockets).\n• **Badge de Chat** : Un point rouge s'affiche à côté de 'Support Chat' ou sur le widget flottant dès que l'administrateur vous envoie un message.";
                            break;
                        case 'human':
                            userMsgText = "Je souhaite parler à un administrateur.";
                            botReplyText = "💬 **Assistance Administrative**\n\nPour envoyer un message direct à l'administrateur, écrivez simplement votre question dans la zone de texte ci-dessous.\n\nVotre message sera enregistré dans sa console d'administration et il pourra prendre le relais en vous répondant directement sur la page **Support Chat**.";
                            showMenuAfter = false;
                            break;
                    }

                    const userMsg = {
                        id: 'msg-' + Date.now(),
                        isBot: false,
                        message: userMsgText,
                        time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                    };
                    botHistory.push(userMsg);
                    appendBotMessageHtml(userMsg);
                    saveBotHistory();

                    showTypingIndicator();
                    setTimeout(() => {
                        removeTypingIndicator();

                        const botReply = {
                            id: 'msg-' + (Date.now() + 1),
                            isBot: true,
                            message: botReplyText,
                            showOptions: showMenuAfter,
                            time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                        };
                        botHistory.push(botReply);
                        appendBotMessageHtml(botReply);
                        saveBotHistory();

                        const container = document.getElementById('widget-messages-container');
                        container.scrollTop = container.scrollHeight;
                    }, 800);
                }

                async function handleWidgetSendMessage(e) {
                    e.preventDefault();
                    const input = document.getElementById('widget-message-input');
                    const text = input.value.trim();
                    if (!text) return;
                    input.value = '';

                    const userMsg = {
                        id: 'msg-' + Date.now(),
                        isBot: false,
                        message: text,
                        time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                    };
                    botHistory.push(userMsg);
                    appendBotMessageHtml(userMsg);
                    saveBotHistory();

                    showTypingIndicator();

                    let matchedReply = "";
                    const lowerText = text.toLowerCase();
                    let showMenuAfter = true;

                    if (lowerText.includes('livre') || lowerText.includes('chercher') || lowerText.includes('trouver') || lowerText.includes('dispo') || lowerText.includes('stock')) {
                        matchedReply = "📚 **Recherche & Disponibilité des Livres**\n\n1. Allez dans l'onglet **Livres** du menu principal.\n2. Saisissez votre recherche (titre, auteur, genre) dans la barre de recherche instantanée.\n3. **Indicateur de Stock** : Si un livre affiche **0 exemplaire restant**, un bouton bleu **'Infos Prêt'** apparaît. Cliquez dessus pour voir la date de retour prévue.";
                    } else if (lowerText.includes('emprunt') || lowerText.includes('loan') || lowerText.includes('rendre') || lowerText.includes('retour') || lowerText.includes('durée')) {
                        matchedReply = "⏱️ **Règles et Durées d'Emprunts**\n\n• **Durée standard** : Un emprunt dure **14 jours**.\n• **Demande** : Cliquez sur le bouton 'Emprunter' sur la fiche du livre. L'administrateur reçoit votre demande.";
                    } else if (lowerText.includes('profil') || lowerText.includes('avatar') || lowerText.includes('photo') || lowerText.includes('modifier') || lowerText.includes('mot de passe')) {
                        matchedReply = "👤 **Gestion de votre Compte**\n\n• Pour mettre à jour vos informations, allez dans l'onglet **Mon Profil**.\n• Vous pouvez y téléverser une photo de profil personnalisée (Cloudinary) et modifier votre mot de passe.";
                    } else if (lowerText.includes('notif') || lowerText.includes('alerte') || lowerText.includes('cloche')) {
                        matchedReply = "🔔 **Notifications en Temps Réel**\n\n• **Cloche en haut à droite** : Affiche les notifications d'emprunts non lues.\n• **Toasts** : Des alertes de succès ou d'erreur s'affichent en haut à droite de votre écran lors d'actions système.";
                    } else {
                        try {
                            const res = await fetch('/chat/send', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': 'qIswqqkIDfbHg9guMvKruzxXN1oMF2RPeBAsuCgC'
                                },
                                body: JSON.stringify({
                                    receiver_id: adminId,
                                    message: text
                                })
                            });
                        } catch (e) {
                            console.error(e);
                        }

                        matchedReply = "🤖 **BiblioTech AI Assistant**\n\nVotre message a bien été transmis en direct à l'administrateur ! Il pourra vous répondre directement.\n\nEn attendant, vous pouvez naviguer avec le menu ci-dessous.";
                    }

                    setTimeout(() => {
                        removeTypingIndicator();

                        const botReply = {
                            id: 'msg-' + (Date.now() + 1),
                            isBot: true,
                            message: matchedReply,
                            showOptions: showMenuAfter,
                            time: new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })
                        };
                        botHistory.push(botReply);
                        appendBotMessageHtml(botReply);
                        saveBotHistory();

                        const container = document.getElementById('widget-messages-container');
                        container.scrollTop = container.scrollHeight;
                    }, 1000);
                }

                function escapeWidgetHtml(text) {
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

