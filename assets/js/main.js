// Inception Inc. - Main JavaScript
// Enhanced animations using GSAP library

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initializePageAnimations();
    initializeScrollAnimations();
    initializeFormAnimations();
});

function initializePageAnimations() {
    // Animate hero content on page load
    gsap.from('.hero-content', {
        duration: 0.8,
        opacity: 0,
        y: 50,
        ease: 'power2.out'
    });

    gsap.from('.hero-animation', {
        duration: 0.8,
        opacity: 0,
        x: 50,
        ease: 'power2.out',
        delay: 0.2
    });

    // Animate feature cards
    const featureCards = document.querySelectorAll('.feature-card');
    gsap.from(featureCards, {
        duration: 0.6,
        opacity: 0,
        y: 30,
        stagger: 0.1,
        ease: 'power2.out',
        delay: 0.3
    });

    // Animate about sections
    const aboutSections = document.querySelectorAll('.about-section');
    aboutSections.forEach((section, index) => {
        gsap.from(section, {
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                end: 'top 50%',
                scrub: 1
            },
            opacity: 0,
            y: 50,
            duration: 0.8
        });
    });

    // Animate navbar on scroll
    let lastScrollTop = 0;
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 100) {
            navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.2)';
        } else {
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
        }
        
        lastScrollTop = scrollTop;
    });
}

function initializeScrollAnimations() {
    // Animate elements on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // Observe all cards and sections
    const cards = document.querySelectorAll(
        '.feature-card, .info-card, .testimonial-card, .coverage-item, .why-card'
    );
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s ease';
        observer.observe(card);
    });
}

function initializeFormAnimations() {
    // Add focus animations to form inputs
    const inputs = document.querySelectorAll(
        'input, textarea, select'
    );

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            gsap.to(this, {
                duration: 0.3,
                boxShadow: '0 0 0 3px rgba(102, 126, 234, 0.1)'
            });
        });

        input.addEventListener('blur', function() {
            gsap.to(this, {
                duration: 0.3,
                boxShadow: 'none'
            });
        });
    });

    // Form submit animations
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.submit-btn');
            if (submitBtn) {
                gsap.to(submitBtn, {
                    duration: 0.5,
                    scale: 0.95,
                    opacity: 0.7
                });

                setTimeout(() => {
                    gsap.to(submitBtn, {
                        duration: 0.5,
                        scale: 1,
                        opacity: 1
                    });
                }, 500);
            }
        });
    });
}

// Smooth scroll behavior for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            gsap.to(window, {
                duration: 1,
                scrollTo: target,
                ease: 'power2.inOut'
            });
        }
    });
});

// Pulse animation for CTA button
const ctaButton = document.querySelector('.cta-button');
if (ctaButton) {
    gsap.to(ctaButton, {
        duration: 1.5,
        boxShadow: '0 5px 20px rgba(102, 126, 234, 0.4), 0 0 20px rgba(102, 126, 234, 0.6)',
        repeat: -1,
        yoyo: true
    });
}

// Counter animation for stats
const stats = document.querySelectorAll('.stat h3');
stats.forEach(stat => {
    const finalValue = stat.textContent;
    
    stat.addEventListener('mouseenter', function() {
        // Extract number from text
        const match = finalValue.match(/\d+/);
        if (match) {
            const targetNumber = parseInt(match[0]);
            gsap.fromTo(this, 
                { textContent: 0 },
                {
                    textContent: targetNumber,
                    duration: 1,
                    snap: { textContent: 1 },
                    ease: 'power1.inOut',
                    onUpdate: function() {
                        stat.textContent = Math.round(this.targets()[0].textContent) + (finalValue.includes('+') ? '+' : finalValue.includes('%') ? '%' : finalValue.includes('B') ? 'B+' : '');
                    }
                }
            );
        }
    });
});

// Add parallax effect to hero animation sphere
const sphere = document.querySelector('.animation-sphere');
if (sphere) {
    document.addEventListener('mousemove', function(e) {
        const moveX = (e.clientX / window.innerWidth) * 20 - 10;
        const moveY = (e.clientY / window.innerHeight) * 20 - 10;
        
        gsap.to(sphere, {
            duration: 0.5,
            x: moveX,
            y: moveY
        });
    });
}

// Stagger animation for testimonials
const testimonialCards = document.querySelectorAll('.testimonial-card');
gsap.from(testimonialCards, {
    scrollTrigger: {
        trigger: '.testimonials',
        start: 'top 80%'
    },
    duration: 0.6,
    opacity: 0,
    y: 30,
    stagger: 0.15,
    ease: 'back.out'
});

console.log('Inception Inc. Website - Loaded successfully');
