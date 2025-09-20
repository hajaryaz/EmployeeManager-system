@extends('RH.master')

@section('content')
<section class="main">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1e40af;
            --white: #ffffff;
            --light-blue: #eff6ff;
            --dark-blue: #1e293b;
            --gradient-blue: linear-gradient(135deg, #2563eb, #1e40af);
            --gray-bg: #f1f5f9;
            --glass: rgba(255, 255, 255, 0.9);
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --border-gray: #e5e7eb;
            --input-bg: #ffffff;
            --text-muted: #6b7280;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        .profile-container {
            max-width: 1280px;
            margin: 2rem auto;
            padding: 2.5rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: containerFade 0.8s ease-out;
        }

        @keyframes containerFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .profile-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--gradient-blue);
            border-radius: 4px;
        }

        .profile-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0;
            line-height: 1.2;
        }

        .profile-content {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .profile-picture {
            flex: 0 0 300px;
            text-align: center;
        }

        .profile-picture img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-blue);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .profile-picture img:hover {
            transform: scale(1.05);
        }

        .profile-details {
            flex: 1;
            min-width: 300px;
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .profile-details:hover {
            transform: translateY(-5px);
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: var(--dark-blue);
        }

        .detail-item i {
            color: var(--primary-blue);
            font-size: 1.2rem;
        }

        .detail-item strong {
            font-weight: 600;
            min-width: 120px;
        }

        .edit-profile-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1.5rem;
            background: var(--gradient-blue);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1.5rem;
            text-decoration: none;
        }

        .edit-profile-btn:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            position: relative;
            animation: slideInLeft 0.5s ease;
        }

        .alert-success {
            background: var(--success);
            color: var(--white);
        }

        .alert-error {
            background: var(--danger);
            color: var(--white);
        }

        .alert-dismiss {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            font-size: 1rem;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            animation: zoomIn 0.4s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-close {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--primary-blue);
            transform: rotate(90deg);
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 0.6rem;
        }

        .form-group input {
            padding: 0.85rem;
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            font-size: 1rem;
            background: var(--input-bg);
            outline: none;
            transition: var(--transition);
        }

        .form-group input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.9rem;
            margin-top: 0.4rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-submit {
            background: var(--gradient-blue);
            color: var(--white);
        }

        .btn-submit:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: var(--danger);
            color: var(--white);
        }

        .btn-cancel:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        @media (max-width: 767px) {
            .profile-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .profile-title {
                font-size: 2rem;
            }

            .profile-content {
                flex-direction: column;
                align-items: center;
            }

            .profile-picture img {
                width: 150px;
                height: 150px;
            }

            .profile-details {
                padding: 1.5rem;
            }

            .modal-content {
                padding: 2rem;
            }
        }
    </style>

    <div class="profile-container">
        <div class="profile-header">
            <h1 class="profile-title">My Profile</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button class="alert-dismiss" aria-label="Dismiss alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span>{{ session('error') }}</span>
                <button class="alert-dismiss" aria-label="Dismiss alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="profile-content">
            <div class="profile-picture">
                <img src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->nomComplet) . '&size=256&background=random' }}" alt="Profile Picture">
            </div>
            <div class="profile-details">
                <div class="detail-item">
                    <i class="fas fa-user"></i>
                    <strong>Name</strong>
                    <span>{{ $employee->nomComplet }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-id-badge"></i>
                    <strong>Function</strong>
                    <span>{{ $employee->Fonction }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-building"></i>
                    <strong>Department</strong>
                    <span>{{ $employee->Departement }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-briefcase"></i>
                    <strong>Role</strong>
                    <span>{{ $employee->profile }}</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-info-circle"></i>
                    <strong>Status</strong>
                    <span>{{ $employee->etat }}</span>
                </div>
                <a href="/profile" class="edit-profile-btn">
                    <i class="fas fa-edit"></i> View Profile
                </a>                
            </div>
        </div>
    </div>
</section>
@endsection