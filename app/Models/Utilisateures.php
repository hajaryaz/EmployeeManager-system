<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateures extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'matricule',
        'nomComplet',
        'CIN',
        'email',
        'motdepasse',
        'telephone',
        'adresse',
        'dateNaissance',
        'sexe',
        'dateEmbauche',
        'statutMarital',
        'salaire',
        'typeContrat',
        'niveauEtude',
        'competences',
        'photo',
        'Fonction',
        'Departement',
        'etat',
    ];

    public function attendances()
{
    return $this->hasMany(Attendance::class, 'user_id');
}

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($utilisateur) {
            switch (strtolower($utilisateur->profile)) {
                case 'rh':
                    $prefix = 'RH';
                    break;
                case 'manager':
                    $prefix = 'MA';
                    break;
                case 'employe':
                default:
                    $prefix = 'EM';
                    break;
            }
            $year = $utilisateur->dateEmbauche
                ? date('Y', strtotime($utilisateur->dateEmbauche))
                : now()->format('Y');

            $count = self::where('matricule', 'like', "{$prefix}{$year}%")->count() + 1;

            $utilisateur->matricule = $prefix . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }
}
