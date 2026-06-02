// ================================================================
// WHATSAPP ORDER MESSAGE
// ================================================================

document.querySelectorAll(".wa-order").forEach((btn) => {
    btn.addEventListener("click", async (e) => {
        e.preventDefault();
        e.stopPropagation();

        const productId = btn.dataset.id;
        const storeUrl = btn.dataset.storeUrl;

        if (!productId || !storeUrl) {
            console.error("Dataset tidak lengkap");
            return;
        }

        btn.disabled = true;

        try {
            const response = await fetch(storeUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    product_id: productId,
                    price: btn.dataset.price || 0,
                }),
            });

            const data = await response.json();

            if (data.success && data.wa_url) {
                window.open(data.wa_url, "_blank");
            } else {
                alert("Terjadi kesalahan saat membuat pesanan.");
            }
        } catch (error) {
            console.error(error);

            alert("Gagal terhubung ke server.");
        } finally {
            btn.disabled = false;
        }
    });
});

// ================================================================
// CATEGORY CHECKBOX LOGIC
// ================================================================

const categoryCheckboxes = document.querySelectorAll(".category-checkbox");
const allCheckbox = document.querySelector('.category-checkbox[value="Semua"]');

function syncSemua() {
    const checkedNonAll = [...categoryCheckboxes].filter(
        (item) => item.value !== "Semua" && item.checked,
    );
    if (allCheckbox) {
        allCheckbox.disabled = checkedNonAll.length > 0;
    }
}

categoryCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        if (this.value === "Semua") {
            // Re-enable semua dulu, baru atur ulang
            categoryCheckboxes.forEach((item) => {
                item.checked = false;
                item.disabled = false;
            });
            this.checked = true;
            return;
        }

        if (this.checked) {
            allCheckbox.checked = false;
        }

        const checkedNonAll = [...categoryCheckboxes].filter(
            (item) => item.value !== "Semua" && item.checked,
        );

        if (checkedNonAll.length === 0) {
            allCheckbox.checked = true;
            allCheckbox.disabled = false;
        } else {
            allCheckbox.disabled = true;
        }
    });
});

syncSemua();

// ================================================================
// VIEW TOGGLE
// ================================================================

const gridBtn = document.getElementById("grid-view-btn");
const listBtn = document.getElementById("list-view-btn");
const listing = document.getElementById("products-listing");

function applyView(view) {
    if (view === "list") {
        listing.classList.add("view-list");

        listBtn.classList.add("active");
        gridBtn.classList.remove("active");

        listBtn.setAttribute("aria-pressed", "true");
        gridBtn.setAttribute("aria-pressed", "false");
    } else {
        listing.classList.remove("view-list");

        gridBtn.classList.add("active");
        listBtn.classList.remove("active");

        gridBtn.setAttribute("aria-pressed", "true");
        listBtn.setAttribute("aria-pressed", "false");
    }

    localStorage.setItem("productsView", view);
}

const savedView = localStorage.getItem("productsView") || "grid";

applyView(savedView);

gridBtn.addEventListener("click", (e) => {
    e.preventDefault();
    applyView("grid");
});

listBtn.addEventListener("click", (e) => {
    e.preventDefault();
    applyView("list");
});

// ================================================================
// SCROLL REVEAL
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
// COLOR SWATCHES
// ================================================================

document.querySelectorAll(".color-swatch").forEach((swatch) => {
    swatch.addEventListener("click", function () {
        this.classList.toggle("active");
    });
});

// ================================================================
// SORT SELECT AUTO SUBMIT
// ================================================================

const sortSelect = document.querySelector(".sort-select");

if (sortSelect) {
    sortSelect.addEventListener("change", function () {
        const mainForm = document.querySelector('form[action*="products"]');

        if (mainForm) {
            mainForm.submit();
        }
    });
}

// ================================================================
// SEARCH INPUT ANIMATION
// ================================================================

const searchWrap = document.querySelector(".catalog-search-wrap");

if (searchWrap) {
    const searchInput = searchWrap.querySelector("input");

    searchInput.addEventListener("focus", () => {
        searchWrap.classList.add("active");
    });

    searchInput.addEventListener("blur", () => {
        if (searchInput.value.trim() === "") {
            searchWrap.classList.remove("active");
        }
    });
}

// ================================================================
// MOBILE SIDEBAR
// ================================================================

const mobileToggle = document.getElementById("mobile-filter-toggle");

const sidebar = document.getElementById("sidebar");

const sidebarOverlay = document.getElementById("sidebar-overlay");

if (mobileToggle && sidebar && sidebarOverlay) {
    mobileToggle.addEventListener("click", () => {
        sidebar.classList.add("mobile-open");

        sidebarOverlay.classList.add("active");

        document.body.style.overflow = "hidden";
    });

    sidebarOverlay.addEventListener("click", () => {
        sidebar.classList.remove("mobile-open");

        sidebarOverlay.classList.remove("active");

        document.body.style.overflow = "";
    });
}

// ================================================================
// PRICE FILTER
// ================================================================

