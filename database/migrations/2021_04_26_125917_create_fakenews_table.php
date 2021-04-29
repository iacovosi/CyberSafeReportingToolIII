<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakenews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longtext('source_document');
            $table->dateTime('publication_date')->nullable(); 
            $table->string('source');
            $table->string('source_url')->nullable(); 
            $table->integer('evaluation');
            $table->string('fakenews_type');
            $table->string('country');
            $table->string('town')->nullable();
            $table->string('specific_area_address')->nullable();
            $table->string('submission_type');
            // user profile
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();
            // meta data
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
        Schema::dropIfExists('fakenews');
    }
}
