@extends('RH.master')

@section('content')
<section class="main">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-blue: #1a73e8;
            --primary-blue-dark: #1557b0;
            --white: #ffffff;
            --light-blue: #e8f0fe;
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #1a73e8, #1557b0);
            --gray-bg: #f7f9fc;
            --glass: rgba(255, 255, 255, 0.8);
            --danger: #dc3545;
            --success: #28a745;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .news-container {
            max-width: 1240px;
            margin: 2.5rem auto;
            padding: 3rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: containerFade 0.8s ease;
        }

        @keyframes containerFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .news-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .news-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--gradient-blue);
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(26, 115, 232, 0.4);
        }

        .news-title {
            font-size: 2.4rem;
            font-weight: 800;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0;
            line-height: 1.2;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        .news-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
            border: 1px solid var(--light-blue);
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.2);
        }

        .news-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
            border-bottom: 3px solid var(--primary-blue);
            transition: transform 0.3s ease;
        }

        .news-card:hover .news-image {
            transform: scale(1.05);
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-content h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 0.6rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .news-card:hover .news-content h3 {
            color: var(--primary-blue);
        }

        .news-content p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 1.2rem;
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .news-meta {
            font-size: 0.85rem;
            color: #888;
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.2rem;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 0.8rem;
            justify-content: flex-end;
        }

        .btn-edit, .btn-delete {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-edit {
            background-color: var(--primary-blue);
            color: white;
        }

        .btn-edit:hover {
            background-color: var(--primary-blue-dark);
            color: var(--white);
        }

        .btn-delete {
            background-color: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: var(--white);
        }

        .no-news {
            text-align: center;
            font-size: 1.4rem;
            color: #666;
            padding: 3rem;
            background: var(--white);
            border-radius: 18px;
            box-shadow: var(--shadow);
            margin: 1rem 0;
        }

        .alert-success {
            background: var(--success);
            color: var(--white);
            padding: 1.2rem 2rem;
            border-radius: 14px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1rem;
            animation: slideIn 0.5s ease forwards, fadeOut 5s ease 3s forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; transform: translateX(-20px); height: 0; padding: 0; margin: 0; }
        }

        /* Pagination Styles */
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

        @media (max-width: 767px) {
            .news-container {
                padding: 2rem;
                margin: 1.5rem;
            }

            .news-title {
                font-size: 2rem;
            }

            .news-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .news-image {
                height: 180px;
            }

            .news-content {
                padding: 1.5rem;
            }

            .news-content h3 {
                font-size: 1.5rem;
            }

            .pagination-container {
                margin-top: 2rem;
                margin-bottom: 1.5rem;
            }

            .pagination {
                gap: 0.3rem;
            }

            .pagination a, .pagination span {
                width: 26px;
                height: 26px;
                font-size: 0.8rem;
            }

            .pagination a.nav-arrow {
                width: 36px;
                height: 36px;
            }

            .pagination a i, .pagination span i {
                font-size: 0.9rem;
            }

            .pagination .dots {
                font-size: 0.8rem;
                padding: 0 0.3rem;
            }
        }
    </style>

    <div class="news-container animate__animated animate__fadeIn">
        <div class="news-header">
            <h1 class="news-title">All News</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($news->isEmpty())
            <div class="no-news animate__animated animate__fadeIn">No news published yet.</div>
        @else
            <div class="news-grid">
                @foreach ($news as $item)
                    <div class="news-card animate__animated animate__fadeInUp">
                        @if ($item->image)
                            <img src="{{ $item->image ? asset($item->image) : 'https://ui-avatars.com/api/?name=' . urlencode($item->title) . '&size=256&background=random' }}" class="news-image">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->title) }}&size=256&background=1a73e8&color=fff" class="news-image">
                        @endif
                        <div class="news-content">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->content }}</p>
                            <div class="news-meta">
                                <span>By {{ $item->author }}</span>
                                <span>{{ \Carbon\Carbon::parse($item->published_at)->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="action-buttons">
                                <a href="{{ route('news.edit', $item->id) }}" class="btn btn-edit">Edit</a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('news.delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-delete" onclick="confirmDelete('{{ $item->id }}', '{{ $item->title }}')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $news->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                background: 'var(--white)',
                color: 'var(--dark-blue)',
                showCancelButton: true,
                confirmButtonColor: 'var(--danger)',
                cancelButtonColor: 'var(--primary-blue)',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Yes, Delete',
                cancelButtonText: '<i class="fas fa-times-circle"></i> Cancel',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    title: 'fw-bold fs-4',
                    htmlContainer: 'mb-3',
                    confirmButton: 'btn btn-delete px-4 py-2 mx-2',
                    cancelButton: 'btn btn-edit px-4 py-2 mx-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</section>
@endsection