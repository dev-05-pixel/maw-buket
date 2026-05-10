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

if (waBtn) {
    waBtn.addEventListener("click", async function (e) {
        e.preventDefault();

        const productId = this.dataset.id;

        const size =
            document.querySelector(".size-btn.active")?.dataset.size || "-";

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
                    size: size,
                    color: color,
                }),
            });

            const result = await response.json();

            console.log(result);

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

/* =========================================
   COLOR TAG SELECT
========================================= */
const colorTags = document.querySelectorAll(".color-tag-detail");
const selectedColor = document.getElementById("selected-color");

colorTags.forEach((tag) => {
    tag.addEventListener("click", () => {
        colorTags.forEach((t) => t.classList.remove("active"));

        tag.classList.add("active");

        if (selectedColor) {
            selectedColor.textContent = tag.dataset.color;
        }
    });
});

/* =========================================
   SIZE SELECT
========================================= */
const sizeButtons = document.querySelectorAll(".size-btn");
const selectedSize = document.getElementById("selected-size");

sizeButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
        sizeButtons.forEach((b) => {
            b.classList.remove("active");
            b.setAttribute("aria-pressed", "false");
        });

        btn.classList.add("active");
        btn.setAttribute("aria-pressed", "true");

        if (selectedSize) {
            selectedSize.textContent = btn.dataset.size;
        }
    });
});
