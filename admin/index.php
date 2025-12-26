<?php
require_once '../config/config.php';
// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Access | Wedding System</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-gold: #bfa181;
            --dark-accent: #1a1a1a;
            --glass-bg: rgba(255, 255, 255, 0.85);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(191, 161, 129, 0.3) 100%);
            z-index: 1;
        }

        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
            animation: fadeInScale 0.8s ease-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: var(--primary-gold);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(191, 161, 129, 0.4);
        }

        .login-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            color: var(--dark-accent);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .login-subtitle {
            color: #777;
            font-size: 0.85rem;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 500;
        }

        .input-group-custom {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group-custom label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--dark-accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-left: 5px;
        }

        .form-control-custom {
            width: 100%;
            padding: 15px 20px;
            border-radius: 50px;
            border: 1px solid #ddd;
            background: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
            transition: all 0.3s;
            color: var(--dark-accent);
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary-gold);
            background: #fff;
            box-shadow: 0 5px 15px rgba(191, 161, 129, 0.15);
        }

        .btn-login {
            background: var(--primary-gold);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 15px;
            transition: all 0.4s;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(191, 161, 129, 0.3);
        }

        .btn-login:hover {
            background: var(--dark-accent);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .login-footer {
            margin-top: 35px;
            color: #999;
            font-size: 0.8rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding-top: 25px;
        }

        .login-footer i {
            color: var(--primary-gold);
            margin: 0 5px;
        }

        /* Float animation for the card */
        .login-card {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Tablet Responsive (768px - 991px) */
        @media (max-width: 991px) and (min-width: 768px) {
            .login-wrapper {
                max-width: 420px;
            }

            .login-card {
                padding: 45px 35px;
            }

            .login-title {
                font-size: 2rem;
            }

            .brand-logo {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }
        }

        /* Mobile Responsive (max-width: 768px) */
        @media (max-width: 768px) {
            body {
                height: auto;
                min-height: 100vh;
                padding: 20px 0;
            }

            .login-wrapper {
                max-width: 100%;
                padding: 15px;
            }

            .login-card {
                padding: 40px 30px;
                border-radius: 25px;
            }

            .brand-logo {
                width: 65px;
                height: 65px;
                font-size: 1.6rem;
                margin-bottom: 20px;
            }

            .login-title {
                font-size: 1.8rem;
            }

            .login-subtitle {
                font-size: 0.75rem;
                letter-spacing: 2px;
                margin-bottom: 30px;
            }

            .input-group-custom label {
                font-size: 0.7rem;
            }

            .form-control-custom {
                padding: 12px 18px;
                font-size: 0.9rem;
            }

            .btn-login {
                padding: 13px;
                font-size: 0.95rem;
                letter-spacing: 1.5px;
            }

            .form-check-label {
                font-size: 0.85rem;
            }

            .login-footer {
                margin-top: 30px;
                padding-top: 20px;
                font-size: 0.75rem;
            }
        }

        /* Extra Small Mobile (max-width: 480px) */
        @media (max-width: 480px) {
            .login-wrapper {
                padding: 10px;
            }

            .login-card {
                padding: 35px 25px;
                border-radius: 20px;
            }

            .brand-logo {
                width: 60px;
                height: 60px;
                font-size: 1.4rem;
            }

            .login-title {
                font-size: 1.6rem;
            }

            .login-subtitle {
                font-size: 0.7rem;
                letter-spacing: 1.5px;
            }

            .form-control-custom {
                padding: 11px 16px;
                font-size: 0.85rem;
            }

            .btn-login {
                padding: 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand-logo">
                <i class="fas fa-heart"></i>
            </div>
            <h1 class="login-title">Administrator</h1>
            <p class="login-subtitle">Management Suite</p>

            <form action="../auth/login-process.php" method="post">
                <div class="input-group-custom">
                    <label for="username">User Identity</label>
                    <input type="text" class="form-control-custom" id="username" name="username"
                        placeholder="Enter username" required>
                </div>

                <div class="input-group-custom">
                    <label for="password">Security Key</label>
                    <input type="password" class="form-control-custom" id="password" name="password"
                        placeholder="Enter password" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 px-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" style="cursor:pointer">
                        <label class="form-check-label text-muted small" for="remember" style="cursor:pointer">
                            Remember Session
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-login">Unlock Dashboard</button>
            </form>

            <div class="login-footer">
                Developed with <i class="fas fa-heart"></i> for <br>
                <strong>Your Perfect Wedding Day</strong>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '<?php echo $_SESSION['error']; ?>',
                background: '#fff',
                confirmButtonColor: '#bfa181',
                iconColor: '#dc3545',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            })
        </script>
        <?php unset($_SESSION['error']); endif; ?>

</body>

</html>