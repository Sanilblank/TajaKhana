<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookbookItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cookbook_items', function (Blueprint $table) {
            $table->id();
            $table->string('itemname');
            $table->json('category');
            $table->string('slug');
            $table->string('itemimage');
            $table->string('recipeby');
            $table->string('recipebyimage');
            $table->string('serving');
            $table->string('timetoprepare');
            $table->string('timetocook');
            $table->longText('description');
            $table->string('course');
            $table->string('cuisine');
            $table->string('timeofday');
            $table->integer('levelofcooking_id');
            $table->string('recipetype_id');
            $table->longText('ingredients');
            $table->longText('steps');
            $table->integer('view_count')->default(0);
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
        Schema::dropIfExists('cookbook_items');
    }
}
