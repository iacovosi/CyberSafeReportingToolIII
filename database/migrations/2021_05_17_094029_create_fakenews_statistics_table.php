<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakenewsStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakenews_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('tracking_id');
            $table->string('submission_type')->nullable();
            // user profile
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();
            // fakenews report description
            $table->string('fakenews_source_type');
            $table->string('fakenews_type');
            $table->string('evaluation');
            $table->boolean('img_upload');
            // location info available?
            $table->boolean('loc_available');
            // operator actions
            $table->integer('user_opened')->unsigned()->nullable();
            $table->foreign('user_opened')->references('id')->on('users');
            $table->unsignedInteger('user_assigned')->nullable();
            $table->foreign('user_assigned')->references('id')->on('users');
            //admin info
            $table->string('priority')->nullable();
            $table->string('reference_by')->nullable();
            $table->string('reference_to')->nullable();
            $table->longtext('actions')->nullable();
            $table->string('status');
            //manager comments
            $table->text('manager_comments')->nullable();

            //field to connect insident with another
            $table->BigInteger('insident_reference_id')->unsigned()->nullable();         // insident_id
            $table->foreign('insident_reference_id')->references('id')->on('fakenews')->onDelete('cascade'); // insident_id  
            //the call time
            $table->dateTime('call_time')->nullable();

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
        Schema::dropIfExists('fakenews_statistics');
    }
}
