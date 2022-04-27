<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('channel_id');
            $table->string('uid');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_processed')->default(false);
            $table->string('encoding_service_video_id')->nullable();
            $table->string('video_filename')->nullable();
            $table->enum('visibility', ['public', 'unlisted', 'private']);
            $table->boolean('allow_votes')->default(false);
            $table->boolean('allow_comments')->default(false);
            $table->integer('processed_percentage')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
