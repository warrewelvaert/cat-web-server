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
        Schema::create('cats_details', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('language');
            $table->string('name');
            $table->text('description');
            $table->string('origin');
            $table->string('temperament');
            $table->string('wikipedia_url');
            $table->timestamps();

            $table->primary(['id', 'language']);
            $table->foreign('id')->references('id')->on('cats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cats_details');
    }
};
