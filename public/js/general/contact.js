const textarea = document.getElementById("message");
const charCount = document.getElementById("msg-count");
const form = document.getElementById("contact-form");
const successBox = document.getElementById("form-success");
if (textarea) {
    textarea.addEventListener("input", () => {
        const l = textarea.value.length;
        charCount.textContent = l + " / 600";
        charCount.style.color = l > 550 ? "var(--rose)" : "var(--warm-grey)";
    });
}
if (form) {
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const req = form.querySelectorAll("[required]");
        let ok = true;
        req.forEach((el) => {
            if (!el.value.trim()) {
                ok = false;
                el.style.borderColor = "var(--rose)";
            } else {
                el.style.borderColor = "";
            }
        });
        if (!ok) return;

        const btn = form.querySelector(".form-submit-btn");
        btn.disabled = true;
        btn.innerHTML = "<span>Mengirim...</span>";

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content ?? formData.get("_token"),
                Accept: "application/json",
            },
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    form.style.display = "none";
                    successBox.classList.add("visible");
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = "<span>Kirim Pesan</span>";
                alert("Terjadi kesalahan, silakan coba lagi.");
            });
    });
}
document.querySelectorAll(".faq-question").forEach((q) => {
    q.addEventListener("click", function () {
        const open = this.getAttribute("aria-expanded") === "true";
        const a = document.getElementById(this.getAttribute("aria-controls"));
        document
            .querySelectorAll(".faq-question")
            .forEach((b) => b.setAttribute("aria-expanded", "false"));
        document
            .querySelectorAll(".faq-answer")
            .forEach((x) => x.classList.remove("open"));
        if (!open) {
            this.setAttribute("aria-expanded", "true");
            a.classList.add("open");
        }
    });
});
// Validation and character count for contact form
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contact-form");

    const name = document.getElementById("name");
    const phone = document.getElementById("phone");
    const email = document.getElementById("email");
    const purpose = document.getElementById("purpose");
    const message = document.getElementById("message");

    // =========================
    // CREATE ERROR ELEMENT
    // =========================
    function showError(input, message) {
        removeError(input);

        input.classList.add("input-error");

        const error = document.createElement("small");
        error.className = "error-message";
        error.innerText = message;

        input.parentElement.appendChild(error);
    }

    function removeError(input) {
        input.classList.remove("input-error");

        const existing = input.parentElement.querySelector(".error-message");

        if (existing) {
            existing.remove();
        }
    }

    // =========================
    // VALIDATION
    // =========================
    function validateName() {
        const value = name.value.trim();

        if (value === "") {
            showError(name, "Nama wajib diisi");
            return false;
        }

        if (value.length < 3) {
            showError(name, "Nama minimal 3 karakter");
            return false;
        }

        removeError(name);
        return true;
    }

    function validatePhone() {
        const value = phone.value.trim();

        const phoneRegex = /^08[0-9]{8,13}$/;

        if (value === "") {
            showError(phone, "Nomor WhatsApp wajib diisi");
            return false;
        }

        if (!phoneRegex.test(value)) {
            showError(phone, "Format nomor tidak valid");
            return false;
        }

        removeError(phone);
        return true;
    }

    function validateEmail() {
        const value = email.value.trim();

        if (value === "") {
            removeError(email);
            return true;
        }

        const emailRegex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(value)) {
            showError(email, "Format email tidak valid");
            return false;
        }

        removeError(email);
        return true;
    }

    function validatePurpose() {
        if (purpose.value === "") {
            showError(purpose, "Silakan pilih keperluan");
            return false;
        }

        removeError(purpose);
        return true;
    }

    function validateMessage() {
        const value = message.value.trim();

        if (value === "") {
            showError(message, "Pesan wajib diisi");
            return false;
        }

        if (value.length < 10) {
            showError(message, "Pesan minimal 10 karakter");
            return false;
        }

        removeError(message);
        return true;
    }

    // =========================
    // REALTIME VALIDATION
    // =========================
    name.addEventListener("input", validateName);
    phone.addEventListener("input", validatePhone);
    email.addEventListener("input", validateEmail);
    purpose.addEventListener("change", validatePurpose);
    message.addEventListener("input", validateMessage);

    // =========================
    // SUBMIT VALIDATION
    // =========================
    form.addEventListener("submit", (e) => {
        const isValid =
            validateName() &&
            validatePhone() &&
            validateEmail() &&
            validatePurpose() &&
            validateMessage();

        if (!isValid) {
            e.preventDefault();
        }
    });

    // =========================
    // CHARACTER COUNTER
    // =========================
    const counter = document.getElementById("msg-count");

    message.addEventListener("input", () => {
        counter.innerText = `${message.value.length} / 600`;
    });
});
