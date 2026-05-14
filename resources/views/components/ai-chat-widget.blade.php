{{-- GLOBAL AI CHAT WIDGET --}}

<div id="ai-chat-wrapper" class="fixed bottom-6 right-6 z-50">

    {{-- CHAT BOX (BISA DIUBAH UKURANNYA DI SINI) --}}
    <div id="ai-chat-box"
        class="hidden w-[360px] h-[500px] bg-white border border-cream-d rounded-2xl shadow-xl flex flex-col overflow-hidden">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-cream-d bg-cream/40">
            <div>
                <p class="text-sm font-semibold text-brown">AI Assistant</p>
                <p class="text-[10px] text-muted">Support System</p>
            </div>

            <div class="flex items-center gap-2 text-sm">
                <button onclick="AiChat.toggle()" class="text-muted hover:text-brown">—</button>
                <button onclick="AiChat.close()" class="text-muted hover:text-red-500">✕</button>
            </div>
        </div>

        {{-- MESSAGES --}}
        <div id="chat-messages" class="flex-1 p-3 space-y-3 overflow-y-auto text-sm bg-white">

            <div class="bg-cream/60 text-brown-m p-2 rounded-xl w-fit max-w-[85%]">
                Halo 👋, saya AI assistant. Ada yang bisa dibantu?
            </div>

        </div>

        {{-- INPUT --}}
        <div class="p-3 border-t border-cream-d flex gap-2">
            <input id="chat-input" type="text" placeholder="Tulis pesan..."
                class="flex-1 px-3 py-2 text-sm border border-cream-d rounded-xl focus:outline-none focus:ring-2 focus:ring-rose/30">

            <button onclick="AiChat.send()" class="bg-rose text-white px-3 rounded-xl hover:bg-rose-d text-sm">
                ➤
            </button>
        </div>

    </div>

    {{-- FLOAT BUTTON --}}
    <button id="chat-open-btn" onclick="AiChat.open()"
        class="w-14 h-14 bg-rose text-white rounded-full shadow-lg flex items-center justify-center hover:bg-rose-d transition">
        💬
    </button>

</div>

{{-- ================= STYLE ANIMASI ================= --}}
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
    border-radius: 50%;
    animation: blink 1.4s infinite both;
}

.typing span:nth-child(2) { animation-delay: .2s; }
.typing span:nth-child(3) { animation-delay: .4s; }

@keyframes blink {
    0% { opacity: .2; transform: translateY(0); }
    50% { opacity: 1; transform: translateY(-3px); }
    100% { opacity: .2; transform: translateY(0); }
}

.msg-row {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.msg-label {
    font-size: 9px;
    color: #9E8E84;
    margin-left: 4px;
}
</style>

{{-- ================= JS ================= --}}
<script>
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
        this.init();
        this.box.classList.contains('hidden') ? this.open() : this.close();
    },

    async send() {
        this.init();

        const text = this.input.value.trim();
        if (!text || this.loading) return;

        this.addMessage(text, 'user');
        this.input.value = '';

        this.showTyping();
        this.loading = true;

        try {
            const res = await fetch("http://127.0.0.1:5000/chat", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ message: text })
            });

            const data = await res.json();

            this.removeTyping();

            this.addMessage(data.reply ?? "Tidak ada jawaban", 'bot');

        } catch (err) {
            this.removeTyping();
            this.addMessage("Server error", "bot");
        }

        this.loading = false;
    },

    addMessage(text, type) {
        const wrapper = document.createElement('div');
        wrapper.className = "msg-row";

        const label = document.createElement('div');
        label.className = "msg-label";
        label.textContent = type === 'bot' ? 'BOT' : 'YOU';

        const msg = document.createElement('div');

        msg.className = type === 'user'
            ? "bg-rose text-white p-2 rounded-xl ml-auto w-fit max-w-[85%]"
            : "bg-cream/60 text-brown-m p-2 rounded-xl w-fit max-w-[85%]";

        msg.textContent = text;

        wrapper.appendChild(label);
        wrapper.appendChild(msg);

        this.messages.appendChild(wrapper);
        this.messages.scrollTop = this.messages.scrollHeight;
    },

    showTyping() {
        const typing = document.createElement('div');
        typing.id = "typing-indicator";
        typing.className = "bg-cream/60 p-3 rounded-xl w-fit max-w-[85%]";

        typing.innerHTML = `
            <div class="typing">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `;

        this.messages.appendChild(typing);
        this.messages.scrollTop = this.messages.scrollHeight;
    },

    removeTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) typing.remove();
    }
};
</script>