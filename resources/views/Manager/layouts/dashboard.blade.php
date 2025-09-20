@extends('Manager.masterma')
@section('content')
    <style>
        :root {
            --primary-blue: #310af5;
            --primary-blue-dark: #5a36fd;
            --white: #ffffff;
            --light-blue: #e8f0fe;
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #310af5, #2a09cc); /* Updated gradient */
        }

        .welcome-header {
            background: var(--white);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-blue);
        }

        .welcome-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 0.5rem;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-header p {
            color: var(--dark-blue);
            opacity: 0.7;
            font-size: 1.1rem;
        }

        .card {
            border: none;
            border-radius: 20px;
            background: var(--white);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background: var(--gradient-blue);
            color: var(--white);
            border-radius: 20px 20px 0 0;
            padding: 1.2rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .news-item {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .news-item:hover {
            background: var(--light-blue);
            transform: translateX(5px);
        }

        .news-item i {
            color: var(--primary-blue);
            margin-right: 1.2rem;
            font-size: 1.4rem;
        }

        .news-item h6 {
            margin: 0;
            font-weight: 500;
            color: var(--dark-blue);
        }

        .news-item p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--dark-blue);
        }

        .btn-primary {
            background: var(--gradient-blue);
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            color: var(--white);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-primary {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue);
            color: var(--white);
            transform: translateY(-2px);
        }

        .fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 991px) {
            .welcome-header h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 767px) {
            .welcome-header {
                padding: 1.5rem;
            }

            .welcome-header h1 {
                font-size: 1.8rem;
            }

            .card-body {
                padding: 1.2rem;
            }
        }
    </style>

    <div class="welcome-header animate__animated animate__fadeIn">
        <h1>Welcome, {{$employee->nomComplet}}</h1>
        <p>Streamline your Manager tasks with our intuitive dashboard.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="card animate__animated animate__fadeInUp">
                <div class="card-header">
                    <i class="fas fa-users me-2"></i>Active Employees
                </div>
                <div class="card-body">
                    <h5>Total Employees</h5>
                    <p class="display-5 fw-bold" style="color: var(--primary-blue);">{{$activeEmployees}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="card-header">
                    <i class="fas fa-file-alt me-2"></i>Pending Requests
                </div>
                <div class="card-body">
                    <h5>Document Requests</h5>
                    <p class="display-5 fw-bold" style="color: var(--primary-blue);">{{$documentreqs}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <div class="card-header">
                    <i class="fas fa-user-slash me-2 text-white"></i>Inactive Employees
                </div>
                <div class="card-body">
                    <h5>Employees on leave</h5>
                    <p class="display-5 fw-bold" style="color: var(--primary-blue);">{{$inactiveemployees}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                <div class="card-header">
                    <i class="fas fa-bullhorn me-2"></i>Recent News
                </div>
                <div class="card-body">
                    @foreach ($news as $item)
                    <div class="news-item">
                        <i class="fas fa-bullhorn"></i>
                        <div>
                            <h6>{{ $item->title }}</h6>
                            <p class="text-muted small">{{ \Carbon\Carbon::parse($item->published_at)->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                    <a href="/MAallnews" class="btn btn-primary mt-3">View all news</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="/alllogs" class="btn btn-outline-primary w-100 text-start py-2">
                                <i class="fas fa-history"></i> My Department's Logs
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="/MAdocumentRequests" class="btn btn-outline-primary w-100 text-start py-2">
                                <i class="fas fa-clipboard-list me-2"></i>My Department's Docs
                            </a>
                        </li>
                        <li>
                            <a href="/MAleavesRequests" class="btn btn-outline-primary w-100 text-start py-2">
                                <i class="fas fa-chart-bar me-2"></i>My Department's Leaves
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <script>
        const cards = document.querySelectorAll('.card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => observer.observe(card));
    </script>
@endsection