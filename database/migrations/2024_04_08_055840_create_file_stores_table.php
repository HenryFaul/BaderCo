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
        Schema::create('file_stores', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('file_type_id')->unsigned();
            $table->foreign('file_type_id')
                ->references('id')->on('file_types')->onDelete('cascade');

            $table->bigInteger('design_job_id')->unsigned();
            $table->foreign('design_job_id')
                ->references('id')->on('design_jobs')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('client_id')->unsigned();
            $table->foreign('client_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('pm_id')->unsigned();
            $table->foreign('pm_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->text('comments')->nullable();
            $table->text('pm_comments')->nullable();
            $table->text('client_comments')->nullable();
            $table->string('file_link');
            $table->string('file_name');
            $table->string('file_public_url');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_client_approved')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_stores');
    }
};
