<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailDestinationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('email_destinations', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('email_id')->unsigned();
      $table->foreign('email_id')->references('id')->on('emails');
      $table->string('admin_id', 40);
      $table->foreign('admin_id')->references('uid')->on('admins');
      $table->integer('destination_type')->unsigned();
      $table->string('destination_address', 255);
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
    Schema::dropIfExists('email_destinations');
  }
}
