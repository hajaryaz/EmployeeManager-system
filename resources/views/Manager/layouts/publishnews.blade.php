@extends('Manager.masterma')

@section('content')
<section class="main">
    <style>
        :root {
            --primary-blue: #310af5;
            --primary-blue-dark: #5a36fd;
            --white: #ffffff;
            --light-blue: #e8f0fe;
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #310af5, #2a09cc);;
            --gray-bg: #f7f9fc;
            --glass: rgba(255, 255, 255, 0.7);
            --danger: #dc3545;
            --success: #28a745;
        }

        .publish-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .publish-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .publish-header::before {
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

        .publish-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .publish-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            background: var(--white);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-3px);
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group textarea {
            padding: 0.75rem;
            border: 2px solid var(--light-blue);
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--primary-blue);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-group.file-input-group {
            position: relative;
            overflow: hidden;
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .form-group input[type="file"]::-webkit-file-upload-button {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-group input[type="file"]::-webkit-file-upload-button:hover {
            background: var(--primary-blue-dark);
        }

        .form-group input[type="file"]::-moz-file-upload-button {
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-group input[type="file"]::-moz-file-upload-button:hover {
            background: var(--primary-blue-dark);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
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
            .publish-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .publish-title {
                font-size: 1.8rem;
            }

            .form-group input[type="file"] {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="publish-container animate__animated animate__fadeIn">
        <div class="publish-header">
            <h1 class="publish-title">Publish News</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="background: var(--success); color: var(--white); padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('MApublishnews') }}" method="POST" enctype="multipart/form-data" class="publish-form">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}">
                @error('title') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content">{{ old('content') }}</textarea>
                @error('content') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group file-input-group">
                <label for="image">Image (Optional)</label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="title">Author</label>
                <input type="text" name="author" id="author" value="{{ old('author') }}">
                @error('author') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="published_at">Publication Date</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                @error('published_at') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-submit">Publish News</button>
            </div>
        </form>
    </div>
</section>
@endsection