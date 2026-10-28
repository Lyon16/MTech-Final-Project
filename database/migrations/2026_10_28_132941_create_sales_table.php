<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('sold_by');

            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->dateTime('created_at');

            // Foreign key relationships
            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');

            $table->foreign('sold_by')
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
