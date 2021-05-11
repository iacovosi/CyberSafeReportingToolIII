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
            //general
            $table->integer('evaluation')->nullable();
            $table->string('fakenews_source_type'); 
            $table->string('fakenews_type')->default('Undefined');
            $table->string('country')->nullable();
            $table->string('town')->nullable();
            $table->string('area_district')->nullable();
            $table->string('specific_address')->nullable();
            $table->string('submission_type');
            //certain things
            $table->boolean('img_upload');
            $table->longtext('comments');
            $table->date('publication_date');
            $table->dateTime('publication_time',$precision = 0)->nullable(); 
            // user profile
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('report_role')->nullable();
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
            $table->BigInteger('insident_reference_id')->unsigned()->nullable();              // insident_id
            $table->foreign('insident_reference_id')->references('id')->on('fakenews')->onDelete('cascade'); // insident_id            
            //the call time
            $table->dateTime('call_time')->default(DB::raw('CURRENT_TIMESTAMP'));
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
