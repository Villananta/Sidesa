<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('name', 100);
            $table->enum('gender', ['male', 'female']);
            $table->string('place_of_birth', 50);
            $table->date('date_of_birth');
            $table->string('address', 200);
            $table->enum('religion', ['islam', 'kristen', 'katholik', 'budha', 'khonghucu', 'hindu'])->default('islam');
            $table->enum('marital_status', ['single', 'married', 'widower', 'widow'])->default('single');
            $table->string('occupation', 100)->nullable();
            $table->string('phone', 15);
            $table->enum('status', ['aktif', 'pindahan', 'meninggal'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};