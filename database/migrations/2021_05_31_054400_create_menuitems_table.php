<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuitems', function (Blueprint $table) {
            $table->id();
            $table->json('category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('price');
            $table->string('discount');
            $table->string('quantity');
            $table->string('unit');
            $table->longText('details');
            $table->boolean('status');
            $table->boolean('featured');
            $table->string('costprice');
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
        Schema::dropIfExists('menuitems');
    }
}
