<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferencesByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references_by', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');            
            $table->string('display_name_gr');
            $table->string('display_name_en');
            $table->text('description_gr')->nullable();
            $table->text('description_en')->nullable();
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
        Schema::dropIfExists('references_by');
    }
}
