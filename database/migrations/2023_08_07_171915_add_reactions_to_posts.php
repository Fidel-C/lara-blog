<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->json('reactions')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      if (Schema::hasColumn('posts','reactions')){
        Schema::table('posts',function(Blueprint $table){
        $table->dropColumn('reactions');
        });
      }
    }
};

