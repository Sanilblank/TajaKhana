<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChefResponsibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chef_responsibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chef_id')
                  ->constrained('chefs')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('branchmenu_id')
                  ->constrained('branch_menus')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->integer('branch_id');
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
        Schema::dropIfExists('chef_responsibilities');
    }
}
