<?php

use App\Models\Administrateur;
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
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('post');
            $table->timestamps();
        });
        Schema::table('users', function(Blueprint $table){
            $table->foreignIdFor(Administrateur::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrateurs');

        // Schema::table('administrateurs',function(Blueprint $table){
        //     $table->dropForeignIdFor(User::class);
        // });
    }
};
