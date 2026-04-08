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
        Schema::create('locauxes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_local');
            $table->foreignId('type_local_id')
                ->constrained('type_locauxes')
                ->cascadeOnDelete();
            $table->foreignId('etablissement_id')
                ->constrained('etablissements')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locauxes');
    }
};
