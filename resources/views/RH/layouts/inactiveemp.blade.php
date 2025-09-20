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

    .search-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .search-bar {
        width: 100%;
        max-width: 600px;
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--primary-blue);
        border-radius: 50px;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .search-bar:focus {
        border-color: var(--primary-blue-dark);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 991px) {
        .page-header h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .search-bar {
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }
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
        background-color: var(--blue);
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

</style>

<div class="page-header animate__animated animate__fadeIn">
    <h1>Inactive Employees</h1>
    <p>Search and view all employees on leave.</p>
</div>

<div class="search-container">
    <input type="text" id="searchBar" class="search-bar" placeholder="Search by name" onkeyup="searchEmployees()">
</div>

<div id="employeeGrid" class="employee-grid">
    @forelse ($employees as $employee)
    <div class="employee-card animate__animated animate__fadeInUp" data-name="{{ strtolower($employee->nomComplet) }}">
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
        <p class="no-employees">No employees found.</p>
    @endforelse
</div>

<div class="pagination-container">
    {{ $employees->links('vendor.pagination.custom') }}
</div>


<script>
    function searchEmployees() {
        const searchTerm = document.getElementById('searchBar').value.toLowerCase().trim();
        const employeeCards = document.querySelectorAll('.employee-card');
        let matchCount = 0;

        employeeCards.forEach(card => {
            const employeeName = card.getAttribute('data-name');
            if (searchTerm === '' || employeeName.includes(searchTerm)) {
                card.style.display = 'block';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        let noEmployeesMessage = document.querySelector('.no-employees');
        if (matchCount === 0) {
            if (!noEmployeesMessage) {
                noEmployeesMessage = document.createElement('p');
                noEmployeesMessage.className = 'no-employees';
                noEmployeesMessage.textContent = 'No employees found.';
                document.getElementById('employeeGrid').appendChild(noEmployeesMessage);
            }
        } else {
            if (noEmployeesMessage) {
                noEmployeesMessage.remove();
            }
        }
    }

    document.querySelector('.allemp')?.classList.add('active');
</script>
@endsection