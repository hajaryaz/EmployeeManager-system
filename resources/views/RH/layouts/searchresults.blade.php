@extends('RH.master')

@section('content')
<style>
    :root {
        --primary-blue: #1a73e8;
        --primary-blue-dark: #1557b0;
        --white: #ffffff;
        --light-blue: #e8f0fe;
        --dark-blue: #1f2a44;
        --gradient-blue: linear-gradient(135deg, #1a73e8, #1557b0);
        --blue: #007bff;
        --dark-blue: #003f7f;
        --gray-bg: #f7f9fc;
        --glass: rgba(255, 255, 255, 0.7);
        --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .page-header {
        background: var(--white);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-blue);
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-blue);
        margin-bottom: 0.5rem;
        background: var(--gradient-blue);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-header p {
        color: var(--dark-blue);
        opacity: 0.7;
        font-size: 1.1rem;
    }

    .back-button {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: var(--gradient-blue);
        color: var(--white);
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .back-button:hover {
        background: var(--primary-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .employee-grid {
        display: grid;
        gap: 2rem;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }

    .employee-card {
        backdrop-filter: blur(10px);
        background: var(--glass);
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }

    .employee-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 18px 35px rgba(0, 0, 0, 0.15);
    }

    .employee-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 1rem;
        border: 5px solid white;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .employee-card h5 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.4rem;
    }

    .employee-role {
        font-size: 0.95rem;
        font-weight: 600;
        color: #007bff;
        margin-bottom: 0.8rem;
    }

    .department-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(to right, #248bf9, #248bf9);
        color: white;
        font-size: 0.7rem;
        padding: 0.3rem 0.7rem;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-view {
        background-color: var(--blue);
        color: var(--white);
        border: none;
        padding: 0.4rem 1.1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-view:hover {
        background-color: var(--dark-blue);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .no-employees {
        text-align: center;
        color: #666;
        font-size: 1.2rem;
        margin-top: 2rem;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2.5rem;
        margin-bottom: 2rem;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination a, .pagination span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        color: var(--dark-blue);
        background: var(--white);
        transition: all 0.3s ease;
        box-shadow: var(--shadow);
    }

    .pagination a.nav-arrow {
        width: 48px;
        height: 48px;
        background: var(--gradient-blue);
        color: var(--white);
    }

    .pagination a:hover:not(.nav-arrow) {
        background: var(--light-blue);
        color: var(--primary-blue);
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .pagination a.nav-arrow:hover {
        background: var(--primary-blue-dark);
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .pagination .current {
        background: var(--gradient-blue);
        color: var(--white);
        font-weight: 600;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .pagination .disabled {
        color: #aaa;
        background: #f1f3f5;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .pagination .dots {
        font-size: 0.9rem;
        color: var(--dark-blue);
        padding: 0 0.5rem;
        background: none;
        box-shadow: none;
    }

    .pagination a i, .pagination span i {
        font-size: 1.1rem;
    }

    @media (max-width: 991px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .pagination a, .pagination span {
            width: 28px;
            height: 28px;
            font-size: 0.85rem;
        }

        .pagination a.nav-arrow {
            width: 40px;
            height: 40px;
        }

        .pagination a i, .pagination span i {
            font-size: 1rem;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .back-button {
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }

        .employee-grid {
            gap: 1.5rem;
        }

        .pagination-container {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .pagination {
            gap: 0.3rem;
        }

        .pagination a, .pagination span {
            width: 26px;
            height: 26px;
            font-size: 0.8rem;
        }

        .pagination a.nav-arrow {
            width: 36px;
            height: 36px;
        }

        .pagination a i, .pagination span i {
            font-size: 0.9rem;
        }

        .pagination .dots {
            font-size: 0.8rem;
            padding: 0 0.3rem;
        }
    }
</style>

<div class="page-header animate__animated animate__fadeIn">
    <h1>Search Results</h1>
    <p>Employees matching your search query "{{ $search }}".</p>
</div>

<div class="text-center">
    <a href="{{ route('RHallemp') }}" class="back-button">Back to All Employees</a>
</div>

<div id="employeeGrid" class="employee-grid">
    @forelse ($employees as $employee)
    <div class="employee-card animate__animated animate__fadeInUp">
        <div class="department-badge">{{ $employee->Departement }}</div>
        <img class="employee-photo"
            src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->nomComplet) . '&size=256&background=random' }}"
            alt="{{ $employee->nomComplet }}"
        >
        <h5>{{ $employee->nomComplet }}</h5>
        <div class="employee-role">{{ $employee->Fonction }}</div>
        <a href="{{ route('viewprofile', $employee->id) }}" class="btn btn-view">View Profile</a>
    </div>
    @empty
        <p class="no-employees">No employees found for "{{ $search }}".</p>
    @endforelse
</div>

<div class="pagination-container">
    {{ $employees->links('vendor.pagination.custom') }}
</div>

<script>
    document.querySelector('.allemp')?.classList.add('active');
</script>
@endsection