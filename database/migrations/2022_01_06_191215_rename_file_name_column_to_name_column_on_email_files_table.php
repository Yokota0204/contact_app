<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFileNameColumnToNameColumnOnEmailFilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('email_files', function (Blueprint $table) {
      $table->renameColumn('file_name', 'name');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('email_files', function (Blueprint $table) {
      $table->renameColumn('name', 'file_name');
    });
  }
}
