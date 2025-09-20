@extends('Employe.masteremp')

@section('content')
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-gray: #64748b;
            --white: #f8fafc;
            --dark-slate: #1f2937;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            --border-gray: #e5e7eb;
            --success: #22c55e;
            --danger: #ef4444;
        }

        .leave-table-container {
            padding: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .leave-table-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .leave-table-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--primary-navy);
        }

        .leave-table-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .leave-table-card h2 {
            color: var(--dark-slate);
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 0.02em;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--primary-navy);
            text-decoration: none;
            border: none;
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 500;
            color: var(--white);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px) scale(1.02);
            text-decoration: none;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            background: var(--primary-navy);
        }
        .btn-primary:active {
            background: var(--primary-navy);
            text-decoration: none;
        } 

        .btn-danger-outline {
            border: 1px solid var(--danger);
            color: var(--danger);
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-danger-outline:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            background: red;
            color: white;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            background: var(--white);
        }

        .table th, .table td {
            padding: 1.25rem;
            text-align: left;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-gray);
        }

        .table th {
            background: var(--primary-navy);
            color: var(--white);
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:nth-child(even) {
            background: #f1f5f9;
        }

        .table tbody tr:hover {
            background: var(--white);
            transform: scale(1.01);
        }

        .status-badge {
            padding: 0.5rem 1.25rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: capitalize;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            background: var(--secondary-gray);
            color: var(--white);
        }

        .status-approved {
            background: var(--success);
            color: var(--white);
        }

        .status-rejected {
            background: var(--danger);
            color: var(--white);
        }

        .no-requests-card {
            background: var(--white);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-top: 2rem;
        }

        .no-requests-card i {
            font-size: 3rem;
            color: var(--primary-navy);
            margin-bottom: 1rem;
        }

        .no-requests-card p {
            color: var(--dark-slate);
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .pagination .page-item .page-link {
            border-radius: 8px;
            color: var(--primary-navy);
            border: 1px solid var(--border-gray);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-navy);
            color: var(--white);
            border-color: var(--primary-navy);
        }

        .pagination .page-item .page-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 991px) {
            .leave-table-container {
                padding: 1.5rem;
            }

            .leave-table-card {
                padding: 1.5rem;
            }

            .leave-table-card h2 {
                font-size: 1.8rem;
            }

            .table th, .table td {
                padding: 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 767px) {
            .leave-table-container {
                padding: 1rem;
            }

            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .btn-primary, .btn-danger-outline {
                width: 100%;
                justify-content: center;
            }

            .no-requests-card {
                padding: 2rem;
            }

            .table th:last-child, .table td:last-child {
                display: none;
            }
        }
    </style>

    <div class="leave-table-container">
        <div class="leave-table-card animate__animated animate__fadeInUp">
            <h2>Pending Leave Requests</h2>
            <div class="d-flex justify-content-end mb-4">
            </div>
            @if($leaves->isEmpty())
                <div class="no-requests-card animate__animated animate__fadeInUp">
                    <i class="fas fa-calendar-times"></i>
                    <p>No leave requests found. Start by requesting a new leave!</p>
                </div>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Reason</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Rejection Reason</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaves as $leave)
                            <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                <td>{{ $leave->leave_reason }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($leave->status) }}">
                                        {{ $leave->status }}
                                    </span>
                                </td>
                                <td>{{ $leave->rejected_reason ?? '-' }}</td>
                                <td>{{ $leave->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $leaves->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>
@endsection