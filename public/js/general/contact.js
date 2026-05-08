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
