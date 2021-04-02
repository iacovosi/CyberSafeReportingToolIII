<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelplinesLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helplines_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reference_id')->nullable();            // insident_id
            $table->foreign('reference_id')->references('id')->on('helplines'); // insident_id
            $table->string('is_it_hotline')->default('false');
            $table->string('submission_type');
            // user profile
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();
            // report description
            $table->string('resource_type');
            $table->string('resource_url')->nullable();
            $table->string('content_type');
            $table->text('comments')->nullable();
            // operator actions
            $table->integer('user_opened')->unsigned()->nullable();          // user_opened_id
            $table->foreign('user_opened')->references('id')->on('users');   // user_id
            $table->unsignedInteger('user_assigned')->nullable();            // user_assigned_id
            $table->foreign('user_assigned')->references('id')->on('users'); // user_id
            //
            $table->string('priority')->default('normal');
            $table->string('reference_by')->nullable();
            $table->string('reference_to')->nullable();
            $table->longtext('actions')->nullable();
            $table->string('status')->default('New');
            // misc
            $table->text('log')->nullable();
            $table->text('specialty')->nullable();
            //
            //manager comments
            $table->text('manager_comments')->nullable();
            //field to connect insident with another
            $table->unsignedInteger('insident_reference_id')->nullable();            // insident_id
            $table->foreign('insident_reference_id')->references('id')->on('helplines'); // insident_id
            //the call time
            $table->dateTime('call_time')->default(DB::raw('CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('helplines_logs');
    }
}
