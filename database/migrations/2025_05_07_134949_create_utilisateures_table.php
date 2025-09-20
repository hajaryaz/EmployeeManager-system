<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateures', function (Blueprint $table) {
            $table->id();
            $table->enum('profile', ['employe', 'RH', 'Manager'])->nullable();
            $table->string('matricule')->unique();
            $table->string('nomComplet');
            $table->string('CIN')->unique();
            $table->string('email')->unique();
            $table->string('motdepasse');
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->date('dateNaissance')->nullable();
            $table->enum('sexe', ['Homme', 'Femme'])->nullable();
            $table->date('dateEmbauche')->nullable();
            $table->enum('statutMarital', ['Célibataire', 'Marié(e)', 'Divorcé(e)'])->nullable();
            $table->decimal('salaire', 10, 2)->nullable();
            $table->enum('typeContrat', ['CDI', 'CDD', 'Stage', 'Freelance'])->nullable();
            $table->string('niveauEtude')->nullable();
            $table->text('competences')->nullable();
            $table->string('photo')->nullable();
            $table->string('Fonction');
            $table->string('Departement');
            $table->enum('etat', ['Actif', 'Inactif', 'Suspendu'])->default('Actif');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateures');
    }
};
