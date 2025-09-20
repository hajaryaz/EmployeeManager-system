@extends('RH.master')

@section('content')
<section class="main">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        .leaves-container {
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

        .leaves-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .leaves-header::after {
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

        .leaves-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0;
            line-height: 1.3;
        }

        .leaves-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .leaves-table thead {
            background: var(--light-blue);
        }

        .leaves-table th {
            padding: 1.25rem;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--dark-blue);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border-gray);
        }

        .leaves-table tbody tr {
            transition: var(--transition);
            animation: rowFade 0.5s ease;
        }

        @keyframes rowFade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .leaves-table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-1px);
        }

        .leaves-table td {
            padding: 1.25rem;
            font-size: 0.95rem;
            color: var(--dark-blue);
            border-bottom: 1px solid var(--border-gray);
            vertical-align: middle;
        }

        .leaves-table td.reject-reason {
            max-width: 250px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .reject-reason-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--dark-blue);
            box-shadow: var(--shadow);
            transition: var(--transition);
            word-wrap: break-word;
            white-space: normal;
            animation: zoomIn 0.3s ease;
        }

        .reject-reason-badge:hover {
            transform: scale(1.02);
            border-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .reject-reason-badge i {
            font-size: 0.85rem;
            color: var(--danger);
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-approved {
            background: #dcfce7;
            color: #15803d;
        }

        .status-rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
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
            background: var(--gradient-blue);
            color: var(--white);
        }

        .btn-edit:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-1px);
            color: var(--white);
            box-shadow: 0 3px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-delete {
            background: var(--danger);
            color: var(--white);
        }

        .btn-delete:hover {
            transform: translateY(-1px);
            color: var(--white);
            box-shadow: 0 3px 8px rgba(239, 68, 68, 0.2);
        }

        .no-leaves {
            text-align: center;
            font-size: 1.2rem;
            color: var(--text-muted);
            padding: 2.5rem;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin: 1rem 0;
        }

        .alert-success {
            background: var(--success);
            color: var(--white);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            animation: bounceIn 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.95); opacity: 0; }
            60% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .alert-dismiss {
            background: none;
            border: none;
            color: var(--white);
            font-size: 1rem;
            cursor: pointer;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: var(--transition);
        }

        .alert-dismiss:hover {
            color: var(--light-blue);
        }

        /* Modal Styles (Adapted from Documents) */
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
            animation: zoomIn 0.3s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
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
            border: 2px solid var(--border-gray);
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
        }

        .btn-cancel {
            background: var(--danger);
            color: var(--white);
        }

        .btn-cancel:hover {
            background: #b02a37;
            color: var(--white);
        }

        @media (max-width: 767px) {
            .leaves-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .leaves-title {
                font-size: 1.75rem;
            }

            .leaves-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .leaves-table th,
            .leaves-table td {
                padding: 1rem;
                font-size: 0.85rem;
            }

            .leaves-table td.reject-reason {
                max-width: 150px;
            }

            .reject-reason-badge {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
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

    <div class="leaves-container animate__animated animate__fadeIn">
        <div class="leaves-header">
            <h1 class="leaves-title">Leave Requests Dashboard</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success animate__animated animate__bounceIn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button class="alert-dismiss" aria-label="Dismiss alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if ($leaves->isEmpty())
            <div class="no-leaves animate__animated animate__fadeIn">
                <i class="fas fa-folder-open fa-2x mb-2" style="color: var(--text-muted);"></i>
                <p>No leave requests submitted yet.</p>
            </div>
        @else
            <table class="leaves-table animate__animated animate__fadeInUp">
                <thead>
                    <tr>
                        <th style="width: 20%;">Employee</th>
                        <th style="width: 15%;">Leave Reason</th>
                        <th style="width: 15%;">Start Date</th>
                        <th style="width: 15%;">End Date</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 20%;">Reject Reason</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $leave->employee_name }}</td>
                            <td>{{ ucfirst($leave->leave_reason) }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</td>
                            <td>
                                <span class="status-badge status-{{ $leave->status }}">
                                    <i class="fas fa-circle fa-xs"></i> {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="reject-reason">
                                @if ($leave->status === 'rejected' && $leave->rejected_reason)
                                    <span class="reject-reason-badge">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $leave->rejected_reason }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-edit" onclick="openModal('{{ $leave->id }}', '{{ addslashes($leave->employee ? $leave->employee->nomComplet : 'N/A') }}', '{{ $leave->status }}', '{{ addslashes($leave->rejected_reason ?? '') }}')" aria-label="Edit leave status">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="pagination-container">
        {{ $leaves->links('vendor.pagination.custom') }}
    </div>

    <div id="statusModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn">
            <span class="modal-close" onclick="closeModal()">×</span>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: var(--dark-blue); text-align: center;">Update Leave Status</h2>
            <form id="statusForm" method="POST" class="modal-form">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" onchange="toggleRejectionReason()">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    @error('status') <span class="error-message">{{ $message }}</span> @endif
                </div>
                <div class="form-group" id="rejectionReasonGroup" style="display: none;">
                    <label for="reject_reason">Rejection Reason</label>
                    <textarea name="rejected_reason" id="reject_reason"></textarea>
                    @error('rejected_reason') <span class="error-message">{{ $message }}</span> @endif
                    <span id="reject_reason_error" class="error-message" style="display: none;">Rejection reason is required when status is rejected.</span>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-submit">Save</button>
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.alert-dismiss').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.alert-success').style.display = 'none';
            });
        });

        function openModal(leaveId, employeeName, currentStatus, rejectionReason) {
            const modal = document.getElementById('statusModal');
            const form = document.getElementById('statusForm');
            const statusSelect = document.getElementById('status');
            const rejectionReasonInput = document.getElementById('reject_reason');
            const rejectionReasonError = document.getElementById('reject_reason_error');

            form.action = '{{ route("leaves.update", ":id") }}'.replace(':id', leaveId);
            statusSelect.value = currentStatus;
            rejectionReasonInput.value = rejectionReason || '';
            rejectionReasonError.style.display = 'none';
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

        document.getElementById('statusForm').addEventListener('submit', function(event) {
            const status = document.getElementById('status').value;
            const rejectReason = document.getElementById('reject_reason').value.trim();
            const rejectionReasonError = document.getElementById('reject_reason_error');

            if (status === 'rejected' && !rejectReason) {
                event.preventDefault();
                rejectionReasonError.style.display = 'block';
            } else {
                rejectionReasonError.style.display = 'none';
            }
        });

        window.onclick = function(event) {
            const modal = document.getElementById('statusModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</section>
@endsection