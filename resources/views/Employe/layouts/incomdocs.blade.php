@extends('Employe.masteremp')

@section('content')
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --navy-dark: #152a66;
            --navy-light: #4b5ea6;
            --navy-very-light: #e6e9f4;
            --white: #ffffff;
            --gradient-navy: linear-gradient(135deg, var(--primary-navy), var(--navy-dark));
            --glass: rgba(255, 255, 255, 0.9);
            --success: #28a745;
            --danger: #dc3545;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
        }

        .documents-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
        }

        .documents-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--navy-very-light);
            position: relative;
        }

        .documents-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 120px;
            height: 3px;
            background: var(--gradient-navy);
            border-radius: 3px;
        }

        .documents-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy-dark);
            margin: 0;
            position: relative;
            padding-left: 1.5rem;
        }

        .documents-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background: var(--primary-navy);
            border-radius: 50%;
        }

        .documents-title::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background: var(--navy-light);
            border-radius: 50%;
            opacity: 0.7;
        }

        .add-document-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--gradient-navy);
            color: var(--white);
            padding: 0.85rem 2rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
            z-index: 1;
        }

        .add-document-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--navy-dark), var(--primary-navy));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .add-document-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
        }

        .add-document-btn:hover::before {
            opacity: 1;
        }

        .add-document-btn i {
            transition: transform 0.3s ease;
        }

        .add-document-btn:hover i {
            transform: translateX(5px);
        }

        .add-document-btn:active {
            transform: translateY(1px);
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
        }

        .documents-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
        }

        .documents-table th,
        .documents-table td {
            padding: 1.25rem;
            text-align: left;
            border-bottom: 1px solid var(--navy-very-light);
            color: black;
        }

        .documents-table th {
            background: var(--primary-navy);
            color: var(--white);
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .documents-table tr:last-child td {
            border-bottom: none;
        }

        .documents-table tr:hover td {
            background-color: var(--navy-very-light);
        }

        .title {
            font-size: 1rem;
            color: #000;
            font-family: 'Poppins', sans-serif;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            white-space: nowrap; 
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .status-in_progress {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .status-completed {
            background: rgba(111, 66, 193, 0.2);
            color: #6f42c1;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }

        .btn-cancel {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .btn-cancel:hover {
            background: rgba(220, 53, 69, 0.2);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
            color: #dc3545;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            color: var(--white);
            box-shadow: var(--shadow-sm);
            animation: fadeIn 0.5s ease;
        }

        .alert-success {
            background: var(--success);
        }

        .alert-danger {
            background: var(--danger);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
        }

        .pagination a, .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a {
            color: var(--primary-navy);
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }

        .pagination a:hover {
            background: var(--navy-very-light);
            transform: translateY(-2px);
        }

        .pagination .current {
            background: var(--gradient-navy);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .documents-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .documents-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .documents-title {
                font-size: 1.75rem;
            }

            .add-document-btn {
                width: 100%;
                justify-content: center;
            }

            .documents-table th,
            .documents-table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="documents-container animate__animated animate__fadeIn">
        <div class="documents-header">
            <h1 class="documents-title">InCompleted Documents</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="table-container">
            <table class="documents-table">
                <thead>
                    <tr>
                        <th>Document Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Rejection Reason</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td class="title">{{ $document->document_title }}</td>
                            <td>{{ $document->description ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '_', $document->status)) }}">
                                    <i class="fas fa-circle" style="font-size: 0.5rem; vertical-align: middle;"></i>
                                    {{ ucfirst($document->status) }}
                                </span>
                            </td>
                            <td>{{ $document->rejection_reason ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($document->created_at)->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: var(--navy-light);">
                                <i class="fas fa-folder-open" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
                                No document requests found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
            <div class="pagination-container">
                {{ $documents->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection