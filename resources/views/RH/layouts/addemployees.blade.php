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

        .add-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        }

        .add-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .add-header::before {
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

        .add-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .add-form {
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
        }

        @media (max-width: 767px) {
            .add-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .add-form {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .add-title {
                font-size: 1.8rem;
            }

            .form-group input[type="file"] {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="add-container animate__animated animate__fadeIn">
        <div class="add-header">
            <h1 class="add-title">Add New Employee</h1>
        </div>

        @if(session('success'))
            <div style="display: flex; justify-content: center; margin-bottom: 3rem;">
                <div style="background-color: var(--success); color: white; padding: 1rem 2rem; border-radius: 10px; text-align: center; max-width: 600px; width: 100%;">
                    {{ session('success') }}
                </div>
            </div>
        @endif


        <form action="{{ route('addemployee') }}" method="POST" enctype="multipart/form-data" class="add-form">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="profile">Profile</label>
                <select name="profile" id="profile">
                    <option value="employe" {{ old('profile') == 'employe' ? 'selected' : '' }}>Employé</option>
                    <option value="RH" {{ old('profile') == 'RH' ? 'selected' : '' }}>RH</option>
                    <option value="Manager" {{ old('profile') == 'Manager' ? 'selected' : '' }}>Manager</option>
                </select>
                @error('profile') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="nomComplet">Nom Complet</label>
                <input type="text" name="nomComplet" id="nomComplet" value="{{ old('nomComplet') }}">
                @error('nomComplet') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="CIN">CIN</label>
                <input type="text" name="CIN" id="CIN" value="{{ old('CIN') }}">
                @error('CIN') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="motdepasse">Mot de Passe</label>
                <input type="password" name="motdepasse" id="motdepasse">
                @error('motdepasse') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}">
                @error('telephone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}">
                @error('adresse') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="dateNaissance">Date de Naissance</label>
                <input type="date" name="dateNaissance" id="dateNaissance" value="{{ old('dateNaissance') }}">
                @error('dateNaissance') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="sexe">Sexe</label>
                <select name="sexe" id="sexe">
                    <option value="" {{ !old('sexe') ? 'selected' : '' }}>Sélectionner</option>
                    <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>Homme</option>
                    <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>Femme</option>
                </select>
                @error('sexe') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="dateEmbauche">Date d'Embauche</label>
                <input type="date" name="dateEmbauche" id="dateEmbauche" value="{{ old('dateEmbauche') }}">
                @error('dateEmbauche') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="statutMarital">Statut Marital</label>
                <select name="statutMarital" id="statutMarital">
                    <option value="" {{ !old('statutMarital') ? 'selected' : '' }}>Sélectionner</option>
                    <option value="Célibataire" {{ old('statutMarital') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié(e)" {{ old('statutMarital') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="Divorcé(e)" {{ old('statutMarital') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                </select>
                @error('statutMarital') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="salaire">Salaire</label>
                <input type="number" name="salaire" id="salaire" step="0.01" value="{{ old('salaire') }}">
                @error('salaire') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="typeContrat">Type de Contrat</label>
                <select name="typeContrat" id="typeContrat">
                    <option value="" {{ !old('typeContrat') ? 'selected' : '' }}>Sélectionner</option>
                    <option value="CDI" {{ old('typeContrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                    <option value="CDD" {{ old('typeContrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                    <option value="Stage" {{ old('typeContrat') == 'Stage' ? 'selected' : '' }}>Stage</option>
                    <option value="Freelance" {{ old('typeContrat') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                </select>
                @error('typeContrat') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="niveauEtude">Niveau d'Étude</label>
                <input type="text" name="niveauEtude" id="niveauEtude" value="{{ old('niveauEtude') }}">
                @error('niveauEtude') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="competences">Compétences</label>
                <textarea name="competences" id="competences">{{ old('competences') }}</textarea>
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
                    <option value="Backend Developer" {{ old('Fonction') == 'Backend Developer' ? 'selected' : '' }}>Backend Developer</option>
                    <option value="Frontend Developer" {{ old('Fonction') == 'Frontend Developer' ? 'selected' : '' }}>Frontend Developer</option>
                    <option value="DevOps Engineer" {{ old('Fonction') == 'DevOps Engineer' ? 'selected' : '' }}>DevOps Engineer</option>
                    <option value="IT Project Manager" {{ old('Fonction') == 'IT Project Manager' ? 'selected' : '' }}>IT Project Manager</option>
                    <option value="Product Manager" {{ old('Fonction') == 'Product Manager' ? 'selected' : '' }}>Product Manager</option>
                    <option value="Data Scientist" {{ old('Fonction') == 'Data Scientist' ? 'selected' : '' }}>Data Scientist</option>
                    <option value="Cybersecurity Analyst" {{ old('Fonction') == 'Cybersecurity Analyst' ? 'selected' : '' }}>Cybersecurity Analyst</option>
                    <option value="Cloud Consultant" {{ old('Fonction') == 'Cloud Consultant' ? 'selected' : '' }}>Cloud Consultant</option>
                    <option value="UX/UI Designer" {{ old('Fonction') == 'UX/UI Designer' ? 'selected' : '' }}>UX/UI Designer</option>
                    <option value="HR Manager" {{ old('Fonction') == 'HR Manager' ? 'selected' : '' }}>HR Manager</option>
                    <option value="Marketing Director" {{ old('Fonction') == 'Marketing Director' ? 'selected' : '' }}>Marketing Director</option>
                    <option value="Finance Analyst" {{ old('Fonction') == 'Finance Analyst' ? 'selected' : '' }}>Finance Analyst</option>
                </select>
                @error('Fonction') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="Departement">Department</label>
                <select name="Departement" id="Departement" class="form-control">
                    <option value="">-- Select a department --</option>
                    <option value="Software Development" {{ old('Departement') == 'Software Development' ? 'selected' : '' }}>Software Development</option>
                    <option value="Artificial Intelligence" {{ old('Departement') == 'Artificial Intelligence' ? 'selected' : '' }}>Artificial Intelligence</option>
                    <option value="Infrastructure & Networks" {{ old('Departement') == 'Infrastructure & Networks' ? 'selected' : '' }}>Infrastructure & Networks</option>
                    <option value="IT Security" {{ old('Departement') == 'IT Security' ? 'selected' : '' }}>IT Security</option>
                    <option value="Cloud & DevOps" {{ old('Departement') == 'Cloud & DevOps' ? 'selected' : '' }}>Cloud & DevOps</option>
                    <option value="Design & User Experience" {{ old('Departement') == 'Design & User Experience' ? 'selected' : '' }}>Design & User Experience</option>
                    <option value="Human Resources" {{ old('Departement') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                    <option value="Digital Marketing" {{ old('Departement') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                    <option value="Finance & Accounting" {{ old('Departement') == 'Finance & Accounting' ? 'selected' : '' }}>Finance & Accounting</option>
                    <option value="Sales & Business" {{ old('Departement') == 'Sales & Business' ? 'selected' : '' }}>Sales & Business</option>
                    <option value="Customer Support" {{ old('Departement') == 'Customer Support' ? 'selected' : '' }}>Customer Support</option>
                    <option value="Strategy & Innovation" {{ old('Departement') == 'Strategy & Innovation' ? 'selected' : '' }}>Strategy & Innovation</option>
                </select>
                @error('Departement') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="etat">État</label>
                <select name="etat" id="etat">
                    <option value="Actif" {{ old('etat', 'Actif') == 'Actif' ? 'selected' : '' }}>Actif</option>
                    <option value="Inactif" {{ old('etat') == 'Inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="Suspendu" {{ old('etat') == 'Suspendu' ? 'selected' : '' }}>Suspendu</option>
                </select>
                @error('etat') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-submit">Add Employee</button>
            </div>
        </form>
        
    </div>
</section>

<script>
    document.querySelector('.addemp')?.classList.add('active');
</script>
@endsection