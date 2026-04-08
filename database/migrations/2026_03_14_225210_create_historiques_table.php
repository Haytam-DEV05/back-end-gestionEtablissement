<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipement_id')
                ->constrained('equipements')
                ->onDelete('cascade');
            $table->foreignId('ancien_local_id')
                ->constrained('locauxes')
                ->cascadeOnDelete();
            $table->foreignId('nouveau_local_id')
                ->constrained('locauxes')
                ->cascadeOnDelete();
            $table->date('date_mouvement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historiques');
    }
};
