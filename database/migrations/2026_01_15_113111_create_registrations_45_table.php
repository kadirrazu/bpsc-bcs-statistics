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
        Schema::create('registrations_45', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('reg');
            $table->string('name');
            $table->integer('gender');
            $table->string('dob');
            $table->string('dob_ddmmyyyy')->nullable();
            $table->integer('district_code');
            $table->integer('b_subject');
            $table->integer('g_inst_code')->nullable();
            $table->string('g_inst_name')->nullable();
            $table->string('cadre_category')->nullable();
            $table->integer('cadre_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations_44');
    }
};
