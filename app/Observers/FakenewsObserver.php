<?php

namespace App\Observers;

use App\Fakenews;
use App\FakenewsStatistics;
//use App\FakenewsLog;

use Auth;

class FakenewsObserver
{
    /**
     * Handle the helpline "created" event.
     *
     * @param  \App\Fakenews  $fakenews
     * @return void
     */
    
    public function created(Fakenews $fakenews)
    {

        $statistics = new FakenewsStatistics(
            collect($fakenews)->only(
                                    'age',
                                    'gender',
                                    'report_role',
                                    'fakenews_source_type',
                                    'fakenews_type',
                                    'evaluation',
                                    'img_upload',
                                    'user_opened',
                                    'user_assigned',
                                    'priority',
                                    'reference_by',
                                    'reference_to',
                                    'actions',
                                    'status',
                                    'call_time',
                                    'manager_comments',
                                    'insident_reference_id')->all());
        
        $statistics->loc_available = (isset($fakenews->country) | 
        isset($fakenews->town) | 
        isset($fakenews->area_district) |
        isset($fakenews->specific_address)) 
        ? 1: 0;
    
        $statistics->fakenews_type = isset($fakenews->fakenews_type) ? $fakenews->fakenews_type: 'Undefined';
        $statistics->tracking_id = $fakenews->id;
        
        $statistics->save();

        //$log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'CREATE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        //$log->save();
    }

    /**
     * Handle the helpline "updated" event.
     *
     * @param  \App\FakenewsStatistics  $fakenews
     * @return void
     */
    public function updated(Fakenews $fakenews)
    {

        $statistics = FakenewsStatistics::updateOrCreate(
            ['tracking_id' => $fakenews->id],
            collect($fakenews)->only(
                                    'age',
                                    'gender',
                                    'report_role',
                                    'fakenews_source_type',
                                    'fakenews_type',
                                    'evaluation',
                                    'img_upload',
                                    'user_opened',
                                    'user_assigned',
                                    'priority',
                                    'reference_by',
                                    'reference_to',
                                    'actions',
                                    'status',
                                    'call_time',
                                    'manager_comments',
                                    'insident_reference_id')->all());

        $statistics->loc_available = (isset($fakenews->country) | 
        isset($fakenews->town) | 
        isset($fakenews->area_district) |
        isset($fakenews->specific_address)) 
        ? 1: 0;

        $statistics->age = (isset($fakenews->age)) ? $fakenews['age'] : 'Not Set';
        $statistics->gender = (isset($helpline->gender)) ? $fakenews['gender'] : 'Not set';
        $statistics->report_role = (isset($helpline->report_role)) ? $fakenews['report_role'] : 'Not set';
        $statistics->priority = (isset($fakenews->priority)) ? $fakenews['priority'] : 'Not set';
        $statistics->reference_by = (isset($fakenews->reference_by)) ? $fakenews['reference_by'] : 'Not set';
        $statistics->reference_to = (isset($fakenews->reference_to)) ? $fakenews['reference_to'] : 'Not set';
        $statistics->actions = (isset($fakenews->actions)) ? $fakenews['actions'] : 'Not set';
        $statistics->save();

        //$log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'UPDATE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        //$log->save();
    }

    /**
     * Handle the helpline "deleted" event.
     *
     * @param  \App\Fakenews  $fakenews
     * @return void
     */
    public function deleted(Fakenews $fakenews)
    {
        $statistics = FakenewsStatistics::where('tracking_id', '=', $fakenews->id)->first();
        $statistics -> delete();

        //$log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'DELETE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        //$log->save();
    }

    /**
     * Handle the helpline "restored" event.
     *
     * @param  \App\Fakenews  $fakenews
     * @return void
     */
    public function restored(fakenews $fakenews)
    {

    }

    /**
     * Handle the helpline "force deleted" event.
     *
     * @param  \App\Fakenews  $fakenews
     * @return void
     */
    public function forceDeleted(fakenews $fakenews)
    {
        $statistics = FakenewsStatistics::where('tracking_id', '=', $fakenews->id)->first();
        $statistics -> delete();

        //$log = new HelplinesLog(array_merge(collect($fakenews)->all(), ['change' => 'DELETE', 'changed_by' => Auth::id(), 'reference_id' => $fakenews->id]));
        //$log->save();
    }
}
