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
    <title>Login Page</title>
</head>
<body>
    
    <div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="login-card">
                        <div class="login-header">
                            <h3 class="mb-0 fw-bold"><i class="fas fa-sign-in-alt me-2"></i> User Login</h3>
                            <p class="text-light mt-2 mb-0">Access your EmployeeManager dashboard</p>
                        </div>
                        <div class="login-body">
                            <form method="POST" action="{{ route('loginhandler') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="matricule" class="form-label fw-medium">Matricule</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input id="matricule" type="text" class="form-control" name="matricule" 
                                            value="{{ old('matricule', $matricule ?? '') }}" required
                                            placeholder="Enter your matricule">
                                        @isset($messageE)
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $messageE }}</strong>
                                            </span>
                                        @endisset
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-medium">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input id="password" type="password" class="form-control" name="password" 
                                            required autocomplete="current-password" placeholder="Enter your password">
                                        @isset($messageP)
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $messageP }}</strong>
                                            </span>
                                        @endisset
                                        @if (session('messagePassword'))
                                            <span class="invalid-feedback text-success d-block" role="alert">
                                                <strong>{{ session('messagePassword') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="/forgotpass" class="text-primary text-decoration-none">Forgot Password?</a>
                                </div>

                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i> Sign In
                                    </button>
                                </div>
                                <div class="text-center">
                                    <a href="/" class="text-muted small text-decoration-none">
                                       <i class="fas fa-arrow-left me-1"></i>Back to Welcome page
                                    </a>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    :root {
        --primary-color: #1a73e8;
        --primary-dark: #1557b0;
        --secondary-color: #1f2a44;
        --light-color: #f5f7fa;
        --dark-color: #1a1a1a;
        --accent-color: #34c759;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        background: white;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
    }

    .login-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 2.5rem;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
        opacity: 0.2;
    }

    .login-body {
        padding: 3rem;
    }

    .form-control {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.25);
    }

    .input-group-text {
        background: var(--light-color);
        border: 1px solid #ced4da;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--secondary-color);
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    .btn-primary {
        background: var(--primary-color);
        border: none;
        padding: 0.9rem;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .text-primary:hover {
        color: var(--primary-dark) !important;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    @media (max-width: 576px) {
        .login-body {
            padding: 2rem;
        }

        .login-header {
            padding: 2rem;
        }

        .btn-primary {
            padding: 0.75rem;
        }
    }
</style>
