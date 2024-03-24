<?php

use App\Models\Chat;
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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamps();
        });
        // Schema::create('chat_etudiant',function(Blueprint $table){
        //     $table->foreignIdFor(Chat::class)->constrained()->cascadeOnDelete();
        //     $table->foreignIdFor(Etudiant::class)->constrained()->cascadeOnDelete();
        //     $table->primary(['chat_id','etudiant_id']);
        // });
        Schema::create('chat_matiere',function(Blueprint $table){
            $table->foreignIdFor(Chat::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Matiere::class)->constrained()->cascadeOnDelete();
            $table->primary(['chat_id','matiere_id']);
        });
        // Schema::create('chat_user',function(Blueprint $table){
        //     $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
        //     $table->foreignIdFor(Chat::class)->constrained()->cascadeOnDelete();
        //     $table->primary(['user_id','chat_id']);
        // });
        Schema::table('chats', function(Blueprint $table){
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_matiere');
        // Schema::dropIfExists('chat_user');
        Schema::dropIfExists('chats');
        Schema::table('chats',function(Blueprint $table){
            $table->dropForeignIdFor(User::class);
        });
    }
};
