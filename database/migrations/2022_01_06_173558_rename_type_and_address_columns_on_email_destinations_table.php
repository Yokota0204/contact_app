<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTypeAndAddressColumnsOnEmailDestinationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('email_destinations', function (Blueprint $table) {
      $table->renameColumn('destination_type', 'type');
      $table->renameColumn('destination_address', 'address');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('email_destinations', function (Blueprint $table) {
      $table->renameColumn('type', 'destination_type');
      $table->renameColumn('address', 'destination_address');
    });
  }
}
