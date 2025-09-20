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
            --danger: #ef4444;
        }

        .leave-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            padding: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .leave-form-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 2.5rem;
            width: 100%;
            max-width: 600px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .leave-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--primary-navy);
        }

        .leave-form-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .leave-form-card h2 {
            color: var(--dark-slate);
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 0.02em;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.75rem;
        }

        .form-group label {
            position: absolute;
            top: 0.75rem;
            left: 1rem;
            color: var(--dark-slate);
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.2s ease;
            pointer-events: none;
        }

        .form-group .form-control {
            border: 1px solid var(--border-gray);
            border-radius: 12px;
            padding: 1.5rem 1rem 0.5rem;
            background: var(--white);
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-group .form-control:focus,
        .form-group .form-control:not(:placeholder-shown) {
            border-color: var(--primary-navy);
            background: #f1f5f9;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .form-group .form-control:focus + label,
        .form-group .form-control:not(:placeholder-shown) + label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.85rem;
            color: var(--primary-navy);
            background: var(--white);
            padding: 0 0.25rem;
        }

        .btn-submit {
            background: var(--primary-navy);
            color: var(--white);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: var(--primary-navy);
            color: var(--white);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            border: 1px solid var(--primary-navy);
            color: var(--primary-navy);
            background: transparent;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: var(--primary-navy);
            color: var(--white);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.5rem;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .error-message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .form-group.invalid .form-control {
            border-color: var(--danger);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        @media (max-width: 767px) {
            .leave-form-container {
                padding: 1.5rem;
            }

            .leave-form-card {
                padding: 1.5rem;
            }

            .leave-form-card h2 {
                font-size: 1.8rem;
            }

            .button-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-submit, .btn-outline {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="leave-form-container">
        <div class="leave-form-card animate__animated animate__fadeInUp">
            <h2><i class="fas fa-calendar-plus"></i> Submit Leave Request</h2>
            <form id="leaveForm" action="{{ route('employee.submit-leave') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" id="leave_reason" name="leave_reason" placeholder=" " required>
                    <label for="leave_reason">Leave Reason</label>
                    <div class="error-message" id="leave_reason_error">Please provide a reason for your leave.</div>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" id="start_date" name="start_date" placeholder=" " required>
                    <label for="start_date">Start Date</label>
                    <div class="error-message" id="start_date_error">Please select a valid start date (not in the past).</div>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" id="end_date" name="end_date" placeholder=" " required>
                    <label for="end_date">End Date</label>
                    <div class="error-message" id="end_date_error">End date must be on or after the start date.</div>
                </div>
                <div class="button-group">
                    <a href="{{ route('employee.leave-requests') }}" class="btn btn-outline animate__animated animate__zoomIn">
                        <i class="fas fa-arrow-left"></i> Back to Leave Requests
                    </a>
                    <button type="submit" class="btn btn-submit animate__animated animate__zoomIn">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('leaveForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Reset error messages and invalid states
            document.querySelectorAll('.form-group').forEach(group => group.classList.remove('invalid'));
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
                el.style.display = 'none';
            });

            // Validate leave reason
            const leaveReason = document.getElementById('leave_reason').value.trim();
            if (!leaveReason) {
                const error = document.getElementById('leave_reason_error');
                error.style.display = 'block';
                setTimeout(() => error.classList.add('show'), 10);
                document.getElementById('leave_reason').parentElement.classList.add('invalid');
                isValid = false;
            }

            // Validate start date
            const startDate = new Date(document.getElementById('start_date').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (!startDate || startDate < today) {
                const error = document.getElementById('start_date_error');
                error.style.display = 'block';
                setTimeout(() => error.classList.add('show'), 10);
                document.getElementById('start_date').parentElement.classList.add('invalid');
                isValid = false;
            }

            // Validate end date
            const endDate = new Date(document.getElementById('end_date').value);
            if (!endDate || endDate < startDate) {
                const error = document.getElementById('end_date_error');
                error.style.display = 'block';
                setTimeout(() => error.classList.add('show'), 10);
                document.getElementById('end_date').parentElement.classList.add('invalid');
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
@endsection