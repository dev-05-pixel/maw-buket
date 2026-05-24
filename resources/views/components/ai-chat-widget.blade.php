{{-- GLOBAL AI CHAT WIDGET --}}

<div id="ai-chat-wrapper" class="fixed bottom-6 right-6 z-50">

    {{-- CHAT BOX --}}
    <div id="ai-chat-box"
        class="hidden w-[360px] h-[500px]
               bg-white border border-cream-d
               rounded-3xl
               shadow-[0_20px_60px_rgba(0,0,0,0.15)]
               backdrop-blur-xl
               flex flex-col overflow-hidden">

        {{-- HEADER --}}
        <div
            class="flex items-center justify-between px-4 py-3 border-b border-cream-d bg-gradient-to-r from-cream to-white">

            <div class="flex items-center gap-3">

                {{-- Avatar --}}
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-rose to-rose-d flex items-center justify-center shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10h8M8 14h5m-9 6l2.5-2.5A9 9 0 1112 21a8.96 8.96 0 01-4.5-1.2L3 20z" />
                    </svg>
                </div>

                {{-- Title --}}
                <div>
                    <p class="text-sm font-semibold text-brown">
                        Maw AI Assistant
                    </p>

                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>

                        <p class="text-[10px] text-muted">
                            Online Support
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2">

                <button onclick="AiChat.toggle()"
                    class="w-8 h-8 rounded-full hover:bg-cream flex items-center justify-center text-muted hover:text-brown transition">

                    —
                </button>

                <button onclick="AiChat.close()"
                    class="w-8 h-8 rounded-full hover:bg-red-50 flex items-center justify-center text-muted hover:text-red-500 transition">

                    ✕
                </button>
            </div>
        </div>

        {{-- MESSAGES --}}
        <div id="chat-messages"
            class="flex-1 p-4 space-y-4 overflow-y-auto text-sm bg-gradient-to-b from-white to-cream/20">

            {{-- Default BOT Message --}}
            <div class="msg-row">

                <div class="msg-label">
                    BOT
                </div>

                <div
                    class="bg-gradient-to-br from-cream to-white
                           text-brown-m
                           p-3 rounded-2xl
                           shadow-sm
                           border border-cream-d
                           w-fit max-w-[85%]">

                    Halo 👋, saya Maw AI Assistant.
                    Ada yang bisa dibantu hari ini?
                </div>
            </div>

        </div>

        {{-- INPUT --}}
        <div class="p-3 border-t border-cream-d bg-white">

            <div class="flex items-center gap-2">

                <input id="chat-input" type="text" placeholder="Tulis pesan..."
                    class="flex-1 px-4 py-3 text-sm
                           bg-cream/40
                           border border-cream-d
                           rounded-2xl
                           focus:outline-none
                           focus:ring-2
                           focus:ring-rose/20
                           focus:border-rose
                           transition">

                <button onclick="AiChat.send()"
                    class="w-12 h-12
                           flex items-center justify-center
                           bg-gradient-to-r from-rose to-rose-d
                           text-white
                           rounded-2xl
                           hover:scale-105
                           transition
                           shadow-md">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 5l7 7-7 7" />
                    </svg>

                </button>

            </div>
        </div>
    </div>

    {{-- FLOAT BUTTON --}}
    <button id="chat-open-btn" onclick="AiChat.open()"
        class="group relative flex items-center gap-3 px-5 h-14
               bg-gradient-to-r from-rose to-rose-d
               text-white rounded-full shadow-xl
               transition-all duration-300
               hover:scale-105 hover:shadow-2xl
               before:absolute before:inset-0
               before:rounded-full before:bg-rose/30
               before:blur-xl before:-z-10">

        {{-- Icon --}}
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-white/15">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 transition-transform duration-300 group-hover:rotate-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 10h8M8 14h5m-9 6l2.5-2.5A9 9 0 1112 21a8.96 8.96 0 01-4.5-1.2L3 20z" />
            </svg>
        </div>

        {{-- Text --}}
        <div class="text-left leading-tight">
            <p class="text-sm font-semibold">
                ChatBot AI
            </p>

            <p class="text-[10px] text-white/80">
                Online Support
            </p>
        </div>

    </button>

</div>

{{-- ================= STYLE ================= --}}
<style>
    .typing {
        display: flex;
        gap: 4px;
        align-items: center;
    }

    .typing span {
        width: 6px;
        height: 6px;
        background: #9E8E84;
        border-radius: 9999px;
        animation: blink 1.4s infinite both;
    }

    .typing span:nth-child(2) {
        animation-delay: .2s;
    }

    .typing span:nth-child(3) {
        animation-delay: .4s;
    }

    @keyframes blink {
        0% {
            opacity: .2;
            transform: translateY(0);
        }

        50% {
            opacity: 1;
            transform: translateY(-3px);
        }

        100% {
            opacity: .2;
            transform: translateY(0);
        }
    }

    .msg-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .msg-label {
        font-size: 10px;
        color: #9E8E84;
        margin-left: 6px;
        font-weight: 600;
    }

    /* ================= STYLE ================= */
    /* AI Chat Widget Responsif */
    #ai-chat-wrapper {
        position: fixed;
        bottom: 80px;
        /* jarak dari bawah default */
        right: 16px;
        z-index: 9999;
    }

    /* Layar 375px */
    @media (max-width: 375px) {
        #ai-chat-wrapper {
            bottom: 80px;
            /* naikkan agar tidak ketutup header/footer */
            right: 12px;
            max-width: 90%;
        }

        #ai-chat-box {
            width: 300px;
            /* proporsional */
            height: 460px;
            border-radius: 1.5rem;
            /* tetap bulat tapi tidak terlalu besar */
        }

        #chat-open-btn {
            height: 52px;
            padding: 0 14px;
            border-radius: 1.5rem;
            gap: 8px;
        }
    }

    /* Layar 320px */
    @media (max-width: 320px) {
        #ai-chat-wrapper {
            bottom: 90px;
            /* lebih tinggi agar tidak terpotong */
            right: 8px;
            max-width: 95%;
        }

        #ai-chat-box {
            width: 260px;
            /* lebih kecil dari 375px */
            height: 420px;
            /* lebih pendek */
            border-radius: 1.25rem;
        }

        #chat-open-btn {
            height: 48px;
            width: auto;
            padding: 0 12px;
            border-radius: 1.25rem;
            gap: 6px;
        }
    }
