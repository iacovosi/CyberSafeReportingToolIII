<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakenewsPicturesReffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakenews_pictures_reff', function (Blueprint $table) {
            $table->BigInteger('fakenews_reference_id')->unsigned()->nullable();            // fakenews id
            $table->foreign('fakenews_reference_id')->references('id')->on('fakenews')->onDelete('cascade');

            $table->BigInteger('picture_reference_id')->unsigned()->nullable();            // pictures id
            $table->foreign('picture_reference_id')->references('id')->on('fakenews_pictures')->onDelete('cascade'); 

        });
    }

    /** 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fakenews_picture_reff');
    }
}
