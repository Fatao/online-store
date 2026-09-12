<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // e.g. Ferrari
            $table->string('slug')->unique();      // ferrari
            $table->string('category');            // hypercar, supercar, luxury, luxury_suv, electric_luxury, performance
            $table->string('logo')->nullable();    // path to logo image
            $table->boolean('featured')->default(false); // shown on homepage brand grid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};