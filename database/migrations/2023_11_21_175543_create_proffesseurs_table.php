<?php

use App\Models\Commentaire;
use App\Models\Proffesseur;
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
        Schema::create('proffesseurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('email');
            $table->timestamps();
        });
        Schema::table('matieres',function(Blueprint $table){
            $table->foreignIdFor(Proffesseur::class)->nullable()->constrained()->cascadeOnDelete();
        });
        Schema::table('users', function(Blueprint $table){
            $table->foreignIdFor(Proffesseur::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proffesseurs');
        Schema::table('matieres',function(Blueprint $table){
            $table->dropForeignIdFor(Proffesseur::class);
        });
        // Schema::table('proffesseurs',function(Blueprint $table){
        //     $table->dropForeignIdFor(User::class);
        // });
    }
};
