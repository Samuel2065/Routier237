let currentTestimonial = 0;
        const testimonials = document.querySelectorAll('.testimonial');
        const dots = document.querySelectorAll('.slider-dot');

        function showTestimonial(index) {
            // Hide all testimonials
            testimonials.forEach(testimonial => {
                testimonial.classList.remove('active');
            });
            
            // Remove active class from all dots
            dots.forEach(dot => {
                dot.classList.remove('active');
            });
            
            // Show selected testimonial
            testimonials[index].classList.add('active');
            dots[index].classList.add('active');
            
            currentTestimonial = index;
        }

        // Auto-slide testimonials
        function autoSlide() {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }

        // Start auto-slide
        setInterval(autoSlide, 5000);

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Maintain white navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            navbar.style.backgroundColor = 'white';
        });

        // Animate stats on scroll
        function animateStats() {
            const stats = document.querySelectorAll('.stat-item h3');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        const finalNumber = parseInt(target.textContent);
                        let current = 0;
                        const increment = finalNumber / 100;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= finalNumber) {
                                current = finalNumber;
                                clearInterval(timer);
                            }
                            target.textContent = Math.floor(current) + (target.textContent.includes('+') ? '+' : '');
                        }, 30);
                        observer.unobserve(target);
                    }
                });
            });
            
            stats.forEach(stat => observer.observe(stat));
        }

        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            animateStats();
        });