<?php
require_once 'config/config.php';
require_once 'config/database.php';

// Fetch Site Settings
$settings = [];
$res = $conn->query("SELECT * FROM site_settings");
while ($row = $res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

// Defaults (if not set in DB)
if (empty($settings['couple_names']))
    $settings['couple_names'] = "Romeo & Juliet";
if (empty($settings['wedding_date']))
    $settings['wedding_date'] = "2025-12-25 10:00:00";
if (empty($settings['venue_name']))
    $settings['venue_name'] = "St. George's Cathedral";
if (empty($settings['venue_address']))
    $settings['venue_address'] = "Verona, Italy";
if (empty($settings['map_link']))
    $settings['map_link'] = "https://maps.google.com";

$formatted_date = date('F d, Y', strtotime($settings['wedding_date']));
$formatted_time = date('h:i A', strtotime($settings['wedding_date']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation | <?php echo SITE_NAME; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Great+Vibes&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Favicon -->
    <?php if (!empty($settings['favicon_path'])): ?>
        <link rel="icon" type="image/<?php echo pathinfo($settings['favicon_path'], PATHINFO_EXTENSION); ?>"
            href="<?php echo htmlspecialchars($settings['favicon_path']); ?>">
    <?php else: ?>
        <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <?php endif; ?>

    <style>
        /* Infinite Scroll Marquee styles */
        .marquee-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 20px 0;
            mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
        }

        .marquee-track {
            display: flex;
            width: max-content;
            gap: 30px;
            /* Space between items */
        }

        /* Wishes Specifics */
        .wish-card {
            width: 350px;
            /* Fixed width for horizontal scroll */
            flex-shrink: 0;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-bottom: 4px solid var(--primary-color);
            transition: transform 0.3s;
        }

        .wish-card:hover {
            transform: translateY(-5px);
        }

        /* Gallery Specifics */
        .gallery-track {
            display: flex;
            width: max-content;
            gap: 15px;
        }

        .gallery-item-scroll {
            width: 300px;
            height: 400px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .gallery-item-scroll img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item-scroll:hover img {
            transform: scale(1.1);
        }
    </style>
</head>

<body id="home" style="overflow: hidden;">

    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
        <div class="preloader-text">Loading <?php echo htmlspecialchars($settings['couple_names']); ?>...</div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand script-font fs-3"
                href="#"><?php echo htmlspecialchars($settings['couple_names']); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#couple">The Couple</a></li>
                    <li class="nav-item"><a class="nav-link" href="#story">Our Story</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#wishes">Wishes</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <p class="hero-subtitle">We Are Getting Married</p>
            <h1 class="hero-title"><?php echo htmlspecialchars($settings['couple_names']); ?></h1>
            <div class="hero-date"><?php echo strtoupper($formatted_date); ?> •
                <?php echo strtoupper($settings['venue_address']); ?>
            </div>
            <div class="mt-5">
                <a href="rsvp.php" class="btn btn-outline-light rounded-pill px-5 py-2 mx-2">Save the Date</a>
            </div>
        </div>
    </header>

    <!-- The Couple -->
    <section id="couple" class="bg-white">
        <div class="container">
            <div class="section-header">
                <span class="sub">Groom & Bride</span>
                <h2>The Happy Couple</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="couple-img-wrapper gs-reveal-left">
                        <!-- Placeholder for Groom -->
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Groom" class="couple-img">
                    </div>
                    <div class="couple-text">
                        <h3>Romeo Montague</h3>
                        <p class="text-muted">The charming son of the Montague family. A lover of poetry, fine arts, and
                            endless adventures.</p>
                        <div class="socials">
                            <a href="#" class="text-muted mx-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted mx-2"><i class="fab fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center d-none d-md-block">
                    <span class="script-font fs-1" style="color: var(--dark-color);">&</span>
                </div>
                <div class="col-md-5">
                    <div class="couple-img-wrapper gs-reveal-right">
                        <!-- Placeholder for Bride -->
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Bride" class="couple-img">
                    </div>
                    <div class="couple-text">
                        <h3>Juliet Capulet</h3>
                        <p class="text-muted">The beautiful daughter of the Capulet family. Known for her wit, kindness,
                            and graceful spirit.</p>
                        <div class="socials">
                            <a href="#" class="text-muted mx-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-muted mx-2"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Parallax -->
    <section class="countdown-section">
        <div class="container">
            <h2 class="section-header text-white mb-5" style="border:none;">
                <span class="sub text-white">Counting Down</span>
                Until We Say "I Do"
            </h2>
            <div id="countdown">
                <!-- Javascript will populate this -->
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section id="story">
        <div class="container">
            <div class="section-header">
                <span class="sub">How It Happened</span>
                <h2>Our Love Story</h2>
            </div>

            <div class="row align-items-center mb-5 story-row">
                <div class="col-md-6 order-md-2">
                    <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="First Meet" class="story-img">
                </div>
                <div class="col-md-6 order-md-1 story-content">
                    <div class="story-item right">
                        <span class="badge bg-secondary mb-2">Jan 2021</span>
                        <h3>First Meeting</h3>
                        <p class="text-muted">We met at a masquerade ball. Eyes locked across the room, and the rest is
                            history. It was truly love at first sight.</p>
                    </div>
                </div>
            </div>

            <div class="row align-items-center story-row">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Proposal" class="story-img">
                </div>
                <div class="col-md-6 story-content">
                    <div class="story-item">
                        <span class="badge bg-secondary mb-2">Dec 2024</span>
                        <h3>The Proposal</h3>
                        <p class="text-muted">Under the balcony in Verona, Romeo knelt down and asked the question. With
                            tears of joy, the answer was a resounding YES!</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Events -->
    <section id="events" class="bg-white">
        <div class="container">
            <div class="section-header">
                <span class="sub">The Agenda</span>
                <h2>Wedding Events</h2>
            </div>

            <!-- Ceremony -->
            <div class="row align-items-center mb-5 story-row">
                <div class="col-md-6 order-md-2">
                    <img src="https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Wedding Ceremony" class="story-img">
                </div>
                <div class="col-md-6 order-md-1 story-content">
                    <div class="story-item right">
                        <span class="badge bg-primary mb-3" style="font-size: 0.9rem;">10:00 AM - 12:00 PM</span>
                        <h3>Main Ceremony</h3>
                        <p class="text-muted mb-3 fst-italic">St. George's Cathedral, Verona</p>

                        <ul class="list-unstyled text-muted text-end">
                            <li class="mb-2"><strong class="text-dark">10:00 AM</strong> — Guest Arrival & Seating</li>
                            <li class="mb-2"><strong class="text-dark">10:30 AM</strong> — Bride & Groom Entrance</li>
                            <li class="mb-0"><strong class="text-dark">12:00 PM</strong> — Ceremony Concludes</li>
                        </ul>
                        <div class="mt-4">
                            <a href="https://maps.google.com" target="_blank"
                                class="btn btn-outline-dark rounded-pill px-4">View Map</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reception -->
            <div class="row align-items-center story-row">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Wedding Party" class="story-img">
                </div>
                <div class="col-md-6 story-content">
                    <div class="story-item">
                        <span class="badge bg-primary mb-3" style="font-size: 0.9rem;">01:00 PM - 05:00 PM</span>
                        <h3>Wedding Party</h3>
                        <p class="text-muted mb-3 fst-italic">Grand Hotel Palace</p>

                        <ul class="list-unstyled text-muted text-start">
                            <li class="mb-2"><strong class="text-dark">01:00 PM</strong> — Welcome Cocktail</li>
                            <li class="mb-2"><strong class="text-dark">01:30 PM</strong> — Grand Entrance of the Couple
                            </li>
                            <li class="mb-0"><strong class="text-dark">05:00 PM</strong> — Farewell & Send-off</li>
                        </ul>
                        <div class="mt-4">
                            <a href="https://maps.google.com" target="_blank"
                                class="btn btn-outline-dark rounded-pill px-4">View Map</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Gallery Section (Infinite Scroll) -->
    <section id="gallery">
        <div class="container-fluid">
            <div class="section-header">
                <span class="sub">Memories</span>
                <h2>Captured Moments</h2>
            </div>

            <div class="marquee-container" style="padding: 0 0 50px 0;">
                <div class="marquee-track" id="galleryTrack">
                    <!-- Dynamic Gallery Items -->
                    <?php
                    $gallery_res = $conn->query("SELECT * FROM gallery WHERE status = 'visible' ORDER BY display_order ASC, created_at DESC");
                    if ($gallery_res->num_rows > 0):
                        while ($img = $gallery_res->fetch_assoc()):
                            ?>
                            <div class="gallery-item-scroll">
                                <img src="<?php echo $img['image_path']; ?>"
                                    alt="<?php echo htmlspecialchars($img['caption']); ?>">
                            </div>
                            <?php
                        endwhile;
                    else:
                        // No images found
                        ?>
                        <div class="d-flex align-items-center justify-content-center w-100" style="min-height: 200px;">
                            <p class="text-muted fst-italic">No photos shared yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </section>

    <!-- Dynamic Wishes Section (Infinite Scroll) -->
    <section id="wishes" class="bg-light overflow-hidden">
        <div class="container-fluid">
            <div class="section-header">
                <span class="sub">Warm Words</span>
                <h2>Wishes from Guests</h2>
            </div>

            <div class="marquee-container">
                <div class="marquee-track" id="wishesTrack">
                    <?php
                    // Fetch latest 10 messages for a better scroll loop
                    require_once 'config/database.php';
                    $wishes = $conn->query("SELECT name, message, submitted_at FROM rsvp WHERE message IS NOT NULL AND message != '' AND status = 'approved' ORDER BY submitted_at DESC LIMIT 10");

                    if ($wishes->num_rows > 0):
                        while ($wish = $wishes->fetch_assoc()):
                            ?>
                            <div class="wish-card d-flex flex-column">
                                <i class="fas fa-quote-left text-muted mb-3 fs-4"></i>
                                <p class="fst-italic text-muted mb-3 flex-grow-1">
                                    "<?php echo htmlspecialchars($wish['message']); ?>"</p>
                                <div class="d-flex align-items-center mt-auto">
                                    <div class="wish-avatar bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold"
                                        style="width: 40px; height: 40px;">
                                        <?php echo strtoupper(substr($wish['name'], 0, 1)); ?>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($wish['name']); ?></h6>
                                        <small class="text-muted"
                                            style="font-size: 0.75rem;"><?php echo date('M d', strtotime($wish['submitted_at'])); ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    else:
                        // No wishes found
                        ?>
                        <div class="d-flex align-items-center justify-content-center w-100" style="min-height: 150px;">
                            <p class="text-muted fst-italic">No wishes received yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-5" id="rsvp" data-aos="zoom-in" data-aos-duration="1000">
                <div class="card bg-white d-inline-block border-0 shadow-lg p-5 rsvp-cta-card">
                    <h2 class="mb-3">Are You Attending?</h2>
                    <p class="text-muted mb-4">Please confirm your presence by December 1st, 2025</p>
                    <a href="rsvp.php" class="btn btn-lg btn-dark rounded-pill px-5">RSVP Online</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <!-- Col 1: Brand -->
                <div class="col-lg-4 col-md-6">
                    <h2 class="footer-names mb-3"><?php echo htmlspecialchars($settings['couple_names']); ?></h2>
                    <p class="text-muted mb-4">"We are so excited to celebrate our special day with our family and
                        friends. Thank you for your love and support."</p>
                    <p class="fst-italic text-muted"><?php echo $formatted_date; ?></p>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-dark text-uppercase tracking-wider mb-4" style="font-size: 0.9rem;">Quick Links
                    </h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><a href="#home" class="text-reset text-decoration-none hover-white">Home</a>
                        </li>
                        <li class="mb-2"><a href="#couple" class="text-reset text-decoration-none hover-white">The
                                Couple</a></li>
                        <li class="mb-2"><a href="#story" class="text-reset text-decoration-none hover-white">Our
                                Story</a></li>
                        <li class="mb-2"><a href="#events"
                                class="text-reset text-decoration-none hover-white">Events</a></li>
                        <li class="mb-2"><a href="rsvp.php" class="text-reset text-decoration-none hover-white">RSVP</a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Family Contact -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-dark text-uppercase tracking-wider mb-4" style="font-size: 0.9rem;">Family Contacts
                    </h5>
                    <div class="mb-3">
                        <h6 class="text-dark mb-1">Manoteague Family</h6>
                        <p class="text-muted small mb-0"><i class="fas fa-phone me-2"></i> +39 123 456 789</p>
                    </div>
                    <div>
                        <h6 class="text-dark mb-1">Capulet Family</h6>
                        <p class="text-muted small mb-0"><i class="fas fa-phone me-2"></i> +39 987 654 321</p>
                    </div>
                </div>

                <!-- Col 4: Location -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-dark text-uppercase tracking-wider mb-4" style="font-size: 0.9rem;">Location</h5>
                    <p class="text-muted mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <?php echo htmlspecialchars($settings['venue_name']); ?><br>
                        <span class="ms-4"><?php echo htmlspecialchars($settings['venue_address']); ?></span>
                    </p>
                    <a href="<?php echo htmlspecialchars($settings['map_link']); ?>" target="_blank"
                        class="text-primary text-decoration-none small hover-white ms-4 mb-4 d-inline-block">Get
                        Directions &rarr;</a>

                    <div class="social-links fs-5">
                        <a href="#" class="text-reset me-3 hover-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-reset me-3 hover-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-reset me-3 hover-white"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-5 w-100 opacity-25">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0">&copy; <?php echo date('Y'); ?>
                        <?php echo htmlspecialchars($settings['couple_names']); ?>.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small text-muted mb-0">Designed with <i class="fas fa-heart text-danger"></i> for You.</p>
                </div>
            </div>
        </div>
    </footer>


    <!-- Back to Top Button -->
    <button id="backToTop" class="d-flex align-items-center justify-content-center">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            once: true,
            offset: 100,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        gsap.registerPlugin(ScrollTrigger);

        // Back to Top Logic
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize Swiper for Wishes
        var wishesSwiper = new Swiper(".wishesSwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            freeMode: true,
            speed: 5000, // Slow speed for continuous effect
            allowTouchMove: false, // Optional: disable touch to keep it strictly auto
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });

        // Initialize Swiper for Gallery
        var gallerySwiper = new Swiper(".gallerySwiper", {
            slidesPerView: 2,
            spaceBetween: 15,
            loop: true,
            freeMode: true,
            speed: 5000,
            allowTouchMove: false,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 20,
                },
            },
        });

        // Initialize GLightbox
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            autoplayVideos: true
        });

        // Countdown Timer
        const weddingDate = new Date("<?php echo date('M d, Y H:i:s', strtotime($settings['wedding_date'])); ?>").getTime();
        const countdownContainer = document.getElementById('countdown');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownContainer.innerHTML = `
                <div class="countdown-item"><span class="countdown-number">${days}</span><span class="countdown-label">Days</span></div>
                <div class="countdown-item"><span class="countdown-number">${hours}</span><span class="countdown-label">Hours</span></div>
                <div class="countdown-item"><span class="countdown-number">${minutes}</span><span class="countdown-label">Mins</span></div>
                <div class="countdown-item"><span class="countdown-number">${seconds}</span><span class="countdown-label">Secs</span></div>
            `;
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Infinite Marquee Logic
        function initMarquee(trackId, speed = 20) {
            const track = document.getElementById(trackId);
            if (!track) return;

            const container = track.parentElement;
            const originalContent = track.innerHTML;

            // If there are very few items, we check if they even fill the screen
            // We only want to duplicate and scroll if the content overflows or we want that "infinite" feel

            // For a seamless loop, we need at least 2 copies
            track.innerHTML = originalContent + originalContent;

            // Simple check: if the total width is still too small, duplicate again
            if (track.offsetWidth < container.offsetWidth * 2) {
                track.innerHTML = originalContent + originalContent + originalContent + originalContent;
            }

            const totalWidth = track.scrollWidth / 2; // Width of one "set"

            gsap.to(track, {
                x: -totalWidth,
                ease: "none",
                duration: speed,
                repeat: -1,
                onRestart: () => {
                    // This ensures it perfectly resets even if window resized
                    gsap.set(track, { x: 0 });
                }
            });
        }

        // Initialize Marquees
        window.onload = function () {
            // Force scroll to top (Home)
            if (history.scrollRestoration) {
                history.scrollRestoration = 'manual';
            }
            window.scrollTo(0, 0);

            // Hide Preloader
            const preloader = document.getElementById('preloader');
            preloader.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scroll

            // Start Marquees
            setTimeout(() => {
                initMarquee('wishesTrack', 40); // Slower for text reading
                initMarquee('galleryTrack', 30); // Moderate for images
            }, 500); // Slight delay to ensure layout
        };

        // GSAP Animations

        // 1. Navbar Solidify
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });

        // 2. Hero Content Reveal
        gsap.to('.hero-content', {
            opacity: 1,
            y: 0,
            duration: 1.5,
            ease: "power3.out",
            delay: 0.5
        });

        // 3. Hero Parallax
        gsap.to(".hero-bg", {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: ".hero-section",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });

        // 4. Couple Image Reveals
        gsap.utils.toArray('.couple-img-wrapper').forEach(img => {
            gsap.to(img, {
                opacity: 1,
                y: 0,
                duration: 1,
                scrollTrigger: {
                    trigger: img,
                    start: "top 80%",
                }
            });
        });

        gsap.utils.toArray('.couple-text').forEach(text => {
            gsap.to(text, {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: 0.3,
                scrollTrigger: {
                    trigger: text,
                    start: "top 80%",
                }
            });
        });

        // 5. Story Timeline Slide-in
        gsap.utils.toArray('.story-row').forEach(row => {
            const img = row.querySelector('.story-img');
            const content = row.querySelector('.story-content');

            gsap.to(img, {
                opacity: 1,
                x: 0,
                duration: 1,
                scrollTrigger: { trigger: row, start: "top 75%" }
            });
            gsap.to(content, {
                opacity: 1,
                x: 0,
                duration: 1,
                delay: 0.2,
                scrollTrigger: { trigger: row, start: "top 75%" }
            });
        });

        // 6. Event Cards Stagger
        gsap.to('.event-card', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.2,
            scrollTrigger: {
                trigger: '#events',
                start: "top 70%"
            }
        });

        // 7. Gallery Fade In
        gsap.to('.gallery-item', {
            opacity: 1,
            duration: 1,
            stagger: 0.1,
            scrollTrigger: {
                trigger: '#gallery',
                start: "top 80%"
            }
        });

        // 8. Section Headers Reveal
        gsap.utils.toArray('.section-header').forEach(header => {
            gsap.from(header.querySelectorAll('.sub, h2'), {
                y: 30,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                scrollTrigger: {
                    trigger: header,
                    start: "top 85%"
                }
            });
        });

        // 9. Countdown Pop-in
        gsap.from('.countdown-item', {
            scale: 0.5,
            opacity: 0,
            duration: 0.8,
            stagger: 0.2,
            ease: "back.out(1.7)",
            scrollTrigger: {
                trigger: '.countdown-section',
                start: "top 75%"
            }
        });

        // 10. RSVP Card/Button Pulse
        gsap.from('.rsvp-cta-card, .btn-lg', {
            y: 30,
            opacity: 0,
            duration: 1,
            delay: 0.5,
            scrollTrigger: {
                trigger: '#rsvp',
                start: "top 90%"
            }
        });

        // 11. Footer Content Stagger
        gsap.from('footer .col-lg-4, footer .col-lg-2, footer .col-lg-3', {
            y: 50,
            opacity: 0,
            duration: 1,
            stagger: 0.2,
            scrollTrigger: {
                trigger: 'footer',
                start: "top 90%"
            }
        });

        // 12. Button Hover Scale
        gsap.utils.toArray('.btn').forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                gsap.to(btn, { scale: 1.05, duration: 0.3 });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { scale: 1, duration: 0.3 });
            });
        });
    </script>
</body>

</html>