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

        .edit-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .edit-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .edit-header::before {
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

        .edit-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .edit-form {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: 1fr 1fr;
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
        .form-group select,
        .form-group textarea {
            padding: 0.75rem;
            border: 2px solid var(--light-blue);
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-blue);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        /* File Input Specific Styles */
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
            grid-column: span 2;
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
            .edit-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .edit-form {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .edit-title {
                font-size: 1.8rem;
            }

            .form-group input[type="file"] {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="edit-container animate__animated animate__fadeIn">
        <div class="edit-header">
            <h1 class="edit-title">Edit Employee: {{ $employee->nomComplet }}</h1>
        </div>

        <form action="{{ route('employeeupdate', $employee->id) }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nomComplet">Nom Complet</label>
                <input type="text" name="nomComplet" id="nomComplet" value="{{ old('nomComplet', $employee->nomComplet) }}">
                @error('nomComplet') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="CIN">CIN</label>
                <input type="text" name="CIN" id="CIN" value="{{ old('CIN', $employee->CIN) }}">
                @error('CIN') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $employee->telephone) }}">
                @error('telephone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $employee->adresse) }}">
                @error('adresse') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="dateNaissance">Date de Naissance</label>
                <input type="date" name="dateNaissance" id="dateNaissance"
                value="{{ old('dateNaissance', $employee->dateNaissance ? \Carbon\Carbon::parse($employee->dateNaissance)->format('Y-m-d') : '') }}">
                @error('dateNaissance') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="sexe">Sexe</label>
                <select name="sexe" id="sexe">
                    <option value="" {{ !$employee->sexe ? 'selected' : '' }}>Sélectionner</option>
                    <option value="Homme" {{ $employee->sexe == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ $employee->sexe == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
                @error('sexe') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="dateEmbauche">Date d'Embauche</label>
                <input type="date" name="dateEmbauche" id="dateEmbauche"
                value="{{ old('dateEmbauche', $employee->dateEmbauche ? \Carbon\Carbon::parse($employee->dateEmbauche)->format('Y-m-d') : '') }}">
                @error('dateEmbauche') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="statutMarital">Statut Marital</label>
                <select name="statutMarital" id="statutMarital">
                    <option value="" {{ !$employee->statutMarital ? 'selected' : '' }}>Sélectionner</option>
                    <option value="Célibataire" {{ $employee->statutMarital == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié(e)" {{ $employee->statutMarital == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="Divorcé(e)" {{ $employee->statutMarital == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                </select>
                @error('statutMarital') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="salaire">Salaire</label>
                <input type="number" name="salaire" id="salaire" step="0.01" value="{{ old('salaire', $employee->salaire) }}">
                @error('salaire') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="typeContrat">Type de Contrat</label>
                <select name="typeContrat" id="typeContrat">
                    <option value="" {{ !$employee->typeContrat ? 'selected' : '' }}>Sélectionner</option>
                    <option value="CDI" {{ $employee->typeContrat == 'CDI' ? 'selected' : '' }}>CDI</option>
                    <option value="CDD" {{ $employee->typeContrat == 'CDD' ? 'selected' : '' }}>CDD</option>
                    <option value="Stage" {{ $employee->typeContrat == 'Stage' ? 'selected' : '' }}>Stage</option>
                    <option value="Freelance" {{ $employee->typeContrat == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                </select>
                @error('typeContrat') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="niveauEtude">Niveau d'Étude</label>
                <input type="text" name="niveauEtude" id="niveauEtude" value="{{ old('niveauEtude', $employee->niveauEtude) }}">
                @error('niveauEtude') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="competences">Compétences</label>
                <textarea name="competences" id="competences">{{ old('competences', $employee->competences) }}</textarea>
                @error('competences') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group file-input-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" accept="image/*">
                @error('photo') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
        <label for="Fonction">Function</label>
        <select name="Fonction" id="Fonction" class="form-control">
            <option value="">-- Select a function --</option>
            <option value="Backend Developer" {{ old('Fonction', $employee->Fonction) == 'Backend Developer' ? 'selected' : '' }}>Backend Developer</option>
            <option value="Frontend Developer" {{ old('Fonction', $employee->Fonction) == 'Frontend Developer' ? 'selected' : '' }}>Frontend Developer</option>
            <option value="DevOps Engineer" {{ old('Fonction', $employee->Fonction) == 'DevOps Engineer' ? 'selected' : '' }}>DevOps Engineer</option>
            <option value="IT Project Manager" {{ old('Fonction', $employee->Fonction) == 'IT Project Manager' ? 'selected' : '' }}>IT Project Manager</option>
            <option value="Product Manager" {{ old('Fonction', $employee->Fonction) == 'Product Manager' ? 'selected' : '' }}>Product Manager</option>
            <option value="Data Scientist" {{ old('Fonction', $employee->Fonction) == 'Data Scientist' ? 'selected' : '' }}>Data Scientist</option>
            <option value="Cybersecurity Analyst" {{ old('Fonction', $employee->Fonction) == 'Cybersecurity Analyst' ? 'selected' : '' }}>Cybersecurity Analyst</option>
            <option value="Cloud Consultant" {{ old('Fonction', $employee->Fonction) == 'Cloud Consultant' ? 'selected' : '' }}>Cloud Consultant</option>
            <option value="UX/UI Designer" {{ old('Fonction', $employee->Fonction) == 'UX/UI Designer' ? 'selected' : '' }}>UX/UI Designer</option>
            <option value="HR Manager" {{ old('Fonction', $employee->Fonction) == 'HR Manager' ? 'selected' : '' }}>HR Manager</option>
            <option value="Marketing Director" {{ old('Fonction', $employee->Fonction) == 'Marketing Director' ? 'selected' : '' }}>Marketing Director</option>
            <option value="Finance Analyst" {{ old('Fonction', $employee->Fonction) == 'Finance Analyst' ? 'selected' : '' }}>Finance Analyst</option>
        </select>
        @error('Fonction') <span class="error-message">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="Departement">Department</label>
        <select name="Departement" id="Departement" class="form-control">
            <option value="">-- Select a department --</option>
            <option value="Software Development" {{ old('Departement', $employee->Departement) == 'Software Development' ? 'selected' : '' }}>Software Development</option>
            <option value="Artificial Intelligence" {{ old('Departement', $employee->Departement) == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>
            <option value="Infrastructure & Networks" {{ old('Departement', $employee->Departement) == 'Infrastructure & Networks' ? 'selected' : '' }}>Infrastructure & Networks</option>
            <option value="IT Security" {{ old('Departement', $employee->Departement) == 'IT Security' ? 'selected' : '' }}>IT Security</option>
            <option value="Cloud & DevOps" {{ old('Departement', $employee->Departement) == 'Cloud & DevOps' ? 'selected' : '' }}>Cloud & DevOps</option>
            <option value="Design & User Experience" {{ old('Departement', $employee->Departement) == 'Design & User Experience' ? 'selected' : '' }}>Design & User Experience</option>
            <option value="Human Resources" {{ old('Departement', $employee->Departement) == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
            <option value="Digital Marketing" {{ old('Departement', $employee->Departement) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
            <option value="Finance & Accounting" {{ old('Departement', $employee->Departement) == 'Finance & Accounting' ? 'selected' : '' }}>Finance & Accounting</option>
            <option value="Sales & Business" {{ old('Departement', $employee->Departement) == 'Sales & Business' ? 'selected' : '' }}>Sales & Business</option>
            <option value="Customer Support" {{ old('Departement', $employee->Departement) == 'Customer Support' ? 'selected' : '' }}>Customer Support</option>
            <option value="Strategy & Innovation" {{ old('Departement', $employee->Departement) == 'Strategy & Innovation' ? 'selected' : '' }}>Strategy & Innovation</option>
        </select>
        @error('Departement') <span class="error-message">{{ $message }}</span> @enderror
    </div>
            

            <div class="form-group">
                <label for="etat">État</label>
                <select name="etat" id="etat">
                    <option value="Actif" {{ $employee->etat == 'Actif' ? 'selected' : '' }}>Actif</option>
                    <option value="Inactif" {{ $employee->etat == 'Inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="Suspendu" {{ $employee->etat == 'Suspendu' ? 'selected' : '' }}>Suspendu</option>
                </select>
                @error('etat') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-submit">Save Changes</button>
                <a href="/RHallemp" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection