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
        Schema::create('pending_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->default('');
            $table->string('details');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2);
            $table->unsignedInteger('quantity')->default(0);
            $table->string('product_code');
            $table->json('images')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
