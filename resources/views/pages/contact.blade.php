@extends('layouts.app')
        

@section('content')
    <style>
        :root {
            --primary-color: #1B2A4A;
            --primary-light: #2c406e;
            --primary-lighter: #e8eaf6;
            --secondary-gradient: linear-gradient(45deg, #1B2A4A, #2c406e);
            --success-gradient: linear-gradient(45deg, #27ae60, #2ecc71);
            --info-gradient: linear-gradient(45deg, #1B2A4A, #2c406e);
        }

        body {
            background: var(--primary-lighter);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* Hero Section */
        .hero-section {
            padding: 100px 0 60px;
            color: white;
            text-align: center;
            position: relative;
            background: linear-gradient(rgba(27, 42, 74, 0.9), rgba(27, 42, 74, 0.9)), url('{{ asset('assets/images/contact-hero.jpg') }}') no-repeat center center/cover;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: ;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .breadcrumb-custom {
            background: rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 15px 25px;
            backdrop-filter: blur(10px);
            display: inline-flex;
            margin-top: 20px;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: white;
            font-weight: 500;
        }

        /* Main Content */
        .contact-main {
            padding: 60px 0;
            position: relative;
            z-index: 2;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
            border: none;
            transition: all 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 80px rgba(0,0,0,0.15);
        }

        .card-header-custom {
            background: var(--primary-color);
            color: white;
            padding: 25px 30px;
            border: none;
        }

        .card-header-custom h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-body-custom {
            padding: 40px 30px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(27, 42, 74, 0.1);
            background: white;
        }

        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .btn-submit {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(27, 42, 74, 0.4);
            color: white;
            background: var(--primary-gradient);
        }

        /* Contact Info Cards */
        .info-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .info-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 25px;
        }

        .info-icon.phone {
            background: var(--secondary-gradient);
        }

        .info-icon.email {
            background: var(--primary-gradient);
        }

        .info-icon.location {
            background: var(--success-gradient);
        }

        .info-icon.hours {
            background: var(--primary-gradient);
        }

        .info-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .info-details {
            color: #666;
            line-height: 1.6;
        }

        .info-details strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        /* Map Section */
        .map-section {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .map-header {
            background: var(--primary-color);
            color: white;
            padding: 20px 30px;
            text-align: center;
        }

        .map-placeholder {
            height: 400px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 1.2rem;
            position: relative;
        }

        .map-placeholder::before {
            content: '🗺️';
            font-size: 4rem;
            display: block;
            margin-bottom: 15px;
        }

        /* FAQ Section */
        .faq-section {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            margin-top: 40px;
            box-shadow: 0 4px 6px rgba(27, 42, 74, 0.1);
        }

        .faq-title {
            color: var(--primary-color);
            text-align: center;
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .accordion-item {
            border: none;
            border-radius: 15px;
            margin-bottom: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .accordion-header .accordion-button {
            background: white;
            color: #2c3e50;
            font-weight: 600;
            padding: 20px 25px;
            border: none;
            box-shadow: none;
        }

        .accordion-button:not(.collapsed) {
            background: var(--primary-color);
            color: white;
        }

        .accordion-body {
            padding: 25px;
            color: #666;
            line-height: 1.6;
        }

        /* Social Links */
        .social-section {
            text-align: center;
            margin-top: 50px;
        }

        .social-title {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .social-link {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .social-link.facebook {
            background: #3b5998;
        }

        .social-link.twitter {
            background: #1da1f2;
        }

        .social-link.instagram {
            background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
        }

        .social-link.youtube {
            background: #ff0000;
        }

        .social-link.linkedin {
            background: #0077b5;
        }

        .social-link:hover {
            transform: translateY(-5px) scale(1.1);
            color: white;
        }

        /* Animations */
        .fade-in {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s ease;
        }

        .slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .card-body-custom {
                padding: 30px 20px;
            }
            
            .info-card {
                margin-bottom: 30px;
            }
            
            .social-links {
                gap: 15px;
            }
            
            .social-link {
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
            }
        }

        /* Success Message */
        .success-message {
            background: var(--success-gradient);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <i class="fas fa-envelope me-3"></i>Contact Us
                </h1>
                <p class="hero-subtitle">
                    We're here to answer all your questions and help you plan your perfect trip
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="contact-main">
        <div class="container">
            <div class="row">
                <!-- Contact Form -->
                <div class="col-12 mb-4">
                    <div class="card contact-card slide-up">
                        <div class="card-header-custom">
                            <h3>
                                <i class="fas fa-paper-plane me-2"></i>
                                Send us a message
                            </h3>
                        </div>
                        <div class="card-body-custom">
                            <div class="success-message" id="successMessage">
                                <i class="fas fa-check-circle me-2"></i>
                                Your message has been sent successfully! We'll get back to you as soon as possible.
                            </div>
                            
                            <form id="contactForm" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstName" class="form-label">
                                                <i class="fas fa-user me-1"></i>First Name *
                                            </label>
                                            <input type="text" class="form-control" id="firstName" required>
                                            <div class="invalid-feedback">
                                                Please enter your first name.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastName" class="form-label">
                                                <i class="fas fa-user me-1"></i>Last Name *
                                            </label>
                                            <input type="text" class="form-control" id="lastName" required>
                                            <div class="invalid-feedback">
                                                Please enter your last name.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope me-1"></i>Email *
                                            </label>
                                            <input type="email" class="form-control" id="email" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">
                                                <i class="fas fa-phone me-1"></i>Phone
                                            </label>
                                            <input type="tel" class="form-control" id="phone" placeholder="+1 234 567 8900">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">
                                                <i class="fas fa-tag me-1"></i>Subject *
                                            </label>
                                            <select class="form-select" id="subject" required>
                                                <option value="">Choose a subject</option>
                                                <option value="reservation">Reservation</option>
                                                <option value="information">Information Request</option>
                                                <option value="complaint">Complaint</option>
                                                <option value="partnership">Partnership</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please choose a subject.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="agency" class="form-label">
                                                <i class="fas fa-building me-1"></i>Relevant Agency
                                            </label>
                                            <select class="form-select" id="agency">
                                                <option value="">Choose an agency</option>
                                                <option value="evasion">Escape Travels</option>
                                                <option value="aventure">Adventure Routes</option>
                                                <option value="decouverte">World Discovery</option>
                                                <option value="familiaux">Family Travels</option>
                                                <option value="terres">Exceptional Lands</option>
                                                <option value="volcans">Nature & Volcanoes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="message" class="form-label">
                                        <i class="fas fa-comment me-1"></i>Message *
                                    </label>
                                    <textarea class="form-control" id="message" rows="6" 
                                            placeholder="Describe your request in detail..." required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter your message.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletter">
                                        <label class="form-check-label" for="newsletter">
                                            I would like to receive the newsletter with the latest offers
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacy" required>
                                        <label class="form-check-label" for="privacy">
                                            I accept the <a href="#" class="text-primary">privacy policy</a> *
                                        </label>
                                        <div class="invalid-feedback">
                                            You must accept the privacy policy.
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span class="btn-text">Send Message</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <!-- <div class="row">
                <div class="col-12">
                    <div class="map-section slide-up">
                        <div class="map-header">
                            <h3><i class="fas fa-map me-2"></i>Find Us</h3>
                        </div>
                        <div class="map-placeholder">
                            <div class="text-center">
                                <div style="font-size: 4rem; margin-bottom: 15px;">🗺️</div>
                                <h4>Interactive Map</h4>
                                <p class="mb-0">123 Travel Avenue, 75001 Paris</p>
                                <small class="text-muted">Click to open in Google Maps</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- FAQ Section -->
            <div class="row">
                <div class="col-12">
                    <div class="faq-section slide-up">
                        <h2 class="faq-title">
                            <i class="fas fa-question-circle me-2"></i>
                            Frequently Asked Questions
                        </h2>
                        
                        <div class="accordion" id="faqAccordion">
                            <!-- FAQ 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq1" aria-expanded="true">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        How can I book a trip?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You can book a trip directly on our website by selecting your preferred agency and clicking "Book Now". You can also contact us by phone or email for a personalized reservation with the help of our advisors.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq2">
                                        <i class="fas fa-credit-card me-2"></i>
                                        What payment methods are accepted?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        We accept all payment methods: credit cards (Visa, MasterCard, American Express), bank transfers, checks, and interest-free installment payments. A 30% deposit is required at booking.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq3">
                                        <i class="fas fa-times-circle me-2"></i>
                                        Can I cancel my reservation?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, you can cancel your reservation according to our terms and conditions. Cancellation fees vary by timeframe: free up to 30 days before departure, then decreasing. We recommend cancellation insurance.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq4">
                                        <i class="fas fa-shield-alt me-2"></i>
                                        Are you insured and certified?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Absolutely! All our partner agencies are certified and have mandatory insurance (Professional Liability, Financial Guarantee). We are members of SNAV and comply with all European safety standards for coach travel.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 5 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#faq5">
                                        <i class="fas fa-users me-2"></i>
                                        Do you offer custom trips?
                                    </button>
                                </h2>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes! Our partner agencies can create custom trips according to your desires: personalized destinations, private groups, flexible dates. Contact us to discuss your project and receive a free quote.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form Validation and Submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Bootstrap validation
            if (!this.checkValidity()) {
                e.stopPropagation();
                this.classList.add('was-validated');
                return;
            }
            
            // Get form data
            const formData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                subject: document.getElementById('subject').value,
                agency: document.getElementById('agency').value,
                message: document.getElementById('message').value,
                newsletter: document.getElementById('newsletter').checked,
                privacy: document.getElementById('privacy').checked
            };
            
            // Simulate form submission
            const submitBtn = this.querySelector('.btn-submit');
            const btnText = submitBtn.querySelector('.btn-text');
            const originalText = btnText.textContent;
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            
            // Simulate API call
            setTimeout(() => {
                // Show success message
                document.getElementById('successMessage').classList.add('show');
                
                // Reset form
                this.reset();
                this.classList.remove('was-validated');
                
                // Reset button
                submitBtn.disabled = false;
                btnText.innerHTML = '<i class="fas fa-check me-2"></i>Message sent!';
                submitBtn.style.background = 'var(--success-gradient)';
                
                // Restore button after 3 seconds
                setTimeout(() => {
                    btnText.innerHTML = '<i class="fas fa-paper-plane me-2"></i>' + originalText;
                    submitBtn.style.background = 'var(--secondary-gradient)';
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        document.getElementById('successMessage').classList.remove('show');
                    }, 2000);
                }, 3000);
                
                // Scroll to top of form to show success message
                document.querySelector('.contact-card').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
                
            }, 2000);
        });
        
        // Real-time validation feedback
        const inputs = document.querySelectorAll('.form-control, .form-select, .form-check-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });
        
        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('slide-up');
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        document.querySelectorAll('.contact-card, .info-card, .map-section, .faq-section').forEach(el => {
            observer.observe(el);
        });
        
        // Map click functionality
        document.querySelector('.map-placeholder').addEventListener('click', function() {
            const address = '123 Travel Avenue, 75001 Paris, France';
            const encodedAddress = encodeURIComponent(address);
            window.open(`https://www.google.com/maps/search/?api=1&query=${encodedAddress}`, '_blank');
        });
        
        // Enhanced form interactions
        document.querySelectorAll('.form-control, .form-select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Subject change handler
        document.getElementById('subject').addEventListener('change', function() {
            const messageField = document.getElementById('message');
            const subject = this.value;
            
            let placeholder = 'Describe your request in detail...';
            
            switch(subject) {
                case 'reservation':
                    placeholder = 'Please specify your travel dates, desired destination, number of people...';
                    break;
                case 'information':
                    placeholder = 'What information are you looking for? About which destination or agency?';
                    break;
                case 'complaint':
                    placeholder = 'Please describe your complaint in detail with your trip information...';
                    break;
                case 'partnership':
                    placeholder = 'Present your company and the type of partnership you are seeking...';
                    break;
            }
            
            messageField.setAttribute('placeholder', placeholder);
        });
        
        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                }
                this.value = value;
            }
        });
        
        // Social links hover effects
        document.querySelectorAll('.social-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.1) rotate(5deg)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1) rotate(0deg)';
            });
        });
        
        // FAQ Analytics (track which questions are most viewed)
        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', function() {
                const faqTitle = this.textContent.trim();
                console.log(`FAQ opened: ${faqTitle}`);
                // Here you could send analytics data to your tracking service
            });
        });
        
        // Auto-hide success message on scroll
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            const successMsg = document.getElementById('successMessage');
            if (successMsg.classList.contains('show')) {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    successMsg.classList.remove('show');
                }, 3000);
            }
        });
        
        // Initialize tooltips and popovers if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Enable Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Add entrance animations with delay
            const animatedElements = document.querySelectorAll('.slide-up');
            animatedElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
        
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        
        // Advanced form validation messages
        const customValidationMessages = {
            firstName: 'First name must contain at least 2 characters',
            lastName: 'Last name must contain at least 2 characters', 
            email: 'Please enter a valid email address',
            message: 'Message must contain at least 10 characters'
        };
        
        inputs.forEach(input => {
            input.addEventListener('invalid', function() {
                if (customValidationMessages[this.id]) {
                    this.setCustomValidity(customValidationMessages[this.id]);
                }
            });
            
            input.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        });
    </script>


@endsection