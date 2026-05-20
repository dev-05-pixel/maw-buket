// ================================================================
//  INIT
// ================================================================
document.addEventListener("DOMContentLoaded", () => {
    const budgetSlider = document.getElementById("budget-slider");

    // ================================================================
    //  HELPER: UPDATE BUDGET DISPLAY
    // ================================================================
    const updateBudgetDisplay = (value) => {
        const el = document.getElementById("budget-val");
        if (!el) return;
        el.textContent = new Intl.NumberFormat("id-ID").format(value);
    };

    // ================================================================
    //  BUDGET SLIDER
    // ================================================================
    if (budgetSlider) {
        updateBudgetDisplay(budgetSlider.value);

        budgetSlider.addEventListener("input", () => {
            updateBudgetDisplay(budgetSlider.value);
        });
    }

    // ================================================================
    //  HANDLE SKIP TOGGLE (UNIFIED)
    // ================================================================
    const handleSkipToggle = (checkbox) => {
        const targetId = checkbox.dataset.target;
        const sliderId = checkbox.dataset.slider;

        const target = document.getElementById(targetId);
        const slider = sliderId ? document.getElementById(sliderId) : null;

        // Disable input/select
        if (target && targetId !== "color-picker-group") {
            target.disabled = checkbox.checked;
        }

        // Special: color picker group
        if (targetId === "color-picker-group") {
            const group = document.getElementById("color-picker-group");
            if (group) {
                group.style.opacity = checkbox.checked ? "0.4" : "1";
                group.style.pointerEvents = checkbox.checked ? "none" : "";
                group.querySelectorAll("input").forEach((input) => {
                    input.disabled = checkbox.checked;
                });
            }
        }

        // Handle slider
        if (slider) {
            slider.disabled = checkbox.checked;
        }

        // Special: budget value
        if (slider) {
            slider.disabled = checkbox.checked;
        }
    };

    // Attach event listener
    document.querySelectorAll(".skip-checkbox").forEach((cb) => {
        cb.addEventListener("change", function () {
            handleSkipToggle(this);
        });

        // INIT state (important for old() Laravel)
        handleSkipToggle(cb);
    });

    // ================================================================
    //  COLOR PICK BUTTONS
    // ================================================================
    document.querySelectorAll(".color-pick-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            document
                .querySelectorAll(".color-pick-btn")
                .forEach((b) => b.classList.remove("selected"));
            this.classList.add("selected");
        });
    });

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
                `Halo Maw Bouquet, saya tertarik dengan produk ${name} dengan harga Rp ${price}. Apakah masih tersedia? Link: ${link}`,
                `Permisi kak, saya menemukan ${name} (Rp ${price}) di website Maw Bouquet dan ingin memesan. Masih ada stok? ${link}`,
            ];

            const msg = messages[Math.floor(Math.random() * messages.length)];
            window.open(
                "https://wa.me/6282333000472?text=" + encodeURIComponent(msg),
                "_blank",
            );
        });
    });

    // ================================================================
    //  SUBMIT LOADING STATE
    // ================================================================
    const form = document.getElementById("ai-form");
    const submitBtn = document.getElementById("submit-btn");

    if (form && submitBtn) {
        form.addEventListener("submit", () => {
            submitBtn.innerHTML = `
                <svg style="width:18px;height:18px;stroke:currentColor;fill:none;animation:spin 1s linear infinite" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="40" stroke-dashoffset="10"/>
                </svg>
                <span>Sedang Menganalisis...</span>
            `;
            submitBtn.disabled = true;
        });
    }

    // ================================================================
    //  SCROLL REVEAL
    // ================================================================
    const revealEls = document.querySelectorAll(".reveal");

    const observer = new IntersectionObserver(
        (entries, obs) => {
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

    revealEls.forEach((el) => observer.observe(el));
});

// ================================================================
//  GLOBAL CSS ANIMATION (SPINNER)
// ================================================================
const style = document.createElement("style");
style.textContent = `
            @keyframes spin {
                to { transform: rotate(360deg); }
            }`;
document.head.appendChild(style);

const sizeTrigger = document.getElementById("size-trigger");
const sizeDropdown = document.getElementById("size-dropdown");
const sizeTriggerText = document.getElementById("size-trigger-text");

if (sizeTrigger && sizeDropdown) {
    sizeTrigger.addEventListener("click", () => {
        sizeDropdown.classList.toggle("active");
    });

    document.addEventListener("click", (e) => {
        if (
            !sizeTrigger.contains(e.target) &&
            !sizeDropdown.contains(e.target)
        ) {
            sizeDropdown.classList.remove("active");
        }
    });

    const sizeCheckboxes = sizeDropdown.querySelectorAll(
        'input[type="checkbox"]',
    );

    const updateSizeLabel = () => {
        const selected = [...sizeCheckboxes]
            .filter((item) => item.checked)
            .map((item) => item.value);

        sizeTriggerText.textContent = selected.length
            ? selected.join(", ")
            : "Pilih ukuran buket";
    };

    sizeCheckboxes.forEach((item) => {
        item.addEventListener("change", updateSizeLabel);
    });

    updateSizeLabel();
}
