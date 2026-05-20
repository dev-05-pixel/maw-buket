import './bootstrap';
import '../css/app.css';
import Alpine from 'alpinejs'

window.Alpine = Alpine

// CART LOGIC
window.cartApp = function () {
    return {
        cartOpen: false,
        checkoutOpen: false,
        cart: [],

        initCart() {
            const saved = localStorage.getItem('cart')
            this.cart = saved ? JSON.parse(saved) : []
        },

        addToCart(product) {
            const existing = this.cart.find(item => item.id === product.id)

            if (existing) {
                existing.qty++
            } else {
                this.cart.push({ ...product, qty: 1 })
            }

            this.saveCart()
        },

        increaseQty(id) {
            const item = this.cart.find(i => i.id === id)
            item.qty++
            this.saveCart()
        },

        decreaseQty(id) {
            const item = this.cart.find(i => i.id === id)
            if (item.qty > 1) item.qty--
            this.saveCart()
        },

        removeItem(id) {
            this.cart = this.cart.filter(item => item.id !== id)
            this.saveCart()
        },

        totalPrice() {
            return this.cart.reduce((sum, item) =>
                sum + (item.price * item.qty), 0)
        },

        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cart))
        }
    }
}

// Scroll Reveal Animation
document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.remove("opacity-0", "translate-y-10");
                entry.target.classList.add("opacity-100", "translate-y-0");
            }
        });
    });

    document.querySelectorAll(".reveal").forEach(el => {
        observer.observe(el);
    });
});



Alpine.start()
