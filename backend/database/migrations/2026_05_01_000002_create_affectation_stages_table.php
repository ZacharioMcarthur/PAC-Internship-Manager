<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('affectation_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('departement_id')->constrained('departements')->cascadeOnDelete();
            $table->foreignId('maitre_stage_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectation_stages');
    }
};
