<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('emails', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('order_id')->unsigned();
      $table->string('sender_id', 40);
      $table->string('subject');
      $table->longText('body');
      $table->timestamps();
      $table->foreign('order_id')->references('id')->on('orders');
      $table->foreign('sender_id')->references('uid')->on('admins');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('emails');
  }
}