const minInput = document.getElementById("priceMin");
const maxInput = document.getElementById("priceMax");

function parseNumber(value) {
    return parseInt(String(value).replace(/\D/g, "")) || 0;
}

function formatRupiah(value) {
    if (!value || value <= 0) {
        return "";
    }

    return new Intl.NumberFormat("id-ID").format(value);
}

function setFormattedValue(input, value) {
    input.value = formatRupiah(value);
    input.dataset.value = value;
}

// ================================================================
// SETUP INPUT
// ================================================================

function syncLogic(changed) {
    if (!minInput || !maxInput) {
        return;
    }

    let min = parseNumber(minInput.value);
    let max = parseNumber(maxInput.value);

    if (!min || !max) {
        return;
    }

    if (min > max) {
        if (changed === "min") {
            setFormattedValue(maxInput, min);
        } else {
            setFormattedValue(minInput, max);
        }
    }
}

if (minInput && maxInput) {
    // ================================================================
    // HELPER
    // ================================================================

    function setupPriceInput(input, type) {
        const initialValue = parseNumber(input.value);
        if (initialValue > 0) {
            setFormattedValue(input, initialValue);
        }

        input.addEventListener("input", function () {
            // Simpan posisi kursor
            const raw = this.value.replace(/\D/g, "");
            const value = parseInt(raw) || 0;
            // Format tapi jangan ganggu input yang sedang diketik
            // Hanya format setelah user berhenti (pakai blur),
            // saat input cukup tampilkan angka saja
            this.value = raw
                ? new Intl.NumberFormat("id-ID").format(value)
                : "";
            this.dataset.rawValue = value;
            // JANGAN panggil syncLogic saat mengetik untuk hindari overwrite
        });

        input.addEventListener("keydown", function (e) {
            if (e.key !== "ArrowUp" && e.key !== "ArrowDown") return;
            e.preventDefault();
            let currentValue =
                parseInt(this.dataset.rawValue || "0") ||
                parseNumber(this.value);
            if (e.key === "ArrowUp") currentValue += 1000;
            if (e.key === "ArrowDown")
                currentValue = Math.max(0, currentValue - 1000);
            setFormattedValue(this, currentValue);
            this.dataset.rawValue = currentValue;
        });

        input.addEventListener("wheel", function (e) {
            if (document.activeElement !== this) return;
            e.preventDefault();
            let currentValue =
                parseInt(this.dataset.rawValue || "0") ||
                parseNumber(this.value);
            if (e.deltaY < 0) currentValue += 1000;
            else currentValue = Math.max(0, currentValue - 1000);
            setFormattedValue(this, currentValue);
            this.dataset.rawValue = currentValue;
        });

        input.addEventListener("focus", function () {
            // Tampilkan angka mentah saat focus agar mudah diedit
            const raw =
                parseInt(this.dataset.rawValue || "0") ||
                parseNumber(this.value);
            this.value = raw > 0 ? raw : "";
            this.dataset.rawValue = raw;
        });

        input.addEventListener("blur", function () {
            const value =
                parseInt(this.dataset.rawValue || "0") ||
                parseNumber(this.value);
            setFormattedValue(this, value);
            this.dataset.rawValue = value;
        });
    }

    setupPriceInput(minInput, "min");
    setupPriceInput(maxInput, "max");

    // ================================================================
    // BEFORE SUBMIT
    // ================================================================

    const mainForm = document.querySelector('form[action*="products"]');
    if (mainForm && minInput && maxInput) {
        mainForm.addEventListener("submit", function () {
            const rawMin =
                parseInt(minInput.dataset.rawValue || "0") ||
                parseNumber(minInput.value);
            const rawMax =
                parseInt(maxInput.dataset.rawValue || "0") ||
                parseNumber(maxInput.value);
            minInput.value = rawMin > 0 ? rawMin : "";
            maxInput.value = rawMax > 0 ? rawMax : "";
        });
    }
}

// ================================================================
// CUSTOM SPINNER BUTTONS
// ================================================================

document.querySelectorAll(".spinner-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const targetId = this.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;

        let value =
            parseInt(input.dataset.rawValue || "0") || parseNumber(input.value);

        if (this.classList.contains("spinner-up")) value += 1000;
        if (this.classList.contains("spinner-down"))
            value = Math.max(0, value - 1000);

        setFormattedValue(input, value);
        input.dataset.rawValue = value;
    });
});

// ================================================================
// SEARCH SUBMIT
// ================================================================

const searchInput = document.getElementById("catalog-search-input");

if (searchInput) {
    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();

            const form = document.querySelector('form[action*="products"]');

            if (form) {
                form.submit();
            }
        }
    });
}

// ================================================================
// COLOR CHECKBOX ACTIVE
// ================================================================

document.querySelectorAll(".color-checkbox").forEach((checkbox) => {
    const label = checkbox.closest(".color-tag");

    if (checkbox.checked) {
        label.classList.add("active");
    }

    checkbox.addEventListener("change", () => {
        label.classList.toggle("active", checkbox.checked);
    });
});
