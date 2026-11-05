<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('code_prefix', 1);
            $table->unsignedInteger('code_number');
            $table->string('name');
            $table->string('address');
            $table->date('opened_at')->nullable();
            $table->date('closed_at')->nullable();
            $table->timestamps();

            $table->unique(['code_prefix', 'code_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
