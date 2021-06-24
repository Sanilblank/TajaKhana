<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombomenuRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combomenu_requests', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->integer('menuitem_id');
            $table->longText('description');
            $table->string('contactno');
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
        Schema::dropIfExists('combomenu_requests');
    }
}
