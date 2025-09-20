<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-color: #1a73e8;
            --primary-dark: #1557b0;
            --secondary-color: #1f2a44;
            --light-color: #f5f7fa;
            --dark-color: #1a1a1a;
            --accent-color: #34c759;
            --warning-color: #ff9500;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-color);
            line-height: 1.7;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }

        .navbar {
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: var(--primary-color);
            margin-right: 0.5rem;
        }

        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 50%;
        }

        .navbar-nav {
            gap: 0.5rem;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 8rem 0 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjEpIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI3BhdHRlcm4pIi8+PC9zdmc+');
            opacity: 0.15;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
        }

        .hero-img {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            max-width: 80%;
            transition: transform 0.5s ease;
        }

        .hero-img:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.8rem 1.8rem;
            font-weight: 500;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-light {
            border-color: white;
            color: white;
            padding: 0.8rem 1.8rem;
            border-radius: 50px;
            font-weight: 500;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
        }

        .features-section {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            font-weight: 700;
            font-size: 2.2rem;
            position: relative;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .feature-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-title {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.8rem;
        }

        .role-features {
            padding: 5rem 0;
            background: var(--light-color);
        }

        .role-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .role-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .role-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .role-title {
            font-weight: 600;
            font-size: 1.4rem;
            color: var(--secondary-color);
        }

        .role-list {
            list-style: none;
            padding: 0;
        }

        .role-list li {
            margin-bottom: 0.6rem;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .role-list li i {
            color: var(--accent-color);
            margin-right: 0.6rem;
        }

        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer a {
            color: var(--light-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--accent-color);
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1.2rem;
        }

        .social-icons a {
            font-size: 1.1rem;
            margin-right: 0.8rem;
            transition: transform 0.3s ease;
        }

        .social-icons a:hover {
            transform: translateY(-2px);
        }

        .fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .hero-section {
                padding: 4rem 0 3rem;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .hero-img {
                margin-top: 1.5rem;
                max-width: 100%;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .feature-card,
            .role-card {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 767px) {
            .navbar-brand {
                font-size: 1.4rem;
            }

            .btn-primary,
            .btn-outline-light {
                padding: 0.6rem 1.2rem;
            }

            .footer {
                text-align: center;
            }

            .footer .social-icons {
                justify-content: center;
            }

            .navbar-nav {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-users-cog"></i>
                Employee<span style="color: var(--primary-color);">Manager</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expandedPlug 'n' Play="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roles">Roles</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 animate__animated animate__fadeIn">
                    <h1 class="hero-title">Empower Your Workforce</h1>
                    <p class="hero-text">Streamline HR processes with our comprehensive platform for efficient employee management, onboarding, and compliance.</p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                        <a href="#features" class="btn btn-outline-light">Explore Features</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0 text-center animate__animated animate__fadeInRight" style="animation-delay: 0.3s;">
                    <img src="{{ asset('images/homeIMG.jpg') }}" alt="Employee Management" class="hero-img">
                </div>
            </div>
        </div>
    </section>
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title animate__animated animate__fadeInUp">Core Features</h2>
                <p class="text-muted lead animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">Comprehensive tools to manage your workforce efficiently</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                            <h4 class="feature-title">Employee Profiles</h4>
                            <p class="text-muted">Centralized hub for employee information, including personal details and documents.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
                            <h4 class="feature-title">Presence Tracking</h4>
                            <p class="text-muted">Real-time attendance monitoring with detailed reporting and analytics.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-briefcase"></i></div>
                            <h4 class="feature-title">Leave Management</h4>
                            <p class="text-muted">Streamlined leave request submissions, approvals, and status tracking.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                            <h4 class="feature-title">Document Management</h4>
                            <p class="text-muted">Secure storage and organization for employee documents and contracts.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-user-plus"></i></div>
                            <h4 class="feature-title">Onboarding</h4>
                            <p class="text-muted">Seamless onboarding process with guided steps for new employees.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 1s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                            <h4 class="feature-title">Secure Access</h4>
                            <p class="text-muted">Role-based permissions and audit logs for enhanced data security.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 1.2s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-clock"></i></div>
                            <h4 class="feature-title">Schedule Management</h4>
                            <p class="text-muted">Efficient scheduling tools for shifts and work hours.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 1.4s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-bell"></i></div>
                            <h4 class="feature-title">News & Updates</h4>
                            <p class="text-muted">Centralized platform for sharing company news and announcements.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 1.6s;">
                        <div class="text-center">
                            <div class="feature-icon"><i class="fas fa-history"></i></div>
                            <h4 class="feature-title">Activity Logging</h4>
                            <p class="text-muted">Comprehensive logs of system activities for transparency.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="roles" class="role-features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title animate__animated animate__fadeInUp">Tailored for Every Role</h2>
                <p class="text-muted lead animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">Customized features for employees, managers, and HR</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="role-card animate__animated animate__fadeInUp">
                        <div class="role-icon"><i class="fas fa-user"></i></div>
                        <h4 class="role-title">Employee Portal</h4>
                        <ul class="role-list">
                            <li><i class="fas fa-check-circle"></i>Update personal profile details</li>
                            <li><i class="fas fa-check-circle"></i>Track daily attendance</li>
                            <li><i class="fas fa-check-circle"></i>Submit and manage leave requests</li>
                            <li><i class="fas fa-check-circle"></i>Monitor leave request status</li>
                            <li><i class="fas fa-check-circle"></i>Access and download HR documents</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="role-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="role-icon"><i class="fas fa-user-tie"></i></div>
                        <h4 class="role-title">Manager Dashboard</h4>
                        <ul class="role-list">
                            <li><i class="fas fa-check-circle"></i>View and manage team profiles</li>
                            <li><i class="fas fa-check-circle"></i>Monitor team attendance records</li>
                            <li><i class="fas fa-check-circle"></i>Review and approve leave requests</li>
                            <li><i class="fas fa-check-circle"></i>Create and manage team schedules</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="role-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                        <div class="role-icon"><i class="fas fa-users-cog"></i></div>
                        <h4 class="role-title">HR Administration</h4>
                        <ul class="role-list">
                            <li><i class="fas fa-check-circle"></i>Add, edit, or remove employee data</li>
                            <li><i class="fas fa-check-circle"></i>Organize and secure employee documents</li>
                            <li><i class="fas fa-check-circle"></i>Facilitate new employee onboarding</li>
                            <li><i class="fas fa-check-circle"></i>Review system activity logs</li>
                            <li><i class="fas fa-check-circle"></i>Publish company news and updates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">EmployeeManager</h5>
                    <p class="text-light">Streamlined HR and workforce management solution.</p>
                    <div class="social-icons d-flex gap-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Home</a></li>
                        <li class="mb-2"><a href="#features">Features</a></li>
                        <li class="mb-2"><a href="#roles">Roles</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Contact Info</h5>
                    <ul class="list-unstyled text-light">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 112 Hamriya , Meknes </li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (212) 706706551</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@employeemanager.com</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3">Quick Tips</h5>
                    <ul class="list-unstyled text-light">
                        <li>✔ Keep your profile updated</li>
                        <li>✔ Explore all features</li>
                        <li>✔ Contact support for help</li>
                        <li>✔ Follow us for updates</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light opacity-25">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-light">© 2025 EmployeeManager. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-light">Crafted for HR Excellence</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>