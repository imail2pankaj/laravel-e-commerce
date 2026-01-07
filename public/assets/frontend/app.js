

// Mobile Menu Logic
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Sticky Navbar Scroll Effect
    const nav = document.querySelector('nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                nav.classList.remove('bg-transparent');
                nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
            } else {
                nav.classList.add('bg-transparent');
                nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
            }
        });
    }

    // Optional: Cart counter interaction (simple demo)
    const cartBadges = document.querySelectorAll('.cart-badge');
    let cartCount = 0;

    // Add to cart buttons
    const addButtons = document.querySelectorAll('button');
    addButtons.forEach(btn => {
        if (btn.textContent.includes('Add to Cart') || btn.textContent.includes('Shop Now')) {
            btn.addEventListener('click', () => {
                cartCount++;
                cartBadges.forEach(badge => badge.textContent = cartCount);

                // Visual feedback
                const originalText = btn.innerHTML;
                btn.innerHTML = 'Added!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 1000);
            });
        }
    });

    console.log('Electra app initialized');
});
