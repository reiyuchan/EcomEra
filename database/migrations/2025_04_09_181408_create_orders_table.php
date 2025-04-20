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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('confirmation_number')->nullable();
            $table->string('billing_email')->nullable();
            $table->integer('billing_name')->nullable();
            $table->string('billing_name_on_card')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('billing_discount_code')->nullable();
            $table->decimal('billing_discount', 10, 2)->default(0);
            $table->decimal('billing_subtotal', 10, 2);
            $table->decimal('billing_total', 10, 2);
            $table->boolean('shipped')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
