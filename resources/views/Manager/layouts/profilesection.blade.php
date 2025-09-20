@extends('Manager.masterma')

@section('content')
<section class="main">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        :root {
            --primary-blue: #310af5;
            --primary-blue-dark: #5a36fd;
            --white: #ffffff;
            --light-blue: #e8f0fe;
            --dark-blue: #1f2a44;
            --gradient-blue: linear-gradient(135deg, #310af5, #2a09cc);
            --gray-bg: #f7f9fc;
            --glass: rgba(255, 255, 255, 0.7);
            --danger: #dc3545;
            --danger-dark: #b02a37;
        }

        .profile-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-header::before {
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

        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid var(--white);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-blue);
        }

        .profile-details {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr 1fr;
        }

        .detail-item {
            background: var(--white);
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-3px);
        }

        .detail-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .detail-value {
            font-size: 1.1rem;
            color: var(--dark-blue);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
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

        .btn-edit {
            background: var(--primary-blue);
            color: var(--white);
        }

        .btn-edit:hover {
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
            .profile-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .profile-details {
                grid-template-columns: 1fr;
            }

            .profile-name {
                font-size: 1.8rem;
            }

            .profile-photo {
                width: 120px;
                height: 120px;
            }
        }
    </style>

    <div class="profile-container animate__animated animate__fadeIn">
        <div class="profile-header">
            <img class="profile-photo"
                 src="{{ $employee->photo ? asset($employee->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->nomComplet) . '&size=256&background=random' }}"
                 alt="{{ $employee->nomComplet }}">
            <h1 class="profile-name">{{ $employee->nomComplet }}</h1>
            <div class="profile-role">{{ $employee->Fonction }} | {{ $employee->Departement }}</div>
        </div>

        <div class="profile-details">
            <div class="detail-item">
                <div class="detail-label">Matricule</div>
                <div class="detail-value">{{ $employee->matricule }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">CIN</div>
                <div class="detail-value">{{ $employee->CIN }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $employee->email }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Téléphone</div>
                <div class="detail-value">{{ $employee->telephone ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Adresse</div>
                <div class="detail-value">{{ $employee->adresse ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Date de Naissance</div>
                <div class="detail-value">{{ $employee->dateNaissance ? \Carbon\Carbon::parse($employee->dateNaissance)->format('d/m/Y') : 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Sexe</div>
                <div class="detail-value">{{ $employee->sexe ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Date d'Embauche</div>
                <div class="detail-value">{{ $employee->dateEmbauche ? \Carbon\Carbon::parse($employee->dateEmbauche)->format('d/m/Y') : 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Statut Marital</div>
                <div class="detail-value">{{ $employee->statutMarital ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Salaire</div>
                <div class="detail-value">{{ $employee->salaire ? number_format($employee->salaire, 2) . ' MAD' : 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Type de Contrat</div>
                <div class="detail-value">{{ $employee->typeContrat ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Niveau d'Étude</div>
                <div class="detail-value">{{ $employee->niveauEtude ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Compétences</div>
                <div class="detail-value">{{ $employee->competences ?? 'Non spécifié' }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">État</div>
                <div class="detail-value">{{ $employee->etat }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('MAeditemployeesection') }}" class="btn btn-edit">Edit</a>
            <a href="/MAprofile" class="btn btn-cancel">Cancel</a>
        </div>
    </div>

</section>
@endsection
