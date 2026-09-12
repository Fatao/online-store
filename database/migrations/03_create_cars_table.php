<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();

            $table->string('model');              // e.g. "488 Pista"
            $table->string('name');               // display name e.g. "Ferrari 488 Pista"
            $table->decimal('price', 12, 2);
            $table->string('unit')->default('шт.'); // pieces / kilograms / liters per project spec

            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedInteger('mileage')->nullable();          // km
            $table->unsignedInteger('horsepower')->nullable();
            $table->string('fuel_type')->nullable();                 // petrol, diesel, hybrid, electric
            $table->string('transmission')->nullable();               // automatic, manual
            $table->string('body_type')->nullable();                  // sedan, coupe, suv, convertible, hatchback
            $table->string('color')->nullable();

            $table->text('description')->nullable();
            $table->text('features')->nullable();      // comma-separated or JSON
            $table->string('image')->nullable();        // main image path
            $table->json('gallery')->nullable();         // additional image paths

            $table->unsignedInteger('stock')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};