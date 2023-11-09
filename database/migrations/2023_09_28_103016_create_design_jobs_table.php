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



        Schema::create('design_jobs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('pm_id')->unsigned();
            $table->foreign('pm_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('design_job_status_id')->unsigned();
            $table->foreign('design_job_status_id')
                ->references('id')->on('design_job_statuses')->onDelete('cascade');

            $table->bigInteger('design_brief_id')->unsigned();
            $table->foreign('design_brief_id')
                ->references('id')->on('design_briefs')->onDelete('cascade');

            $table->bigInteger('payment_type_id')->unsigned();
            $table->foreign('payment_type_id')
                ->references('id')->on('payment_types')->onDelete('cascade');

            $table->bigInteger('payment_status_id')->unsigned();
            $table->foreign('payment_status_id')
                ->references('id')->on('payment_statuses')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_jobs');
    }
};
