<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Forgot Password</title>
    <style>
        :root {
            --primary-color: #1a73e8;
            --primary-dark: #1557b0;
            --secondary-color: #1f2a44;
            --light-color: #f8fafc;
            --dark-color: #1a1a1a;
            --accent-color: #34c759;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --error-color: #dc3545;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #d1e0ff, #f0e4ff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Subtle background animation */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(26, 115, 232, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(52, 199, 89, 0.1) 0%, transparent 50%);
            animation: bgShift 15s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes bgShift {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(10px, -10px); }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border-radius: 28px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: 450px;
            width: 100%;
        }

        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.18);
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.25;
        }

        .login-header h3 {
            font-weight: 700;
            font-size: 1.8rem;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-header p {
            font-weight: 400;
            opacity: 0.85;
            position: relative;
            z-index: 1;
            font-size: 0.95rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            font-size: 0.95rem;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: var(--light-color);
            border: 1px solid #d4d9e0;
            border-right: none;
            border-radius: 14px 0 0 14px;
            color: var(--secondary-color);
            transition: background 0.3s ease, transform 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .form-control {
            border: 1px solid #d4d9e0;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: var(--light-color);
            font-size: 0.95rem;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 14px 14px 0;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.15);
            background: white;
        }

        .form-control:focus::placeholder {
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }

        .input-group:focus-within .input-group-text i {
            transform: scale(1.15);
            color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.85rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 115, 232, 0.25);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.35);
        }

        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 0.4rem;
            color: var(--error-color);
            font-weight: 400;
        }

        .animate__animated {
            animation-duration: 0.7s;
        }

        /* Accessibility improvements */
        .form-control:focus-visible {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Responsive design */
        @media (max-width: 576px) {
            .login-card {
                margin: 1.5rem;
                border-radius: 20px;
            }

            .login-header {
                padding: 1.5rem;
            }

            .login-body {
                padding: 1.5rem;
            }

            .btn-primary {
                padding: 0.7rem;
                font-size: 0.85rem;
            }

            .login-header h3 {
                font-size: 1.6rem;
            }

            .login-header p {
                font-size: 0.9rem;
            }
        }

        /* Animation keyframes */
        .login-card {
            animation: fadeInUp 0.9s ease-out;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-header h3 i {
            animation: pulse 2.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        /* Screen reader only text */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
    </style>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="login-card animate__animated animate__fadeInUp">
                        <div class="login-header">
                            <h3 class="mb-0">
                                <i class="fas fa-key"></i>
                                <span>Forgot Password</span>
                            </h3>
                            <p class="mt-2 mb-0">Enter your matricule to reset your password</p>
                        </div>
                        <div class="login-body">
                            <form method="POST" action="{{ route('handler.forgot.matricule') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="matricule" class="form-label">Matricule</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input id="matricule" type="text" class="form-control" name="matricule" 
                                            value="{{ old('matricule', $matricule ?? '') }}" required
                                            placeholder="Enter your matricule" aria-describedby="matriculeError">
                                        @isset($messageE)
                                            <span id="matriculeError" class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $messageE }}</strong>
                                            </span>
                                        @endisset
                                    </div>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle me-2"></i>Validate
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <a href="/login" class="text-muted small text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>