<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailFilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('email_files', function (Blueprint $table) {
      $table->id();
      $table->bigInteger('email_id')->unsigned();
      $table->foreign('email_id')->references('id')->on('emails');
      $table->string('admin_id', 40);
      $table->foreign('admin_id')->references('uid')->on('admins');
      $table->string('file_name');
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
    Schema::dropIfExists('email_files');
  }
}
