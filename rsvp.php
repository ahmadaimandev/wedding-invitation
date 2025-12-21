<?php require_once 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSVP | <?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/rsvp.css">
</head>
<body>

    <div class="container-fluid min-vh-100 p-0 d-flex align-items-center justify-content-center">
        <!-- Background Elements -->
        <div class="bg-shape-1"></div>
        <div class="bg-shape-2"></div>
        
        <div class="rsvp-container row g-0 shadow-lg animate__animated animate__fadeIn">
            <!-- Left Side Image -->
            <div class="col-lg-5 d-none d-lg-block rsvp-image">
                <div class="rsvp-overlay">
                    <div class="text-center text-white p-4">
                        <h2 class="display-4 font-script mb-3">Romeo & Juliet</h2>
                        <p class="lead">We can't wait to celebrate with you!</p>
                        <hr class="w-50 mx-auto my-4 border-white opacity-50">
                        <p class="small text-uppercase letter-spacing-2">December 25, 2025</p>
                    </div>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="col-lg-7 bg-white p-4 rsvp-form-wrapper">
                <div class="text-end mb-3">
                    <a href="index.php" class="btn-close-custom"><i class="fas fa-times"></i></a>
                </div>

                <div class="text-center mb-3">
                    <span class="sub-title text-primary text-uppercase letter-spacing-2 fw-bold small">Please Join Us</span>
                    <h2 class="rsvp-title mt-2">RSVP</h2>
                </div>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form id="rsvpForm" action="rsvp-submit.php" method="POST">
                    <!-- Step 1: Personal Info -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                                <label for="email">Email Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                                <label for="phone">Phone Number</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="relationship" name="relationship" required>
                                    <option value="" selected disabled>Select Relationship</option>
                                    <option value="Family (Groom)">Family of Groom</option>
                                    <option value="Family (Bride)">Family of Bride</option>
                                    <option value="Friend (Groom)">Friend of Groom</option>
                                    <option value="Friend (Bride)">Friend of Bride</option>
                                    <option value="Colleague">Colleague</option>
                                    <option value="Other">Other</option>
                                </select>
                                <label for="relationship">Relationship</label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Attendance -->
                    <div class="mt-4 mb-3">
                        <label class="d-block text-center text-muted text-uppercase mb-3 small fw-bold">Will you be attending?</label>
                        <div class="row g-3 justify-content-center">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="attendance" id="attending-yes" value="Yes" required>
                                <label class="btn btn-outline-custom w-100 py-2" for="attending-yes">
                                    <i class="fas fa-check-circle mb-2 d-block fs-4"></i> Yes, I'll be there
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="attendance" id="attending-no" value="No">
                                <label class="btn btn-outline-custom w-100 py-2" for="attending-no">
                                    <i class="fas fa-times-circle mb-2 d-block fs-4"></i> Sorry, can't make it
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Extra Info (Conditional) -->
                    <div id="pax-container" style="display: none;" class="animate__animated animate__fadeInUp">
                        <div class="bg-light p-4 rounded-3 mb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="pax" class="form-label small text-muted text-uppercase fw-bold">Total Guests</label>
                                    <input type="number" class="form-control form-control-lg bg-white border-0" id="pax" name="pax" min="1" max="10" value="1">
                                </div>
                                <div class="col-md-8">
                                    <label for="dietary" class="form-label small text-muted text-uppercase fw-bold">Dietary Requirements</label>
                                    <input type="text" class="form-control form-control-lg bg-white border-0" id="dietary" name="dietary" placeholder="Allergies, Vegetarian, etc.">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="message" name="message" placeholder="Leave a message here" style="height: 80px"></textarea>
                        <label for="message">Message for the Couple</label>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold text-uppercase letter-spacing-2 shadow-lg hover-lift">
                        Confirm RSVP
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const yesRadio = document.getElementById('attending-yes');
        const noRadio = document.getElementById('attending-no');
        const paxContainer = document.getElementById('pax-container');
        const paxInput = document.getElementById('pax');

        function togglePax() {
            if (yesRadio.checked) {
                paxContainer.style.display = 'block';
                paxInput.setAttribute('required', 'required');
            } else {
                paxContainer.style.display = 'none';
                paxInput.removeAttribute('required');
                paxInput.value = 1;
            }
        }

        yesRadio.addEventListener('change', togglePax);
        noRadio.addEventListener('change', togglePax);
    </script>
</body>
</html>
