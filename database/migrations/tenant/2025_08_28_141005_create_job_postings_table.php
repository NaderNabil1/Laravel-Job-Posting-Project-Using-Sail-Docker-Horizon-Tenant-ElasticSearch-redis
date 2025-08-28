<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::connection('tenant')->create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->integer('salary')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::connection('tenant')->dropIfExists('job_postings');
    }
};
