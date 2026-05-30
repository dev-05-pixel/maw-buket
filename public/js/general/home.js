document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("testimonialForm");
    const warning = document.getElementById("ratingWarning");

    if (form) {
        form.addEventListener("submit", function (e) {
            const checkedRating = document.querySelector(
                'input[name="rating"]:checked',
            );

            if (!checkedRating) {
                e.preventDefault();

                warning.classList.add("show");

                setTimeout(() => {
                    warning.classList.remove("show");
                }, 2500);
            }
        });

        const stars = document.querySelectorAll('input[name="rating"]');

        stars.forEach((star) => {
            star.addEventListener("change", () => {
                warning.classList.remove("show");
            });
        });
    }

    // snackbar
    const snackbar = document.getElementById("snackbar");

    if (snackbar) {
        setTimeout(() => {
            snackbar.classList.add("show");
        }, 300);

        setTimeout(() => {
            snackbar.classList.remove("show");
        }, 4200);

        // stay on testimonial section
        const testimonialSection = document.getElementById("testimonials");

        if (testimonialSection) {
            setTimeout(() => {
                testimonialSection.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }, 100);
        }
    }
});

const textarea = document.getElementById("testimonialMessage");
const charCount = document.getElementById("charCount");

function updateCount() {
    charCount.textContent = textarea.value.length;
}

textarea.addEventListener("input", updateCount);

updateCount();

document.querySelectorAll(".read-more-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        const text = this.previousElementSibling;

        if (text.classList.contains("collapsed")) {
            text.classList.remove("collapsed");
            this.textContent = "Tampilkan Lebih Sedikit";
        } else {
            text.classList.add("collapsed");
            this.textContent = "Baca Selengkapnya";
        }
    });
});
