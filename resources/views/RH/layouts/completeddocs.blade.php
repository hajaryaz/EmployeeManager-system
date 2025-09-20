@extends('RH.master')

@section('content')
<section class="main">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-blue-dark: #1557b0;
            --white: #ffffff;
            --light-blue: #e8f0fe;
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #1a73e8, #1557b0);
            --gray-bg: #f7f9fc;
            --glass: rgba(255, 255, 255, 0.7);
            --danger: #dc3545;
            --success: #28a745;
        }

        .documents-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
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

        .modal-content {
            background: var(--white);
            padding: 2rem;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
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
        }

        .btn-cancel {
            background: var(--danger);
            color: var(--white);
        }

        .btn-cancel:hover {
            background: #b02a37;
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

            .modal-content {
                padding: 1.5rem;
            }
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

    <div class="documents-container animate__animated animate__fadeIn">
        <div class="documents-header">
            <h1 class="documents-title">Completed Documents</h1>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td class="document-title" title="{{ $document->document_title }}">{{ $document->document_title }}</td>
                            <td>{{ $document->employee_name }}</td>
                            <td>{{ $document->description ?? 'N/A' }}</td>
                            <td>{{ ucfirst($document->status) }}</td>
                            <td>
                                <button class="btn btn-edit" onclick="openModal({{ $document->id }}, '{{ $document->status }}', '{{ $document->rejection_reason ?? '' }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">No completed documents found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-container">
        {{ $documents->links('vendor.pagination.custom') }}
    </div>

    <div id="statusModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn">
            <span class="modal-close" onclick="closeModal()">×</span>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: var(--dark-blue); text-align: center;">Update Document Status</h2>
            <form id="statusForm" method="POST" class="modal-form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" onchange="toggleRejectionReason()">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <div class="form-group" id="rejectionReasonGroup" style="display: none;">
                    <label for="rejection_reason">Rejection Reason</label>
                    <textarea name="rejection_reason" id="rejection_reason"></textarea>
                    @error('rejection_reason') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-submit">Save</button>
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(documentId, currentStatus, rejectionReason) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');
            const statusSelect = document.getElementById('status');
            const rejectionReasonInput = document.getElementById('rejection_reason');

            form.action = `/updatecompletedocs/${documentId}`;
            statusSelect.value = currentStatus;
            rejectionReasonInput.value = rejectionReason || '';
            toggleRejectionReason();
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('statusModal');
            modal.style.display = 'none';
        }

        function toggleRejectionReason() {
            const status = document.getElementById('status').value;
            const rejectionReasonGroup = document.getElementById('rejectionReasonGroup');
            rejectionReasonGroup.style.display = status === 'rejected' ? 'block' : 'none';
        }
        window.onclick = function(event) {
            const modal = document.getElementById('statusModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</section>
@endsection