</style>

{{-- ================= JS ================= --}}
<script>
console.log("AI CHAT JS LOADED");
const AI_FLASK_URL = @json(env('AI_FLASK_URL'));

const AiChat = {

    box: null,
    button: null,
    input: null,
    messages: null,
    loading: false,

    init() {
        if (this.box) return;

        this.box = document.getElementById('ai-chat-box');
        this.button = document.getElementById('chat-open-btn');
        this.input = document.getElementById('chat-input');
        this.messages = document.getElementById('chat-messages');

        this.input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') this.send();
        });
    },

    open() {
        this.init();
        this.box.classList.remove('hidden');
        this.box.classList.add('flex');
        this.button.classList.add('hidden');
        this.input.focus();
    },

    close() {
        this.init();
        this.box.classList.add('hidden');
        this.box.classList.remove('flex');
        this.button.classList.remove('hidden');
    },

    toggle() {
        this.box.classList.contains('hidden')
            ? this.open()
            : this.close();
    },

    async send() {

        const text = this.input.value.trim();
        if (!text || this.loading) return;

        this.addMessage(text, 'user');
        this.input.value = '';
        this.showTyping();
        this.loading = true;

        try {

            const res = await fetch(`${AI_FLASK_URL}/chat`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ message: text })
            });

            const raw = await res.text();
            console.log("RAW VPS RESPONSE:", raw);

            const data = await res.json();

            this.removeTyping();

            // ❌ SERVER ERROR
            if (!res.ok) {
                this.addMessage(`
                    <div class="space-y-2">
                        <p>Server AI sedang bermasalah 😢</p>
                        <p class="text-xs text-muted">Coba beberapa saat lagi</p>
                    </div>
                `, 'bot', true);

                this.loading = false;
                return;
            }

            // ⚠️ FALLBACK WHATSAPP (FIX DARI FLASK)
            if (data.fallback === true) {

                this.addMessage(`
                    <div class="space-y-3">

                        <div>
                            <p class="font-medium text-brown">
                                ${data.reply}
                            </p>

                            <p class="text-xs text-muted mt-1">
                                Jawaban tidak ditemukan, silakan hubungi admin.
                            </p>
                        </div>

                        <a href="${data.whatsapp_url}"
                           target="_blank"
                           class="
                                inline-flex items-center gap-2
                                px-4 py-2
                                rounded-xl
                                bg-green-500
                                hover:bg-green-600
                                text-white
                                text-sm
                                font-medium
                           ">
                            📱 Hubungi WhatsApp
                        </a>

                    </div>
                `, 'bot', true);

                this.loading = false;
                return;
            }

            // ✅ NORMAL RESPONSE
            this.addMessage(data.reply || "Tidak ada jawaban.", 'bot');

        } catch (err) {

            console.error(err);

            this.removeTyping();

            this.addMessage(`
                <div class="space-y-2">
                    <p>Tidak dapat terhubung ke server AI 😢</p>
                    <p class="text-xs text-muted">Cek koneksi Flask</p>
                </div>
            `, 'bot', true);

        } finally {
            this.loading = false;
        }
    },

    addMessage(text, type, isHtml = false) {

        const wrapper = document.createElement('div');
        wrapper.className = "msg-row";

        const label = document.createElement('div');
        label.className = "msg-label";
        label.textContent = type === 'bot' ? 'BOT' : 'YOU';

        const msg = document.createElement('div');

        const userClass = `
            bg-gradient-to-r from-rose to-rose-d
            text-white p-3 rounded-2xl ml-auto
            w-fit max-w-[85%]
        `;

        const botClass = `
            bg-gradient-to-br from-cream to-white
            text-brown-m p-3 rounded-2xl
            border border-cream-d
            w-fit max-w-[85%]
        `;

        msg.className = type === 'user' ? userClass : botClass;

        isHtml ? msg.innerHTML = text : msg.textContent = text;

        wrapper.appendChild(label);
        wrapper.appendChild(msg);
        this.messages.appendChild(wrapper);

        this.messages.scrollTop = this.messages.scrollHeight;
    },

    showTyping() {

        const typing = document.createElement('div');
        typing.id = "typing-indicator";
        typing.className = `
            bg-gradient-to-br from-cream to-white
            p-3 rounded-2xl border border-cream-d
        `;

        typing.innerHTML = `
            <div class="typing">
                <span></span><span></span><span></span>
            </div>
        `;

        this.messages.appendChild(typing);
        this.messages.scrollTop = this.messages.scrollHeight;
    },

    removeTyping() {
        const t = document.getElementById("typing-indicator");
        if (t) t.remove();
    }
};

document.addEventListener('DOMContentLoaded', () => AiChat.init());
</script>
