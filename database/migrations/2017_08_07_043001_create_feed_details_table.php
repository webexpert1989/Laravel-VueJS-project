<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('feed_details', function (Blueprint $table) {
      $table->increments('id');
      $table->string('link');
      $table->string('app_bundle_id');
      $table->integer('feed_id')->unsigned();

      $table->foreign('app_bundle_id')
        ->references('bundle_id')->on('apps')
        ->onDelete('cascade');

      $table->foreign('feed_id')
        ->references('id')->on('feeds')
        ->onDelete('cascade');

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('feed_details');
  }
}
