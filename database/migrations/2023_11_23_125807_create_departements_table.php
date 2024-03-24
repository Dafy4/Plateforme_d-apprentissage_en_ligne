<?php

use App\Models\Departement;
use App\Models\Etudiant;
use App\Models\Matiere;
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
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });
        Schema::table('etudiants',function(Blueprint $table){
            $table->foreignIdFor(Departement::class)->nullable()->constrained()->cascadeOnDelete();
        });
        Schema::create('departement_matiere',function(Blueprint $table){
            $table->foreignIdFor(Departement::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Matiere::class)->constrained()->cascadeOnDelete();
            $table->primary(['departement_id','matiere_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departements');
        Schema::dropIfExists('departement_matiere');
        Schema::table('etudiants',function(Blueprint $table){
            $table->dropForeignIdFor(Departement::class);
        });
    }
};
