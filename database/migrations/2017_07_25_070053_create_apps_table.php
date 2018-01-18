<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('apps', function (Blueprint $table) {
      $table->increments('id');
      $table->string('title');
      $table->string('bundle_id')->unique();
      $table->enum('layout', ['grid', 'list'])->default('grid');
       $table->integer('user_id')->unsigned();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('apps');
  }
}
