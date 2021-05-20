<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tracking_id');
            $table->string('is_it_hotline')->nullable();
            $table->string('forwarded')->nullable();
            $table->string('submission_type')->nullable();
            // user profile
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();            
            // report description
            $table->string('resource_type');
            $table->string('content_type');
            // operator actions
            $table->integer('user_opened')->unsigned()->nullable();
            $table->foreign('user_opened')->references('id')->on('users');
            $table->unsignedInteger('user_assigned')->nullable();
            $table->foreign('user_assigned')->references('id')->on('users');
            //            
            $table->string('priority')->nullable();
            $table->string('reference_by')->nullable();
            $table->string('reference_to')->nullable();
            $table->longtext('actions')->nullable();
            $table->string('status');
            //
            $table->string('job')->nullable();
            $table->string('form_type')->nullable();

            //manager comments
            $table->text('manager_comments')->nullable();
            //field to connect insident with another
            $table->unsignedInteger('insident_reference_id')->nullable();            // insident_id
            $table->foreign('insident_reference_id')->references('id')->on('helplines'); // insident_id
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
        Schema::dropIfExists('statistics');
    }
}
