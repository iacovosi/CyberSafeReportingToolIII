<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Status;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;

class Helpline extends Model
{        
    use SoftDeletes;

    protected $fillable = [
        // 'resourcetype','contenttype','age','comments','phone','name','surname','email','log','status','user_id','actions','reference','referal','gender','vector','is_it_hotline','submission_type','transfer_from', 'operator'];
        'is_it_hotline','submission_type',
        'name','surname','email','phone','age','gender','report_role',
        'resource_type','resource_url','content_type','comments',
        'user_opened','user_assigned','priority','reference_by','reference_to','actions','status',
        'log','insident_reference_id','call_time','manager_comments',
    ];

    protected $attributes= [
        'submission_type' => 'electronic-form',
    ];

    public function hasStatus(){
        return $this->hasOne(Status::class,'id','status');
    }

    public function firstResponder()
    {
        return $this->hasOne('App\User','id','user_opened');
    }
    public function lastResponder()
    {
        return $this->hasOne('App\User','id','user_assigned');
    }

    public function scopeOfStatus($query, $status)
    {
        if ($status == "*") {
            return $query->where('status', '<>', "Closed");
        } else {
            return $query->whereStatus($status);
        }
    }

    public static function softDelete($before){

        $records = Helpline::where('status', '=', 'Closed')
                            ->where( 'updated_at', '<=', $before )->get();

        
        foreach($records as $record){
            Helpline::archieve($record->id);
        }

    }

    public static function archieve($id){

        $record = Helpline::find($id);

        $record->name = Crypt::encrypt($record->name);
        $record->surname = Crypt::encrypt($record->surname);
        $record->email = Crypt::encrypt($record->email);
        $record->phone = Crypt::encrypt($record->phone);
        $record->resource_url = Crypt::encrypt($record->resource_url);


        $record->timestamps = false;
        $record->save();
        $record->delete();
    }


    public static function recover($id){

        Helpline::withTrashed()
                ->where('id', $id)
                ->restore();
        

        $record = Helpline::find($id);
        
        $record->name = Crypt::decrypt($record->name);
        $record->surname = Crypt::decrypt($record->surname);
        $record->email = Crypt::decrypt($record->email);
        $record->phone = Crypt::decrypt($record->phone);
        $record->resource_url = Crypt::decrypt($record->resource_url);

        $record->save();
    }


    public function relatedToStatistics(){
        return $this->hasOne('App\Statistics','tracking_id','id');
    }
}
