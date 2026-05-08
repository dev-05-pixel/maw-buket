// ================================================================
//  WHATSAPP ORDER
// ================================================================
document.querySelectorAll(".wa-order").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        const name = this.dataset.name;
        const price = this.dataset.price;
        const link = this.dataset.url;

        const messages = [
            `Halo Maw Bouquet, saya tertarik dengan produk *${name}* (Rp ${price}) yang direkomendasikan AI. Apakah masih tersedia?\n\nLink produk: ${link}`,
            `Permisi kak! AI Maw Bouquet merekomendasikan *${name}* dengan harga Rp ${price} sesuai kebutuhan saya. Apakah masih bisa dipesan?\n\n${link}`,
            `Halo kak, saya baru menggunakan fitur AI Rekomendasi dan mendapatkan saran produk *${name}* (Rp ${price}). Boleh dibantu untuk pemesanan?\n\nLink: ${link}`,
        ];

        const msg = messages[Math.floor(Math.random() * messages.length)];
        const url =
            "https://wa.me/6282333000472?text=" + encodeURIComponent(msg);
        window.open(url, "_blank");
    });
});

// ================================================================
//  VIEW TOGGLE (Grid / List)
// ================================================================
const gridBtn = document.getElementById("grid-btn");
const listBtn = document.getElementById("list-btn");
const grid = document.getElementById("result-grid");

if (gridBtn && listBtn && grid) {
    gridBtn.addEventListener("click", () => {
        grid.classList.remove("view-list");
        gridBtn.classList.add("active");
        listBtn.classList.remove("active");
        gridBtn.setAttribute("aria-pressed", "true");
        listBtn.setAttribute("aria-pressed", "false");
    });

    listBtn.addEventListener("click", () => {
        grid.classList.add("view-list");
        listBtn.classList.add("active");
        gridBtn.classList.remove("active");
        listBtn.setAttribute("aria-pressed", "true");
        gridBtn.setAttribute("aria-pressed", "false");
    });
}

// ================================================================
//  ANIMATE SCORE BARS ON LOAD
// ================================================================
const scoreBars = document.querySelectorAll(".score-bar-fill");
scoreBars.forEach((bar) => {
    const target = bar.style.width;
    bar.style.width = "0%";
    setTimeout(() => {
        bar.style.width = target;
    }, 300);
});

// ================================================================
//  SCROLL REVEAL
// ================================================================
const revealEls = document.querySelectorAll(".reveal");
const obs = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("in-view");
                obs.unobserve(entry.target);
            }
        });
    },
    {
        threshold: 0.08,
        rootMargin: "0px 0px -20px 0px",
    },
);
revealEls.forEach((el) => obs.observe(el));
