<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $initialCategoriesList = [
        'Электроника',
        'Бытовая химия',
        'Продукты',
        'Товары из китая',
        'Лекарства',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->char('name', 24)->comment('Название категории');
            $table->timestamps();
        });

        $date = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        $dataToInsert = array_map(fn (string $name) => [
            'name' => $name,
            'created_at' => $date,
            'updated_at' => $date,
        ], $this->initialCategoriesList);

        DB::table('categories')->insert($dataToInsert);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
