// ================================================================
//  PAGE LOADER
// ================================================================
window.addEventListener("load", () => {
    setTimeout(() => {
        document.getElementById("page-loader").classList.add("hidden");
    }, 1600);
});

// ================================================================
//  CUSTOM CURSOR
// ================================================================
const dot = document.getElementById("cursor-dot");
const ring = document.getElementById("cursor-ring");
let mx = 0,
    my = 0,
    rx = 0,
    ry = 0;

document.addEventListener("mousemove", (e) => {
    mx = e.clientX;
    my = e.clientY;
    dot.style.left = mx + "px";
    dot.style.top = my + "px";
});

function animRing() {
    rx += (mx - rx) * 0.12;
    ry += (my - ry) * 0.12;
    ring.style.left = rx + "px";
    ring.style.top = ry + "px";
    requestAnimationFrame(animRing);
}
animRing();

const hoverTargets = document.querySelectorAll('a, button, [role="button"]');
hoverTargets.forEach((el) => {
    el.addEventListener("mouseenter", () =>
        document.body.classList.add("hovering"),
    );
    el.addEventListener("mouseleave", () =>
        document.body.classList.remove("hovering"),
    );
});

// ================================================================
//  NAVBAR SCROLL EFFECT
// ================================================================
const navbar = document.getElementById("navbar");
window.addEventListener(
    "scroll",
    () => {
        navbar.classList.toggle("scrolled", window.scrollY > 60);
    },
    {
        passive: true,
    },
);

// ================================================================
//  HAMBURGER / MOBILE NAV
// ================================================================
const hamburger = document.getElementById("hamburger-btn");
const mobileNav = document.getElementById("mobile-nav");
const mobileLinks = mobileNav.querySelectorAll(".mobile-nav-link");
let menuOpen = false;

function toggleMenu(state) {
    menuOpen = state ?? !menuOpen;
    hamburger.classList.toggle("open", menuOpen);
    mobileNav.classList.toggle("open", menuOpen);
    mobileNav.setAttribute("aria-hidden", !menuOpen);
    hamburger.setAttribute("aria-expanded", menuOpen);
    document.body.style.overflow = menuOpen ? "hidden" : "";
}

hamburger.addEventListener("click", () => toggleMenu());
mobileLinks.forEach((link) => {
    link.addEventListener("click", () => toggleMenu(false));
});

// RESET MOBILE MENU JIKA LAYAR BESAR
window.addEventListener("resize", () => {
    if (window.innerWidth > 900 && menuOpen) {
        mobileNav.classList.add("closing");

        setTimeout(() => {
            mobileNav.classList.remove("open");
            mobileNav.classList.remove("closing");

            hamburger.classList.remove("open");

            menuOpen = false;
            document.body.style.overflow = "";
        }, 450);
    }
});
window.addEventListener("orientationchange", () => {
    toggleMenu(false);
});

// ================================================================
//  SCROLL REVEAL (IntersectionObserver)
// ================================================================
const revealEls = document.querySelectorAll(
    ".reveal, .reveal-left, .reveal-right",
);
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("in-view");
                observer.unobserve(entry.target);
            }
        });
    },
    {
        threshold: 0.12,
        rootMargin: "0px 0px -40px 0px",
    },
);

revealEls.forEach((el) => observer.observe(el));

// Re-observe footer elements specifically
const footerReveals = document.querySelectorAll("footer .reveal");
const footerObs = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("in-view");
                footerObs.unobserve(entry.target);
            }
        });
    },
    {
        threshold: 0.08,
    },
);
footerReveals.forEach((el) => footerObs.observe(el));

tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: "#000000",
                soft: "#f7f7f7",

                cream: "#F7F3EE",
                "cream-d": "#EDE6DC",

                brown: "#2C2421",
                "brown-m": "#4A3F3A",

                rose: "#D4847A",
                "rose-l": "#E8B5AF",
                "rose-d": "#B85C52",

                sand: "#C9AA86",
                muted: "#9E8E84",
                sage: "#7A9B7A",
            },

            fontFamily: {
                serif: ["Playfair Display", "serif"],
                sans: ["Inter", "sans-serif"],
            },
        },
    },
};
