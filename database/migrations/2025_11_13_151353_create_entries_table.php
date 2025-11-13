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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            // create the user_id column that be the foreign key id in the users DB Table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // create the category_id column that be the foreign key id in the categories DB Table
            $table->foreignId('category_id')->constrained('categories');
            // values            
            $table->string('title');
            $table->date('date')->nullable();
            $table->string('description')->nullable();
            $table->string('url', length: 2048)->nullable();            
            $table->string('place')->nullable();
            $table->string('autor')->nullable();
            $table->decimal('value', total: 8, places: 2)->nullable();
            $table->text('info')->nullable();
            // timestamps
            $table->timestamps();
            // softdeletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
