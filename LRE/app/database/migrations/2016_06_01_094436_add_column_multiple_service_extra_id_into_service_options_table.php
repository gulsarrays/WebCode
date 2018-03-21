<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMultipleServiceExtraIdIntoServiceOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('service_options', function(Blueprint $table)
		{
                    $table->string('multiple_service_extra_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('service_options', function(Blueprint $table)
		{
                    $table->dropColumn('multiple_service_extra_id');
		});
	}

}
