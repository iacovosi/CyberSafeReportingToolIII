<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakenewsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakenews_logs', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedInteger('reference_id')->nullable();            // insident_id
            $table->foreign('reference_id')->references('id')->on('helplines')->onDelete('cascade');
            $table->string('change'); // UPDATE, DELETE, CREATE etc
            $table->integer('changed_by')->unsigned()->nullable();
            $table->foreign('changed_by')->references('id')->on('users'); // who made the change?
            $table->string('fakenews_type');
            $table->integer('evaluation')->nullable();
            $table->string('submission_type');
            // user profile
            $table->text('name')->nullable();
            $table->text('surname')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();
            // report description
            $table->string('fakenews_source_type');
            $table->text('comments')->nullable();
            //internet
            $table->string('source_url')->nullable(); 
            $table->string('title')->nullable(); 
            $table->longtext('source_document')->nullable(); 
            //TV
            $table->string('tv_channel')->nullable(); 
            $table->string('tv_prog_title')->nullable(); 
            //Radio
            $table->string('radio_station')->nullable();
            $table->decimal('radio_freq',$precision = 8, $scale = 3)->nullable(); 
            //newspaper
            $table->string('newspaper_name')->nullable();
            $table->integer('page')->nullable();
            //other
            $table->string('specific_type')->nullable();
            $table->boolean('img_upload');
            $table->string('country')->nullable();
            $table->string('town')->nullable();
            $table->string('area_district')->nullable();
            $table->string('specific_address')->nullable();
            $table->date('publication_date');
            $table->time('publication_time',$precision = 0)->nullable(); 
            $table->string('submission_type');
            // operator actions
            $table->integer('user_opened')->unsigned()->nullable();          // user_opened_id
            $table->foreign('user_opened')->references('id')->on('users');   // user_id
            $table->unsignedInteger('user_assigned')->nullable();            // user_assigned_id
            $table->foreign('user_assigned')->references('id')->on('users'); // user_id
            $table->string('priority')->default('normal');
            $table->string('reference_by')->nullable();
            $table->string('reference_to')->nullable();
            $table->longtext('actions')->nullable();
            $table->string('status')->default('New');
            // misc
            $table->text('specialty')->nullable();
            //manager comments
            $table->text('manager_comments')->nullable();
            //field to connect insident with another
            $table->unsignedInteger('insident_reference_id')->nullable();            // link with another insident_id
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
        Schema::dropIfExists('fakenews_logs');
    }
}
