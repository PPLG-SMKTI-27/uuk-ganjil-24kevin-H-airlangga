/**
 * Parallax.js - Advanced Parallax Scrolling Effect
 * SMK TI Airlangga - Buku Tamu Digital
 */

class ParallaxController {
    constructor() {
        this.init();
    }

    init() {
        this.setupParallaxLayers();
        this.setupScrollReveal();
        this.setupCounters();
        this.setupSmoothScroll();
        this.setupFloatingAnimations();
        this.setupMouseParallax();
    }

    // Parallax Layer Effect
    setupParallaxLayers() {
        const parallaxLayers = document.querySelectorAll('.parallax-layer');

        if (parallaxLayers.length === 0) return;

        let ticking = false;

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const scrolled = window.pageYOffset;

                    parallaxLayers.forEach(layer => {
                        const speed = layer.dataset.speed || 0.5;
                        const yPos = -(scrolled * speed);
                        layer.style.transform = `translate3d(0, ${yPos}px, 0)`;
                    });

                    ticking = false;
                });

                ticking = true;
            }
        });
    }

    // Scroll Reveal Animation
    setupScrollReveal() {
        const revealElements = document.querySelectorAll('.scroll-reveal, .fade-in-up, .feature-card');

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            revealObserver.observe(element);
        });
    }

    // Animated Counter
    setupCounters() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // Animation speed

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = +counter.getAttribute('data-target');
                    const increment = target / speed;

                    const updateCount = () => {
                        const count = +counter.innerText;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + increment);
                            setTimeout(updateCount, 10);
                        } else {
                            counter.innerText = target + (counter.dataset.suffix || '');
                        }
                    };

                    updateCount();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => {
            counter.innerText = '0';
            counterObserver.observe(counter);
        });
    }

    // Smooth Scroll
    setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                // Skip if it's just "#"
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();

                    const offsetTop = target.offsetTop - 80; // Account for navbar

                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Floating Animation
    setupFloatingAnimations() {
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }

            @keyframes floating {
                0%, 100% { transform: translateY(0px) translateX(0px); }
                25% { transform: translateY(-10px) translateX(5px); }
                50% { transform: translateY(-20px) translateX(0px); }
                75% { transform: translateY(-10px) translateX(-5px); }
            }

            @keyframes rotate-slow {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .floating {
                animation: floating 8s ease-in-out infinite;
            }

            .rotate-slow {
                animation: rotate-slow 20s linear infinite;
            }
        `;
        document.head.appendChild(style);
    }

    // Mouse Parallax Effect (3D Tilt)
    setupMouseParallax() {
        const hero = document.getElementById('hero');
        if (!hero) return;

        let mouseX = 0;
        let mouseY = 0;
        let currentX = 0;
        let currentY = 0;

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            mouseX = (e.clientX - rect.left) / rect.width - 0.5;
            mouseY = (e.clientY - rect.top) / rect.height - 0.5;
        });

        // Smooth animation loop
        const animate = () => {
            // Lerp (linear interpolation) for smooth movement
            currentX += (mouseX - currentX) * 0.1;
            currentY += (mouseY - currentY) * 0.1;

            // Apply parallax to floating elements
            const floatingElements = hero.querySelectorAll('.parallax-mouse');
            floatingElements.forEach((element, index) => {
                const depth = element.dataset.depth || 1;
                const moveX = currentX * 20 * depth;
                const moveY = currentY * 20 * depth;
                element.style.transform = `translate3d(${moveX}px, ${moveY}px, 0)`;
            });

            requestAnimationFrame(animate);
        };

        animate();
    }
}

// Utility: Lazy Load Images
class LazyLoader {
    constructor() {
        this.images = document.querySelectorAll('img[data-src]');
        this.init();
    }

    init() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                });
            });

            this.images.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for older browsers
            this.images.forEach(img => {
                img.src = img.dataset.src;
            });
        }
    }
}

// Navbar Scroll Effect
class NavbarController {
    constructor() {
        this.navbar = document.getElementById('navbar');
        if (this.navbar) {
            this.init();
        }
    }

    init() {
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            // Add shadow on scroll
            if (currentScroll > 50) {
                this.navbar.classList.add('shadow-2xl');
            } else {
                this.navbar.classList.remove('shadow-2xl');
            }

            // Hide/show navbar on scroll (optional)
            if (currentScroll > lastScroll && currentScroll > 500) {
                // Scrolling down
                this.navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                this.navbar.style.transform = 'translateY(0)';
            }

            lastScroll = currentScroll;
        });
    }
}

// Card Tilt Effect (3D)
class CardTiltEffect {
    constructor() {
        this.cards = document.querySelectorAll('.feature-card');
        this.init();
    }

    init() {
        this.cards.forEach(card => {
            card.addEventListener('mousemove', this.handleMove.bind(this));
            card.addEventListener('mouseleave', this.handleLeave.bind(this));
        });
    }

    handleMove(e) {
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
    }

    handleLeave(e) {
        const card = e.currentTarget;
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
    }
}

// Particle Background Effect (Optional)
class ParticleBackground {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        if (this.container) {
            this.init();
        }
    }

    init() {
        const particleCount = 50;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';

            // Random position
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';

            // Random size
            const size = Math.random() * 4 + 2;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';

            // Random animation duration
            particle.style.animationDuration = (Math.random() * 10 + 5) + 's';
            particle.style.animationDelay = Math.random() * 5 + 's';

            this.container.appendChild(particle);
        }

        // Add CSS for particles
        const style = document.createElement('style');
        style.textContent = `
            .particle {
                position: absolute;
                background: white;
                border-radius: 50%;
                opacity: 0.3;
                animation: particle-float linear infinite;
            }

            @keyframes particle-float {
                0% {
                    transform: translateY(0) translateX(0);
                    opacity: 0;
                }
                10% {
                    opacity: 0.3;
                }
                90% {
                    opacity: 0.3;
                }
                100% {
                    transform: translateY(-100vh) translateX(50px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// Loading Animation
class PageLoader {
    constructor() {
        this.init();
    }

    init() {
        window.addEventListener('load', () => {
            document.body.classList.add('loaded');

            // Add entrance animations
            const hero = document.querySelector('#hero');
            if (hero) {
                hero.classList.add('animate-fade-in');
            }
        });
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize all components
    new ParallaxController();
    new NavbarController();
    new CardTiltEffect();
    new LazyLoader();
    new PageLoader();

    // Optional: Initialize particles on hero
    // new ParticleBackground('hero');

    console.log('🚀 Parallax system initialized');
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ParallaxController,
        NavbarController,
        CardTiltEffect,
        LazyLoader,
        PageLoader,
        ParticleBackground
    };
}
