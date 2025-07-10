<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bank Kerta</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Preloader yang lebih menarik */
        .preloader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
        }

        .loader {
            width: 80px;
            height: 80px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-right: 5px solid #2ecc71;
            border-bottom: 5px solid #e74c3c;
            border-radius: 50%;
            animation: spin 1.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
        }

        /* Container dengan efek hover */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateZ(30px) scale(1.02);
        }

        /* Header yang lebih dinamis */
        .login-header {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 85%);
            background: linear-gradient(135deg, #3498db, #2980b9);
            position: relative;
            overflow: hidden;
        }

        /* Efek gelombang di header */
        .login-header::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            animation: rotate 20s linear infinite;
        }

        /* Form container dengan efek depth */
        .form-container {
            transform: translateZ(20px);
            position: relative;
        }

        /* Dekorasi floating yang lebih dinamis */
        .floating-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: floatAndGlow 8s infinite ease-in-out;
        }

        /* Animasi yang lebih smooth dan menarik */
        @keyframes spin {
            0% {
                transform: rotate(0deg) scale(1);
            }

            50% {
                transform: rotate(180deg) scale(1.1);
            }

            100% {
                transform: rotate(360deg) scale(1);
            }
        }

        @keyframes floatAndGlow {

            0%,
            100% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.3;
            }

            25% {
                transform: translateY(-15px) rotate(90deg) scale(1.1);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-30px) rotate(180deg) scale(1);
                opacity: 0.8;
            }

            75% {
                transform: translateY(-15px) rotate(270deg) scale(1.1);
                opacity: 0.6;
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 30px, 0);
            }

            to {
                opacity: 3;
                transform: translate3d(0, 0, 0);
            }
        }

        /* Input fields dengan animasi hover dan focus */
        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .input-field::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: 0.7s;
        }

        .input-field:focus::after {
            transform: translateX(100%);
        }

        /* Button dengan animasi yang lebih menarik */
        .login-button {
            background: linear-gradient(135deg, #3498db, #2980b9);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .login-button:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
            background: linear-gradient(135deg, #2980b9, #3498db);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        /* Animasi untuk elemen floating di background */
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg) scale(1);
            }

            25% {
                transform: translateY(-15px) rotate(5deg) scale(1.05);
            }

            50% {
                transform: translateY(-30px) rotate(-5deg) scale(1.1);
            }

            75% {
                transform: translateY(-15px) rotate(3deg) scale(1.05);
            }
        }

        /* Tambahkan efek blur gradient yang bergerak */
        @keyframes gradientBackground {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        body {
            background: linear-gradient(-45deg, #3498db, #2980b9, #2c3e50, #2980b9);
            background-size: 400% 400%;
            animation: gradientBackground 15s ease infinite;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500 flex items-center justify-center p-6">
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"><img src="{{ asset('assets/images/logos/bank_kerta.jpeg') }}" alt="loader"
                class="lds-ripple img-fluid" /></div>
    </div>

    <!-- Animated Background Elements -->
    <div class="fixed inset-0 overflow-hidden -z-10">
        <div class="floating-decoration w-64 h-64 top-10 left-10 opacity-30"></div>
        <div class="floating-decoration w-48 h-48 bottom-10 right-10 opacity-20" style="animation-delay: -2s;"></div>
        <div class="floating-decoration w-32 h-32 top-1/2 left-1/4 opacity-25" style="animation-delay: -4s;"></div>
    </div>

    <div class="w-full max-w-4xl flex flex-col md:flex-row login-container shadow-2xl">
        <!-- Left Side - Decorative Section -->
        <div class="md:w-1/2 login-header p-8 text-white relative overflow-hidden">
            <div class="relative z-10 animate-fadeInUp">

                <img src="{{ asset('assets/images/logos/bank_kerta.svg') }}" alt="Bank Kerta Logo"
                    class="h-40  mb-1 transform hover:scale-105 transition-transform duration-300">

                <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
                <p class="text-lg opacity-90">Access your account for login system.</p>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute bottom-0 right-0 transform translate-x-1/4 translate-y-1/4">
                <div class="w-64 h-64 rounded-full bg-white opacity-10"></div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="md:w-1/2 bg-white bg-opacity-10 p-8 form-container">
            <div class="card w-100 position-relative overflow-hidden">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ session('success') }}</li>
                        </ul>
                    </div>
                @endif
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2 animate-fadeInUp" style="animation-delay: 0.2s;">
                    <label for="email" class="block text-white text-sm font-medium">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="input-field w-full px-4 py-3 rounded-lg text-white placeholder-white placeholder-opacity-70 focus:outline-none"
                        placeholder="Enter your email" required>
                </div>

                <div class="space-y-2 animate-fadeInUp relative" style="animation-delay: 0.4s;">
                    <label for="password" class="block text-white text-sm font-medium">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="input-field w-full px-4 py-3 rounded-lg text-white placeholder-white placeholder-opacity-70 focus:outline-none pr-12"
                            placeholder="Enter your password" required>
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white opacity-70 hover:opacity-100 transition-opacity focus:outline-none">
                            <!-- Eye Icon (Show Password) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 show-password" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye Slash Icon (Hide Password) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hide-password hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="login-button w-full text-white font-semibold py-3 px-4 rounded-lg animate-fadeInUp"
                    style="animation-delay: 0.8s;">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script>
        // Preloader
        window.addEventListener('load', () => {
            const preloader = document.querySelector('.preloader');
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });

        // Form submission loading state
        document.querySelector('form').addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
        });
    </script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            // Get password input
            const passwordInput = document.getElementById('password');
            // Get both icons
            const showPasswordIcon = this.querySelector('.show-password');
            const hidePasswordIcon = this.querySelector('.hide-password');

            // Toggle password visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordIcon.classList.add('hidden');
                hidePasswordIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                showPasswordIcon.classList.remove('hidden');
                hidePasswordIcon.classList.add('hidden');
            }

            // Add ripple effect to button
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);

            // Remove ripple after animation
            setTimeout(() => ripple.remove(), 1000);
        });

        // Add these styles to your existing style tag
        const styleSheet = document.createElement('style');
        styleSheet.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }
    
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
        document.head.appendChild(styleSheet);
    </script>
</body>

</html>
