@extends('RH.master')

@section('content')
<section class="main">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1e40af;
            --white: #ffffff;
            --light-blue: #eff6ff;
            --dark-blue: #1e293b;
            --gradient-blue: linear-gradient(135deg, #2563eb, #1e40af);
            --gray-bg: #f1f5f9;
            --glass: rgba(255, 255, 255, 0.9);
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --border-gray: #e5e7eb;
            --input-bg: #ffffff;
            --text-muted: #6b7280;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        .attendance-container {
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

        .attendance-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .attendance-header::after {
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

        .attendance-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin: 0;
            line-height: 1.2;
        }

        #calendar {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        #calendar:hover {
            transform: translateY(-5px);
        }

        .fc-toolbar {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .fc-toolbar-title {
            color: var(--dark-blue);
            font-weight: 600;
            font-size: 1.5rem;
            order: 1;
            flex-grow: 1;
            text-align: center;
        }

        .fc-toolbar-chunk {
            display: flex;
            align-items: center;
        }

        .fc-toolbar-chunk:first-child {
            order: 0;
            margin-right: auto;
        }

        .fc-toolbar-chunk:last-child {
            order: 2;
            margin-left: auto;
        }

        .fc-button {
            background: var(--primary-blue) !important;
            border: none !important;
            color: var(--white) !important;
            border-radius: 8px !important;
            padding: 0.5rem 1rem !important;
            transition: var(--transition) !important;
        }

        .fc-button:hover {
            background: var(--primary-blue-dark) !important;
            transform: translateY(-2px);
        }

        .fc-daygrid-day {
            transition: var(--transition);
        }

        .fc-daygrid-day:hover {
            background: var(--light-blue);
            cursor: pointer;
        }

        .fc-event-present, .fc-event-late, .fc-event-absent {
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--white);
            font-weight: 500;
            transition: var(--transition);
        }

        .fc-event-present {
            background: var(--success);
        }

        .fc-event-late {
            background: var(--warning);
        }

        .fc-event-absent {
            background: var(--danger);
        }

        .fc-event-present::before, .fc-event-late::before, .fc-event-absent::before {
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 0.9rem;
        }

        .fc-event-present::before {
            content: '\f00c';
        }

        .fc-event-late::before {
            content: '\f017';
        }

        .fc-event-absent::before {
            content: '\f00d';
        }

        .alert-success, .alert-error {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1rem;
            font-weight: 500;
            animation: slideIn 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .alert-success {
            background: var(--success);
            color: var(--white);
        }

        .alert-error {
            background: var(--danger);
            color: var(--white);
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-dismiss {
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.1rem;
            cursor: pointer;
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            transition: var(--transition);
        }

        .alert-dismiss:hover {
            color: var(--light-blue);
            transform: translateY(-50%) scale(1.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            animation: zoomIn 0.4s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.85); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-close {
            position: absolute;
            top: 1.2rem;
            right: 1.2rem;
            font-size: 1.8rem;
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .modal-close:hover {
            color: var(--primary-blue);
            transform: rotate(90deg);
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 0.6rem;
        }

        .form-group input, .form-group select {
            padding: 0.85rem;
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            font-size: 1rem;
            background: var(--input-bg);
            outline: none;
            transition: var(--transition);
        }

        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.9rem;
            margin-top: 0.4rem;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
        }

        .btn-submit {
            background: var(--gradient-blue);
            color: var(--white);
        }

        .btn-submit:hover {
            background: var(--primary-blue-dark);
            transform: translateY(-2px);
            color: var(--white);
        }

        .btn-cancel {
            background: var(--danger);
            color: var(--white);
        }

        .btn-cancel:hover {
            background: #dc2626;
            color: var(--white);
            transform: translateY(-2px);
        }

        @media (max-width: 767px) {
            .attendance-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .attendance-title {
                font-size: 2rem;
            }

            #calendar {
                padding: 1rem;
            }

            .fc-toolbar-title {
                font-size: 1.2rem;
            }

            .modal-content {
                padding: 2rem;
            }
        }
    </style>

    <div class="attendance-container animate__animated animate__fadeIn">
        <div class="attendance-header">
            <h1 class="attendance-title">My Attendance Calendar</h1>
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
            <div class="alert alert-error animate__animated animate__slideInLeft">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <span>{{ session('error') }}</span>
                <button class="alert-dismiss" aria-label="Dismiss alert">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div id="calendar" class="animate__animated animate__fadeInUp"></div>
    </div>

    <div id="attendanceModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn">
            <span class="modal-close" onclick="closeModal()">×</span>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--dark-blue); text-align: center;">Mark Attendance</h2>
            <form id="attendanceForm" method="POST" action="{{ route('attendance.store') }}" class="modal-form">
                @csrf
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" id="date" readonly>
                    @error('date') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="status">Attendance Status</label>
                    <select name="status" id="status" required>
                        <option value="" disabled selected>Select status</option>
                        <option value="present">Present</option>
                        <option value="late">Late</option>
                        <option value="absent">Absent</option>
                    </select>
                    @error('status') <span class="error-message">{{ $message }}</span> @enderror
                </div>
                <p style="font-size: 1.1rem; color: var(--dark-blue); text-align: center;">
                    Mark attendance for {{ session('name') }} on <span id="modal-date"></span>
                </p>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-submit">Confirm</button>
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Dismiss alert
        document.querySelectorAll('.alert-dismiss').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.alert').style.display = 'none';
            });
        });

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                selectable: true,
                dateClick: function(info) {
                    openModal(info.dateStr);
                },
                events: @json($attendances->map(function($attendance) {
                    return [
                        'title' => ucfirst($attendance->status),
                        'start' => $attendance->date->toDateString(),
                        'className' => 'fc-event-' . $attendance->status
                    ];
                }))
            });
            calendar.render();
        });

        function openModal(date) {
            const modal = document.getElementById('attendanceModal');
            const dateInput = document.getElementById('date');
            const modalDate = document.getElementById('modal-date');
            const statusSelect = document.getElementById('status');

            dateInput.value = date;
            modalDate.textContent = new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            statusSelect.value = '';
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('attendanceModal');
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('attendanceModal');
            if (event.target === modal) {
                closeModal();
            }
        };

        // Client-side validation
        document.getElementById('attendanceForm').addEventListener('submit', function(event) {
            const date = document.getElementById('date').value;
            const status = document.getElementById('status').value;

            if (!date) {
                event.preventDefault();
                const errorMessage = document.createElement('span');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'Date is required.';
                document.getElementById('date').parentElement.appendChild(errorMessage);
            }

            if (!status) {
                event.preventDefault();
                const errorMessage = document.createElement('span');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'Please select an attendance status.';
                document.getElementById('status').parentElement.appendChild(errorMessage);
            }
        });
    </script>
</section>
@endsection