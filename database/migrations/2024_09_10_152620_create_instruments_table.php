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
        if (!Schema::hasTable('')) {
            Schema::create('instruments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description');
                $table->string('category');
                $table->string('brand');
                $table->integer('price');
                $table->float('reviewSum')->default(0); 
                $table->integer('numberOfReviews')->default(0);
                $table->integer('quantity')->default(1);
                $table->string('image');
                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruments');
    }
};
