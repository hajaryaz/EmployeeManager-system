@extends('Employe.masteremp')

@section('content')
<section class="main">
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1e40af;
            --white: #ffffff;
            --light-blue: #eff6ff;
            --dark-blue: #1e293b;
            --gradient-blue: linear-gradient(135deg, #2563eb, #1e40af);
            --gray-bg: #f8fafc;
            --glass: rgba(255, 255, 255, 0.85);
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            --border-gray: #e2e8f0;
            --input-bg: #f9fafb;
            --text-muted: #64748b;
            --transition: all 0.3s ease;
        }

        .employees-container {
            max-width: 1280px;
            margin: 2rem auto;
            padding: 2.5rem;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: containerFade 0.6s ease;
        }

        @keyframes containerFade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .employees-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .employees-header::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--gradient-blue);
            border-radius: 3px;
        }

        .employees-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0;
            line-height: 1.3;
        }

        .employees-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .employees-table thead {
            background: var(--light-blue);
        }

        .employees-table th {
            padding: 1.25rem;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark-blue);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border-gray);
        }

        .employees-table tbody tr {
            transition: var(--transition);
            animation: rowFade 0.5s ease;
        }

        @keyframes rowFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .employees-table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-1px);
        }

        .employees-table td {
            padding: 1.25rem;
            font-size: 0.95rem;
            color: var(--dark-blue);
            border-bottom: 1px solid var(--border-gray);
            vertical-align: middle;
        }

        .employee-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-gray);
            transition: var(--transition);
        }

        .employee-photo:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .profile-badge {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .profile-employe {
            background: #fef3c7;
            color: #d97706;
        }

        .profile-rh {
            background: #dcfce7;
            color: #15803d;
        }

        .profile-manager {
            background: #dbeafe;
            color: #1e40af;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-edit {
            background: var(--gradient-blue);
            color: var(--white);
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-edit:hover {
            transform: translateY(-1px);
            color: var(--white);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
        }

        .no-employees {
            text-align: center;
            font-size: 1.2rem;
            color: var(--text-muted);
            padding: 2.5rem;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin: 1rem 0;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            padding: 1rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
        }

        .pagination a {
            color: var(--dark-blue);
            background: var(--white);
            border: 1px solid var(--border-gray);
        }

        .pagination a:hover {
            background: var(--light-blue);
            transform: translateY(-2px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .pagination .current {
            background: var(--gradient-blue);
            color: var(--white);
            border: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media (max-width: 767px) {
            .employees-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .employees-title {
                font-size: 1.75rem;
            }

            .employees-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .employees-table th,
            .employees-table td {
                padding: 1rem;
                font-size: 0.85rem;
            }

            .employee-photo {
                width: 32px;
                height: 32px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .swal2-popup {
                padding: 1.5rem !important;
                max-height: 85vh !important;
                width: 95% !important;
            }

            .swal2-title {
                font-size: 1.5rem !important;
            }

            .swal2-content p {
                flex-direction: column !important;
            }

            .swal2-content p strong,
            .swal2-content p span {
                width: 100% !important;
            }

            .swal2-content .employee-photo {
                width: 60px;
                height: 60px;
            }

            .pagination-container {
                padding: 0.5rem;
            }

            .pagination a, .pagination span {
                width: 36px;
                height: 36px;
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="employees-container animate__animated animate__fadeIn">
        <div class="employees-header">
            <h1 class="employees-title">Team Members</h1>
        </div>

        @if ($employees->isEmpty())
            <div class="no-employees animate__animated animate__fadeIn">
                <i class="fas fa-users-slash fa-2x mb-2" style="color: var(--text-muted);"></i>
                <p>No team members found.</p>
            </div>
        @else
            <table class="employees-table animate__animated animate__fadeInUp">
                <thead>
                    <tr>
                        <th style="width: 10%;">Photo</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 15%;">Profile</th>
                        <th style="width: 20%;">Function</th>
                        <th style="width: 15%;">Phone</th>
                        <th style="width: 20%;">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <img src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->nomComplet) . '&size=256&background=random' }}" alt="{{ $employee->nomComplet }}'s photo" class="employee-photo">
                            </td>
                            <td>{{ $employee->nomComplet }}</td>
                            <td>
                                <span class="profile-badge profile-{{ strtolower($employee->profile ?? 'employe') }}">
                                    <i class="fas fa-circle fa-xs"></i> {{ ucfirst($employee->profile ?? 'Employe') }}
                                </span>
                            </td>
                            <td>{{ $employee->Fonction }}</td>
                            <td>{{ $employee->telephone ?? 'N/A' }}</td>
                            <td>{{ $employee->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($employees->hasPages())
                <div class="pagination-container">
                    {{ $employees->links() }}
                </div>
            @endif
        @endif
    </div>
</section>
@endsection