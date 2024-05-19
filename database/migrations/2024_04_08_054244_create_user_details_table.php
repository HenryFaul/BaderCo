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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();




            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('user_type_id')->unsigned();
            $table->foreign('user_type_id')
                ->references('id')->on('user_types')->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_legal_name')->nullable();
            $table->longText('about_you')->nullable();
            $table->string('cv_link')->nullable();
            $table->string('cell_no')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_available')->default(1);
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
