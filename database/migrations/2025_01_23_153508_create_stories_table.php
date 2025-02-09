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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('story_title');
            $table->string('story_writer');
            $table->date('story_date');
            $table->text('story_description');
            $table->string('story_category');
            $table->decimal('story_rating', 3, 2)->default(0); // Example: 4.5
            $table->unsignedBigInteger('click_count')->default(0);
            $table->unsignedBigInteger('rating_count')->default(0);
            $table->text('story_details');
            $table->string('banner')->nullable();
            $table->string('img')->nullable();
            $table->string('img_title')->nullable();
            $table->string('img1')->nullable();
            $table->string('img1_title')->nullable();
            $table->string('img2')->nullable();
            $table->string('img2_title')->nullable();
            $table->string('img3')->nullable();
            $table->string('img3_title')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
