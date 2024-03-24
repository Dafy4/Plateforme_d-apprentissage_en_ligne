<?php

use App\Models\Commentaire;
use App\Models\Contenu_du_cour;
use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\User;
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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('email');
            $table->timestamps();
        });
        Schema::create('contenu_du_cour_etudiant',function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Contenu_du_cour::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Etudiant::class)->constrained()->cascadeOnDelete();
            $table->json('reponse_examen');
            $table->integer('note');
            // $table->integer('progression');
            // $table->primary(['contenu_du_cour_id','etudiant_id']);
            // $table->timestamps('created_at');
            // $table->timestamps('updated_at');
        });
        Schema::table('users', function(Blueprint $table){
            $table->foreignIdFor(Etudiant::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenu_du_cours_etudiant');
        Schema::dropIfExists('etudiant_matiere');
        Schema::dropIfExists('etudiants');
        // Schema::table('etudiants',function(Blueprint $table){
        //     $table->dropForeignIdFor(User::class);
        // });
    }
};
