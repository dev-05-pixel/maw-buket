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
// WHATSAPP ORDER
// ================================================================

const waBtn = document.getElementById("wa-order");
const productPrice = document.getElementById("product-price");

function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID").format(number);
}

const sizeButtons = document.querySelectorAll(".size-btn");
const colorButtons = document.querySelectorAll(".color-tag-detail");

const selectedSizeText = document.getElementById("selected-size");
const selectedColorText = document.getElementById("selected-color");

let selectedVariant = waBtn.dataset.variant;
let selectedPrice = waBtn.dataset.price;
let selectedColor = waBtn.dataset.color;

// ================================================================
// VARIANT SELECT
// ================================================================

sizeButtons.forEach((button) => {
    button.addEventListener("click", () => {
        sizeButtons.forEach((btn) => {
            btn.classList.remove("active");
            btn.setAttribute("aria-pressed", "false");
        });

        button.classList.add("active");
        button.setAttribute("aria-pressed", "true");

        selectedVariant = button.dataset.variant;
        selectedPrice = button.dataset.price;

        if (selectedSizeText) {
            selectedSizeText.textContent = selectedVariant;
        }

        if (productPrice) {
            productPrice.textContent = "Rp " + formatRupiah(selectedPrice);
        }

        waBtn.dataset.variant = selectedVariant;
        waBtn.dataset.price = selectedPrice;
    });
});

// ================================================================
// COLOR SELECT
// ================================================================

colorButtons.forEach((button) => {
    button.addEventListener("click", () => {
        colorButtons.forEach((btn) => {
            btn.classList.remove("active");
        });

        button.classList.add("active");

        selectedColor = button.dataset.color;

        if (selectedColorText) {
            selectedColorText.textContent = selectedColor;
        }

        waBtn.dataset.color = selectedColor;
    });
});

// order whatsapp
if (waBtn) {
    waBtn.addEventListener("click", async function (e) {
        e.preventDefault();
        const productId = this.dataset.id;
        const productPrice = parseInt(this.dataset.price) || 0;

        if (productPrice <= 0) {
            alert("Harga produk belum tersedia.");
            return;
        }

        const variant =
            document.querySelector(".size-btn.active")?.dataset.variant || "-";

        const color =
            document.querySelector(".color-tag-detail.active")?.dataset.color ||
            "-";

        try {
            const response = await fetch("/orders/store", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },

                body: JSON.stringify({
                    product_id: productId,
                    price: productPrice,
                    variant: variant,
                    color: color,
                }),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                window.open(result.wa_url, "_blank");
            } else {
                alert(result.message || "Gagal membuat pesanan.");
            }
        } catch (error) {
            console.error(error);

            alert("Terjadi kesalahan saat membuat pesanan.");
        }
    });
}

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
