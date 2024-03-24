<?php

use App\Models\Commentaire;
use App\Models\Contenu_du_cour;
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
        Schema::create('contenu_du_cours', function (Blueprint $table) {
            $table->id();
            $table->json('contenue');
            $table->json('sujet_examen');
            $table->integer('niveau');
            $table->timestamps();
        });
        Schema::create('contenu_du_cour_matiere',function(Blueprint $table){
            $table->foreignIdFor(Contenu_du_cour::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Matiere::class)->constrained()->cascadeOnDelete();
            $table->primary(['contenu_du_cour_id','matiere_id']);
        });
        Schema::table('matieres', function(Blueprint $table){
            $table->foreignIdFor(Contenu_du_cour::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenu_du_cour_matiere');
        Schema::dropIfExists('contenu_du_cours');

        Schema::table('matieres', function(Blueprint $table){
            $table->dropForeignIdFor(Contenu_du_cour::class);
        });
    }
};
