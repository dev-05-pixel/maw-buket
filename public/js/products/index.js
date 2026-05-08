// ================================================================
// WHATSAPP ORDER MESSAGE (VARIATIVE)
// ================================================================

document.querySelectorAll(".wa-order").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        let name = this.dataset.name;
        let price = this.dataset.price;
        let link = this.dataset.url;

        const messages = [
            `Halo Maw Bouquet, saya tertarik dengan produk ${name} dengan harga Rp ${price} ini. Apakah produk ini masih tersedia untuk dipesan? Berikut link produknya: ${link}`,

            `Halo kak, saya menemukan produk ${name} di website Maw Bouquet dengan harga Rp ${price} dan tertarik untuk memesannya. Apakah produk ini masih tersedia? Berikut link produk yang saya lihat: ${link}`,

            `Permisi kak, saya tertarik dengan ${name} dengan harga Rp ${price} yang ada di website. Apakah buket ini masih bisa dipesan? Berikut link produknya: ${link}`,

            `Halo Maw Bouquet, saya melihat produk ${name} dengan harga Rp ${price} di website dan tertarik untuk memesannya. Boleh dibantu informasi apakah produk ini masih tersedia? Link produk: ${link}`,
        ];

        let message = messages[Math.floor(Math.random() * messages.length)];

        let phone = "6282333000472";

        let url =
            "https://wa.me/" + phone + "?text=" + encodeURIComponent(message);

        window.open(url, "_blank");
    });
});

// ================================================================
//  FILTER TABS (client-side demo)
// ================================================================
document.querySelectorAll(".filter-tab").forEach((tab) => {
    tab.addEventListener("click", function () {
        document.querySelectorAll(".filter-tab").forEach((t) => {
            t.classList.remove("active");
            t.setAttribute("aria-selected", "false");
        });
        this.classList.add("active");
        this.setAttribute("aria-selected", "true");

        const filter = this.dataset.filter;
        if (filter !== "Semua") {
            const tag = document.createElement("button");
            tag.className = "active-filter-tag";
            tag.innerHTML = `${filter} <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;
            document.getElementById("active-filters").innerHTML = "";
            document.getElementById("active-filters").appendChild(tag);
            tag.addEventListener("click", () => {
                document.getElementById("active-filters").innerHTML = "";
                document.querySelector('[data-filter="Semua"]').click();
            });
        } else {
            document.getElementById("active-filters").innerHTML = "";
        }
    });
});

// ================================================================
//  VIEW TOGGLE
// ================================================================
const gridBtn = document.getElementById("grid-view-btn");
const listBtn = document.getElementById("list-view-btn");
const listing = document.getElementById("products-listing");

gridBtn.addEventListener("click", () => {
    listing.classList.remove("view-list");
    gridBtn.classList.add("active");
    listBtn.classList.remove("active");
    gridBtn.setAttribute("aria-pressed", "true");
    listBtn.setAttribute("aria-pressed", "false");
});

listBtn.addEventListener("click", () => {
    listing.classList.add("view-list");
    listBtn.classList.add("active");
    gridBtn.classList.remove("active");
    listBtn.setAttribute("aria-pressed", "true");
    gridBtn.setAttribute("aria-pressed", "false");
});

// ================================================================
//  SCROLL REVEAL (re-trigger for new elements)
// ================================================================
const newReveals = document.querySelectorAll(".products-area .reveal");
const revealObs = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("in-view");
                revealObs.unobserve(entry.target);
            }
        });
    },
    {
        threshold: 0.08,
        rootMargin: "0px 0px -20px 0px",
    },
);
newReveals.forEach((el) => revealObs.observe(el));

// ================================================================
//  COLOR SWATCHES
// ================================================================
document.querySelectorAll(".color-swatch").forEach((swatch) => {
    swatch.addEventListener("click", function () {
        this.classList.toggle("active");
    });
});

const minInput = document.getElementById("priceMin");
const maxInput = document.getElementById("priceMax");

minInput.addEventListener("input", () => {
    let min = parseInt(minInput.value) || 0;
    let max = parseInt(maxInput.value) || 0;

    if (min > max) {
        maxInput.value = min;
    }
});

maxInput.addEventListener("input", () => {
    let min = parseInt(minInput.value) || 0;
    let max = parseInt(maxInput.value) || 0;

    if (max < min) {
        minInput.value = max;
    }
});

// ================================================================
// SEARCH ICON ANIMATION
// ================================================================

const searchWrap = document.querySelector(".catalog-search-wrap");
const searchInput = searchWrap.querySelector("input");

searchInput.addEventListener("focus", () => {
    searchWrap.classList.add("active");
});

searchInput.addEventListener("blur", () => {
    if (searchInput.value.trim() === "") {
        searchWrap.classList.remove("active");
    }
});
