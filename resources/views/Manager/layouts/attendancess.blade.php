@extends('Manager.masterma')

@section('content')
<style>
    :root {
        --primary-blue: #310af5;
        --primary-blue-dark: #5a36fd;
        --white: #ffffff;
        --light-blue: #e8f0fe;
        --dark-blue: #1f2a44;
        --gradient-blue: linear-gradient(135deg, #310af5, #2a09cc);
        --blue: #310af5;
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

    .filter-container {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .filter-form {
        display: flex;
        width: 100%;
        max-width: 800px;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .filter-select,
    .filter-date {
        flex: 1;
        min-width: 200px;
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--primary-blue);
        border-radius: 50px;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background: var(--white);
    }

    .filter-select:focus,
    .filter-date:focus {
        border-color: var(--primary-blue-dark);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .filter-date::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: 0.7;
    }

    .filter-button {
        padding: 0.75rem 1.5rem;
        background: var(--gradient-blue);
        color: var(--white);
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .filter-button:hover {
        background: var(--primary-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .clear-button {
        background: #dc3545;
        text-decoration: none;
    }

    .clear-button:hover {
        background: #b02a37;
    }

    .attendance-table {
        background: var(--glass);
        border-radius: 20px;
        box-shadow: var(--shadow);
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .attendance-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 1rem;
        text-align: left;
        font-size: 0.95rem;
        color: var(--dark-blue);
    }

    .attendance-table th {
        background: var(--gradient-blue);
        color: var(--white);
        font-weight: 600;
    }

    .attendance-table tr {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: background 0.3s ease;
    }

    .attendance-table tr:hover {
        background: var(--light-blue);
    }

    .status-badge {
        padding: 0.3rem 0.7rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }

    .status-present { background: #28a745; color: var(--white); }
    .status-absent { background: #dc3545; color: var(--white); }
    .status-late { background: #ffc107; color: var(--dark-blue); }

    .no-attendances {
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

        .filter-select,
        .filter-date {
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
            min-width: 150px;
        }

        .filter-button {
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }

        .attendance-table th,
        .attendance-table td {
            padding: 0.8rem;
            font-size: 0.9rem;
        }

        .pagination-container {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }

        .pagination {
            gap: 0.3rem;
        }

        ._privatetable {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
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
    <h1>My Dpartment's Attendance Records</h1>
    <p>View your department's attendance records by date.</p>
</div>

<div class="filter-container">
    <form action="{{ route('MAattendancess') }}" method="GET" class="filter-form">
        <input type="date" name="date" id="date" class="filter-date" value="{{ request('date') }}">
        <button type="submit" class="filter-button">Filter</button>
        <a href="{{ route('MAattendancess') }}" class="filter-button clear-button">Clear</a>
    </form>
</div>

@if (session('success'))
    <div class="alert alert-success animate__animated animate__fadeIn">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger animate__animated animate__fadeIn">
        {{ session('error') }}
    </div>
@endif

<div class="_privatetable">
    <div class="attendance-table animate__animated animate__fadeInUp">
        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->user->nomComplet ?? 'Unknown' }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($attendance->status) }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-attendances">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination-container">
    {{ $attendances->appends(['department' => request('department'), 'date' => request('date')])->links('vendor.pagination.custom') }}
</div>

<script>
    document.querySelector('.attendancess')?.classList.add('active');
</script>
@endsection
