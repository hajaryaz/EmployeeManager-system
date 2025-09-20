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
            --glass: rgba(255, 255, 255, 0.7);
            --success: #28a745;
            --danger: #dc3545;
        }

        .document-form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .document-form-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .document-form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: var(--gradient-navy);
            border-radius: 2px;
        }

        .document-form-title {
            font-size: 2.2rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-navy);
            background: var(--gradient-navy);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-group label {
            position: absolute;
            top: 0.75rem;
            left: 1rem;
            color: var(--navy-light);
            font-weight: 600;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--navy-very-light);
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            color: var(--primary-navy);
            background: var(--white);
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--primary-navy);
            box-shadow: 0 0 10px rgba(30, 58, 138, 0.3);
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label,
        .form-group textarea:focus + label,
        .form-group textarea:not(:placeholder-shown) + label {
            top: -0.75rem;
            left: 1rem;
            font-size: 0.85rem;
            color: var(--primary-navy);
            background: var(--white);
            padding: 0 0.3rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .error-message {
            color: var(--navy-dark);
            font-size: 0.85rem;
            font-family: 'Poppins', sans-serif;
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
            border-color: var(--navy-dark);
            box-shadow: 0 0 8px rgba(21, 42, 102, 0.2);
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit {
            text-decoration: none;
            background: var(--primary-navy);
            color: var(--white);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: var(--navy-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            color: var(--white);
        }
        .btn-submit:active {
            background: var(--navy-dark);
            color: var(--white);
        }

        .btn-back {
            background: var(--navy-light);
            color: var(--white);
        }

        .btn-back:hover {
            background: var(--primary-navy);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            color: var(--white);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            color: var(--white);
            background: var(--glass);
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in;
        }

        .alert-success {
            background: var(--success);
        }

        .alert-danger {
            background: var(--danger);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 767px) {
            .document-form-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .document-form-title {
                font-size: 1.8rem;
            }

            .button-group {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="document-form-container animate__animated animate__fadeIn">
        <div class="document-form-header">
            <h1 class="document-form-title">Submit Document Request</h1>
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
        <form id="documentForm" action="{{ route('employee.submit-document') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" id="document_title" name="document_title" placeholder=" " required>
                <label for="document_title">Document Title</label>
                <div class="error-message" id="document_title_error">Please provide a document title.</div>
            </div>
            <div class="form-group">
                <textarea class="form-control" id="description" name="description" placeholder=" " rows="4"></textarea>
                <label for="description">Description (Optional)</label>
            </div>
            <div class="button-group">
                <a href="{{ route('employee.document-requests') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Back to Document Requests
                </a>
                <button type="submit" class="btn-submit">Submit Request</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('documentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Reset error messages and invalid states
            document.querySelectorAll('.form-group').forEach(group => group.classList.remove('invalid'));
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
                el.style.display = 'none';
            });

            // Validate document title
            const documentTitle = document.getElementById('document_title').value.trim();
            if (!documentTitle) {
                const error = document.getElementById('document_title_error');
                error.style.display = 'block';
                setTimeout(() => error.classList.add('show'), 10);
                document.getElementById('document_title').parentElement.classList.add('invalid');
                isValid = false;
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
@endsection