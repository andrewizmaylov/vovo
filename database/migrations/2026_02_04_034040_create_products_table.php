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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название товара');
            $table->decimal('price')->comment('Стоимость');
            $table->unsignedBigInteger('category_id')->comment('Принадлежность к категории');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->boolean('in_stock')->default(false)->comment('Флаг наличия товара');
            $table->float('rating')->default(0)->comment('Рейтинг товара');
            $table->timestamps();

            $table->index('name');
            $table->index('category_id');
            $table->index('in_stock');
            $table->index('price');
            $table->index('rating');
            $table->index('created_at');

            $table->index(['category_id', 'price']);
            $table->index(['category_id', 'rating']);
            $table->index(['category_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
