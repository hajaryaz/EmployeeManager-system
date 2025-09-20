@extends('Manager.masterma')
@section('content')
<section class="main">
    <style>
        :root {
            --primary-blue: #310af5; 
            --primary-blue-dark: #2a09cc; 
            --white: #ffffff;
            --light-blue: #f5f3ff; 
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #310af5, #2a09cc);
            --gray-bg: #f7f9fc;
            --glass: rgba(255, 255, 255, 0.7);
            --danger: #ef4444; 
            --success: #22c55e; 
            --status-pending: #7e7c7c;
            --status-in-progress: #3b82f6; 
            --status-approved: #22c55e; 
            --status-rejected: #ef4444; 
            --status-completed: #8b5cf6; 
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .documents-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .documents-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .documents-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--gradient-blue);
            border-radius: 2px;
        }

        .documents-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .documents-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .documents-table th,
        .documents-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--light-blue);
        }

        .documents-table th {
            background: var(--gradient-blue);
            color: var(--white);
            font-weight: 600;
        }

        .documents-table tr:hover {
            background: var(--gray-bg);
        }

        .document-title {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .status-pending {
            background: var(--status-pending);
            color: var(--white);
        }

        .status-in-progress {
            background: var(--status-in-progress);
            color: var(--white);
        }

        .status-approved {
            background: var(--status-approved);
            color: var(--white);
        }

        .status-rejected {
            background: var(--status-rejected);
            color: var(--white);
        }

        .status-completed {
            background: var(--status-completed);
            color: var(--white);
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-edit {
            background: var(--primary-blue);
            color: var(--white);
        }

        .btn-edit:hover {
            background: var(--primary-blue-dark);
            color: var(--white);
            transform: translateY(-2px);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: var(--dark-blue);
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 2px solid var(--light-blue);
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-blue);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-submit {
            background: var(--primary-blue);
            color: var(--white);
        }

        .btn-submit:hover {
            background: var(--primary-blue-dark);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: var(--danger);
            color: var(--white);
        }

        .btn-cancel:hover {
            background: #b02a37;
            color: var(--white);
            transform: translateY(-2px);
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

        .pagination a,
        .pagination span {
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

        .pagination a i,
        .pagination span i {
            font-size: 1.1rem;
        }

        @media (max-width: 767px) {
            .documents-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .documents-title {
                font-size: 1.8rem;
            }

            .documents-table th,
            .documents-table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .document-title {
                max-width: 150px;
            }

            .modal-content {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="documents-container animate__animated animate__fadeIn">
        <div class="documents-header">
            <h1 class="documents-title">Document Requests</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="background: var(--success); color: var(--white); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="documents-table">
                <thead>
                    <tr>
                        <th>Document Title</th>
                        <th>Employee</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td class="document-title" title="{{ $document->document_title }}">{{ $document->document_title }}</td>
                            <td>{{ $document->employee_name }}</td>
                            <td>{{ $document->description ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ str_replace('_', '-', $document->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $document->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">No document requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $documents->links('vendor.pagination.custom') }}
        </div>
    </div>
</section>
@endsection