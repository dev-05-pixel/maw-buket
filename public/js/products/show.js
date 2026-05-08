// ================================================================
// DESCRIPTION TOGGLE
// ================================================================

const descToggle = document.getElementById("desc-toggle");
const descBox = document.getElementById("product-desc");

if (descToggle && descBox) {
    descToggle.addEventListener("click", () => {
        descBox.classList.toggle("collapsed");

        if (descBox.classList.contains("collapsed")) {
            descToggle.textContent = "Lihat Selengkapnya";
        } else {
            descToggle.textContent = "Tampilkan Lebih Sedikit";
        }
    });
}
// ================================================================
//  GALLERY SWITCHING
// ================================================================
const waBtn = document.getElementById("wa-order");

waBtn.addEventListener("click", function () {
    let productName = "{{ $product->name }}";
    let price = "Rp {{ number_format($product->price, 0, ',', '.') }}";
    let productLink = window.location.href;

    let size = document.querySelector(".size-btn.active")?.innerText || "-";
    let color = document.querySelector(".color-opt.active")?.title || "-";

    const greetings = ["Halo Maw Bouquet,", "Permisi kak,"];

    const openings = [
        "Saya tertarik dengan salah satu produk ini.",
        "Saya menemukan produk berikut dan tertarik untuk memesannya.",
        "Saya ingin menanyakan ketersediaan produk berikut:",
        "Saya tertarik dengan produk ini:",
    ];

    const closings = [
        "Apakah buket ini masih tersedia untuk dipesan?",
        "Apakah produk ini masih available?",
        "Boleh dibantu informasi ketersediaannya?",
        "Apakah buket ini bisa dipesan untuk hari ini?",
    ];

    let greeting = greetings[Math.floor(Math.random() * greetings.length)];
    let opening = openings[Math.floor(Math.random() * openings.length)];
    let closing = closings[Math.floor(Math.random() * closings.length)];

    let message =
        greeting +
        "\n\n" +
        opening +
        "\n\n" +
        "*Detail Produk*\n" +
        "Produk : " +
        productName +
        "\n" +
        "Harga  : " +
        price +
        "\n" +
        "Ukuran : " +
        size +
        "\n" +
        "Warna  : " +
        color +
        "\n\n" +
        "Link produk:\n" +
        productLink +
        "\n\n" +
        closing +
        "\nTerima kasih.";

    let url = "https://wa.me/6282333000472?text=" + encodeURIComponent(message);

    this.href = url;
});

const colorBtns = document.querySelectorAll(".color-opt");
const colorLabel = document.getElementById("selected-color");

colorBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        colorBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        colorLabel.textContent = btn.title;
    });
});

const sizeButtons = document.querySelectorAll(".size-btn");
const sizeLabel = document.getElementById("selected-size");

sizeButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
        sizeButtons.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        sizeLabel.textContent = btn.textContent.trim();
    });
});
const mainImg = document.getElementById("gallery-main");
const thumbs = document.querySelectorAll(".gallery-thumb");
const dots = document.querySelectorAll(".gallery-nav-dot");

function switchImage(index, src) {
    mainImg.classList.add("switching");
    setTimeout(() => {
        mainImg.src = src;
        mainImg.classList.remove("switching");
    }, 350);

    thumbs.forEach((t, i) => {
        t.classList.toggle("active", i === index);
    });
    dots.forEach((d, i) => {
        d.classList.toggle("active", i === index);
    });
}

thumbs.forEach((thumb, index) => {
    thumb.addEventListener("click", () => {
        switchImage(index, thumb.dataset.full);
    });
});

dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
        const correspondingThumb = thumbs[index];
        if (correspondingThumb) {
            switchImage(index, correspondingThumb.dataset.full);
        }
    });
});

// ================================================================
//  SIZE BUTTONS
// ================================================================
document.querySelectorAll(".size-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        document.querySelectorAll(".size-btn").forEach((b) => {
            b.classList.remove("active");
            b.setAttribute("aria-pressed", "false");
        });
        this.classList.add("active");
        this.setAttribute("aria-pressed", "true");
    });
});

// ================================================================
//  COLOR OPTIONS
// ================================================================
document.querySelectorAll(".color-opt").forEach((opt) => {
    opt.addEventListener("click", function () {
        document.querySelectorAll(".color-opt").forEach((o) => {
            o.classList.remove("active");
            o.setAttribute("aria-pressed", "false");
        });
        this.classList.add("active");
        this.setAttribute("aria-pressed", "true");
    });
});

// ================================================================
//  ACCORDION
// ================================================================
document.querySelectorAll(".accordion-trigger").forEach((trigger) => {
    trigger.addEventListener("click", function () {
        const isOpen = this.getAttribute("aria-expanded") === "true";
        const contentId = this.getAttribute("aria-controls");
        const content = document.getElementById(contentId);

        // Close all
        document.querySelectorAll(".accordion-trigger").forEach((t) => {
            t.setAttribute("aria-expanded", "false");
        });
        document.querySelectorAll(".accordion-content").forEach((c) => {
            c.classList.remove("open");
        });

        // Open clicked (if was closed)
        if (!isOpen) {
            this.setAttribute("aria-expanded", "true");
            content.classList.add("open");
        }
    });
});

// ================================================================
//  SHARE BUTTON
// ================================================================
document.getElementById("share-btn").addEventListener("click", async () => {
    if (navigator.share) {
        try {
            await navigator.share({
                title: document.title,
                url: window.location.href,
            });
        } catch (e) {}
    } else {
        navigator.clipboard.writeText(window.location.href);
        // Toast
        const toast = document.createElement("div");
        toast.textContent = "Link disalin!";
        toast.style.cssText = `
            position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%);
            background: var(--charcoal); color: var(--cream); padding: 12px 24px;
            border-radius: 4px; font-size: 13px; z-index: 9999; font-family: var(--font-body);
            animation: fadeUpIn 0.4s ease forwards;
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2200);
    }
});
