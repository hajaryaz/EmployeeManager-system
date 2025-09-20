@extends('RH.master')

@section('content')
<section class="main">
    <style>
        .logs-container {
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

        .logs-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .logs-header::after {
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

        .logs-title {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin: 0;
            line-height: 1.2;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 2.5rem;
            width: 100%;
        }

        .search-bar input {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            font-size: 1rem;
            width: 100%;
            max-width: 500px;
            background: var(--white);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-bar input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.1);
        }

        .logs-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .logs-table th,
        .logs-table td {
            padding: 1rem;
            text-align: left;
            font-size: 0.95rem;
            color: var(--dark-blue);
        }

        .logs-table th {
            background: var(--light-blue);
            font-weight: 600;
            font-size: 1rem;
            position: relative;
        }

        .logs-table td {
            border-bottom: 1px solid var(--border-gray);
        }

        .logs-table tr:last-child td {
            border-bottom: none;
        }

        .logs-table .action {
            color: var(--primary-blue);
            font-weight: 500;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .pagination a {
            background: var(--primary-blue);
            color: var(--white);
        }

        .pagination a:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
        }

        .pagination span {
            background: var(--border-gray);
            color: var(--text-muted);
        }

        @media (max-width: 767px) {
            .logs-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .logs-title {
                font-size: 2rem;
            }

            .search-bar input {
                max-width: 100%;
            }

            .logs-table th,
            .logs-table td {
                font-size: 0.85rem;
                padding: 0.75rem;
            }

            .pagination a,
            .pagination span {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="logs-container animate__animated animate__fadeIn">
        <div class="logs-header">
            <h1 class="logs-title">My Activity Logs</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success animate__animated animate__slideInLeft">
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
            <div class="alert alert-danger animate__animated animate__slideInLeft">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span>{{ session('error') }}</span>
                <button class="alert-dismiss" aria-label="Dismiss alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search logs..." onkeyup="searchLogs()">
        </div>

        <table class="logs-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="logsTableBody">
                @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->details }}</td>
                        <td>
                            <span class="badge {{ $log->status == 'success' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $logs->links('vendor.pagination.custom') }}
        </div>
    </div>

    <script>
        function searchLogs() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#logsTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        }

        document.querySelectorAll('.alert-dismiss').forEach(button => {
            button.addEventListener('click', () => {
                button.parentElement.style.display = 'none';
            });
        });
    </script>
</section>
@endsection