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
