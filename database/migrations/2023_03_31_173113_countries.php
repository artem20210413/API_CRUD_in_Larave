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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso_code', 2)->unique();
            $table->string('iso_code_continent', 2);
            $table->string('name', 100);

            $table->foreign('iso_code_continent')
                ->references('iso_code')
                ->on('continents')
                ->onDelete('restrict');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
