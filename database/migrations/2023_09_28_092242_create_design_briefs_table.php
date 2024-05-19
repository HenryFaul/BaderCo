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

        Schema::create('design_briefs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->text('client_name');
            $table->text('type');
            $table->text('brand')->nullable();
            $table->text('goals_of_social_media')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('brand_rules')->nullable();
            $table->text('guidelines_of_engagement')->nullable();
            $table->text('desired_tone_of_voice')->nullable();
            $table->text('brand_personality_desc')->nullable();
            $table->text('type_of_content')->nullable();
            $table->text('posting_frequency')->nullable();
            $table->text('kpi')->nullable();
            $table->text('reporting_frequency')->nullable();
            $table->text('words_to_avoid')->nullable();
            $table->text('words_to_use')->nullable();
            $table->text('emoji_to_avoid')->nullable();
            $table->text('emoji_to_use')->nullable();
            $table->text('person_to_sign_off')->nullable();
            $table->text('brand_colours')->nullable();
            $table->string('asset_link')->nullable();
            $table->string('file_link')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_public_url')->nullable();
            $table->json('sm_platforms')->nullable();
            $table->text('additional_notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_briefs');
    }
};
