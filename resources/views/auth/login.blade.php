<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: rgb(188, 86, 86);
            --accent-color: #ff6b7a;
            --light-color: #ffffff;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --transition-speed: 0.3s;
            --shadow-light: rgba(220, 53, 69, 0.1);
            --shadow-medium: rgba(220, 53, 69, 0.2);
            --shadow-dark: rgba(220, 53, 69, 0.3);
            --success-color: #28a745;
        }

        * {
            margin: 0px;
            padding: 0px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-color);
            position: relative;
            overflow: hidden;
        }

        .area {
            background: linear-gradient(to left, var(--primary-color), var(--light-color));
            width: 100%;
            height: 100vh;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .circles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circles li {
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.3);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }

        .circles li:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .circles li:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        .main-content-wrapper {
            max-width: 1200px;
            width: 90%;
            margin: 2rem auto;
            display: flex;
            gap: 2rem;
            align-items: stretch;
            z-index: 1;
            position: relative;
        }

        /* --- Login Card Section --- */
        .login-card-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 8px 20px var(--shadow-light);
            background: var(--light-color);
            transition: all var(--transition-speed) ease;
        }

        .login-card-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15), 0 10px 25px var(--shadow-medium);
        }

        .hero-section {
            padding: 4rem 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #8A2D3B;
            position: relative;
            overflow: hidden;
            border-radius: 30px 30px 0 0;
            min-height: 200px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-section h1 {
            font-weight: 700;
            font-size: 3.2rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            background: linear-gradient(45deg, #ffffff, #ffe6e8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section p {
            font-weight: 400;
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .login-form-content {
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--light-color);
            border-radius: 0 0 30px 30px;
            flex-grow: 1;
        }

        .form-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .form-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: block;
            text-shadow: 2px 2px 4px var(--shadow-light);
            animation: pulse 2s ease-in-out infinite;
        }

        .form-floating {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-control {
            height: 60px;
            padding: 1.8rem 1rem 0.5rem 1rem;
            border-radius: 15px;
            border: 2px solid #e9ecef;
            font-size: 1rem;
            transition: all var(--transition-speed) ease;
            background-color: #fafbfc;
            font-weight: 400;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem var(--shadow-light), 0 4px 12px var(--shadow-medium);
            background-color: var(--light-color);
            transform: translateY(-2px);
        }

        .form-floating label {
            padding-left: 1rem;
            color: var(--gray-color);
            font-weight: 500;
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus ~ label,
        .form-control:not(:placeholder-shown) ~ label {
            color: var(--primary-color);
            transform: scale(0.85) translateY(-0.5rem);
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--gray-color);
            z-index: 5;
            transition: all var(--transition-speed) ease;
            padding: 0.5rem;
            border-radius: 8px;
        }

        .password-toggle:hover {
            color: var(--primary-color);
            background-color: var(--shadow-light);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            border: none;
            border-radius: 15px;
            font-weight: 600;
            padding: 1rem;
            font-size: 1.1rem;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 6px 20px var(--shadow-medium);
            margin-top: 1.5rem;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 50%, var(--secondary-color) 100%);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px var(--shadow-dark);
        }

        .btn-login:active {
            transform: translateY(-1px) scale(1.01);
        }

        .animate-zoom-in {
            animation: zoomIn 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.9) rotateY(10deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotateY(0deg);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) rotateX(10deg);
            }
            to {
                opacity: 1;
                transform: translateY(0) rotateX(0deg);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .toast {
            background: var(--light-color);
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: var(--dark-color);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
        }

        .toast-success {
            background: var(--success-color);
            color: var(--light-color);
            border-left: 6px solid #1d8236;
        }

        .toast-error {
            background: var(--primary-color);
            color: var(--light-color);
            border-left: 6px solid #b02a37;
        }

        .toast-title {
            font-weight: 600;
            color: var(--light-color);
        }

        .toast-message {
            color: var(--light-color);
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-weight: 500;
            padding: 1rem 1.5rem;
            margin-top: 1rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: var(--secondary-color);
            border-left: 4px solid var(--primary-color);
        }

        .invalid-feedback {
            color: var(--primary-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .form-control.is-invalid {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem var(--shadow-light);
        }

        /* --- Right Content Section (Separate) --- */
        .right-display-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 8px 20px rgba(0, 0, 0, 0.05);
            /* Remove hover transform for this section if you want no animation */
            /* transition: all var(--transition-speed) ease; */
        }

        /* If you want to remove hover effect completely from right side: */
        /* .right-display-section:hover {
            transform: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 8px 20px rgba(0, 0, 0, 0.05);
        } */


        .right-display-section h2 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            line-height: 1.2;
            text-shadow: 2px 2px 6px var(--shadow-medium);
        }

        /* Styling for the music player */
        .music-player {
            margin-top: 2rem;
            width: 100%;
            max-width: 350px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); /* Gradient background like hero section */
            border-radius: 15px;
            padding: 15px 20px; /* Adjust padding */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Stronger shadow */
            transition: all var(--transition-speed) ease;
            outline: none; /* Remove default outline */
        }

        /* Style for the audio controls themselves */
        .music-player::-webkit-media-controls-panel {
            background-color: transparent; /* Make controls background transparent */
            color: var(--light-color); /* Control icons color */
        }

        .music-player::-webkit-media-controls-play-button,
        .music-player::-webkit-media-controls-current-time-display,
        .music-player::-webkit-media-controls-time-remaining-display,
        .music-player::-webkit-media-controls-timeline,
        .music-player::-webkit-media-controls-volume-slider,
        .music-player::-webkit-media-controls-volume-button {
            color: var(--light-color);
            filter: drop-shadow(1px 1px 2px rgba(0, 0, 0, 0.3)); /* Subtle shadow for controls */
        }

        .music-player::-webkit-media-controls-timeline {
            background-color: rgba(255, 255, 255, 0.3); /* Progress bar background */
            border-radius: 5px;
        }

        .music-player::-webkit-media-controls-volume-slider {
            background-color: rgba(255, 255, 255, 0.3); /* Volume slider background */
            border-radius: 5px;
        }

        /* Firefox styling (less granular control) */
        .music-player {
            /* For Firefox, basic styling will apply to the whole control */
            color: var(--light-color); /* This might affect text elements in controls */
        }


        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .main-content-wrapper {
                flex-direction: column;
                margin: 1rem;
                width: calc(100% - 2rem);
                gap: 1.5rem;
            }

            .login-card-section {
                border-radius: 30px;
            }

            .hero-section {
                border-radius: 30px 30px 0 0;
            }

            .login-form-content {
                border-radius: 0 0 30px 30px;
            }

            .right-display-section {
                border-radius: 30px;
                padding: 2rem;
            }

            .right-display-section h2 {
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
            }

            .hero-section h1 {
                font-size: 2.5rem;
            }

            .hero-content {
                flex-direction: column;
            }

            .hero-content h1 {
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .hero-content img {
                margin-top: 0.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section, .login-form-content, .right-display-section {
                padding: 2rem 1.5rem;
            }

            .form-control {
                height: 55px;
                font-size: 0.95rem;
            }

            .btn-login {
                height: 55px;
                font-size: 1rem;
            }

            .right-display-section h2 {
                font-size: 2rem;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--shadow-light);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="area">
        <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="main-content-wrapper animate-zoom-in">
        <div class="login-card-section">
            <div class="hero-section">
                <div class="hero-content">
                    <h1 class="animate-slide-up">BudiSpeed!</h1>
                    <img src="{{ asset('images/budilogo.png') }}" alt="Logo" class="animate-slide-up" style="height: 70px; width: auto;">
                </div>
                <p class="animate-slide-up text-center mt-3">Hanya Untuk Arek Suroboyo!!!</p>
            </div>
            <div class="login-form-content">
                <div class="form-header animate-slide-up">
                    <i class="fas fa-store"></i>
                </div>
                <form id="loginForm" class="login-form" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="form-floating animate-slide-up">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                        <label for="username">Username</label>
                        @error('username')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating animate-slide-up">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                        <label for="password">Password</label>
                        <i class="far fa-eye password-toggle" id="togglePassword"></i>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-login w-100 animate-slide-up text-white" type="submit">
                        <span>Masuk</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="right-display-section">
            <h2>Login kalau kamu admin e</h2>
            <audio controls class="music-player">
                <source src="{{ asset('music/lagu_anda.mp3') }}" type="audio/mpeg">
                Browser Anda tidak mendukung elemen audio.
            </audio>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Toastr configuration
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "5000",
            extendedTimeOut: "2000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };

        // Password toggle functionality
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        // Enhanced form input animations
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentNode.classList.remove('focused');
                }
            });

            // Check initial state
            if (input.value) {
                input.parentNode.classList.add('focused');
            }
        });

        // Enhanced form submission with better UX
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            const button = this.querySelector('button');
            const loadingOverlay = document.getElementById('loadingOverlay');

            // Clear previous alerts
            const existingAlert = document.querySelector('.alert:not(.invalid-feedback)');
            if (existingAlert) existingAlert.remove();

            // Client-side validation
            if (!username || !password) {
                const alert = document.createElement('div');
                alert.className = 'alert alert-danger mt-3 fade show';
                alert.style.animation = 'fadeIn 0.3s ease';
                alert.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Harap isi nama pengguna dan kata sandi.';
                this.appendChild(alert);

                if (!username) document.getElementById('username').focus();
                else document.getElementById('password').focus();

                setTimeout(() => alert.remove(), 4000);
                return;
            }

            // Show loading state
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            loadingOverlay.style.display = 'flex';

            // AJAX submission
            $.ajax({
                url: this.action,
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    loadingOverlay.style.display = 'none';
                    button.disabled = false;
                    button.innerHTML = '<span>Masuk</span><i class="fas fa-check ms-2"></i>';
                    button.style.background = 'linear-gradient(135deg, #28a745, #20c997)';

                    toastr.success(response.message || 'Login berhasil! Mengalihkan...', 'Sukses');

                    setTimeout(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    }, 1500);
                },
                error: function(xhr) {
                    loadingOverlay.style.display = 'none';
                    button.disabled = false;
                    button.innerHTML = '<span>Masuk</span><i class="fas fa-arrow-right ms-2"></i>';

                    console.log('Error response:', xhr);

                    const response = xhr.responseJSON || {};
                    const errorMessage = response.errors?.username?.[0] || response.message || 'Username atau password salah. Silakan coba lagi.';

                    toastr.error(errorMessage, 'Login Gagal');

                    if (response.errors?.username) {
                        document.getElementById('username').focus();
                    } else {
                        document.getElementById('password').focus();
                    }

                    button.style.animation = 'shake 0.5s ease-in-out';
                    setTimeout(() => {
                        button.style.animation = '';
                    }, 500);
                }
            });
        });

        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
        `;
        document.head.appendChild(style);

        // Display session-based messages
        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Sukses');
        @endif
        @if(session('error'))
            toastr.error('{{ session('error') }}', 'Error');
        @endif

        // Apply entrance animations only to the login card elements
        window.addEventListener('load', function() {
            const loginCardElements = document.querySelectorAll('.login-card-section .animate-slide-up, .main-content-wrapper.animate-zoom-in');
            loginCardElements.forEach((element, index) => {
                // Ensure animation only applies to elements that still have the class
                if (element.classList.contains('animate-slide-up') || element.classList.contains('animate-zoom-in')) {
                    element.style.animationDelay = `${index * 0.15}s`; // Slightly reduce delay for faster effect
                }
            });
        });
    </script>
</body>
</html>