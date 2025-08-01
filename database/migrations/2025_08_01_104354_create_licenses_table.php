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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('key', 40)->unique();
            $table->string('serial_number', 8)->unique();
            $table->string('name', 255);
            $table->integer('quantity');
            $table->tinyInteger('state')->default(0);
            $table->enum('type', ['server', 'user', 'module']);
            $table->timestamps(); // creates both 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
