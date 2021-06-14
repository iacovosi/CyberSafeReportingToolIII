<?php

namespace App\Observers;

use App\Helpline;
use App\Statistics;
use App\HelplinesLog;

use Auth;

class HelplineObserver
{
    /**
     * Handle the helpline "created" event.
     *
     * @param  \App\Helpline  $helpline
     * @return void
     */
    
    public function created(Helpline $helpline)
    {

        $statistics = new Statistics(
            collect($helpline)->only('is_it_hotline',
                                     'submission_type',
                                    'age',
                                    'gender',
                                    'report_role',
                                    'resource_type',
                                    'content_type',
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

        $statistics->tracking_id = $helpline->id;
        
        $statistics->save();

        $log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'CREATE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        $log->save();
    }

    /**
     * Handle the helpline "updated" event.
     *
     * @param  \App\Statistics  $helpline
     * @return void
     */
    public function updated(Helpline $helpline)
    {

        $statistics = Statistics::updateOrCreate(
            ['tracking_id' => $helpline->id],
            collect($helpline)->only('is_it_hotline',
                                'submission_type',
                                'age',
                                'gender',
                                'report_role',
                                'resource_type',
                                'content_type',
                                'user_opened',
                                'user_assigned',
                                'priority',
                                'reference_by',
                                'reference_to',
                                'actions',
                                'status',
                                'call_time',
                                'manager_comments',
                                'insident_reference_id')->all()
        );

        // fix defaulting
        $statistics->age = (isset($helpline->age)) ? $helpline['age'] : 'Not Set';
        $statistics->gender = (isset($helpline->gender)) ? $helpline['gender'] : 'Not set';
        $statistics->report_role = (isset($helpline->report_role)) ? $helpline['report_role'] : 'Not set';
        $statistics->priority = (isset($helpline->priority)) ? $helpline['priority'] : 'Not set';
        $statistics->reference_by = (isset($helpline->reference_by)) ? $helpline['reference_by'] : 'Not set';
        $statistics->reference_to = (isset($helpline->reference_to)) ? $helpline['reference_to'] : 'Not set';
        $statistics->actions = (isset($helpline->actions)) ? $helpline['actions'] : 'Not set';
        $statistics->save();

        $log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'UPDATE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        $log->save();
    }

    /**
     * Handle the helpline "deleted" event.
     *
     * @param  \App\Helpline  $helpline
     * @return void
     */
    public function deleted(Helpline $helpline)
    {
        $statistics = Statistics::where('tracking_id', '=', $helpline->id)->first();
        $statistics -> delete();

        $log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'DELETE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        $log->save();
    }

    /**
     * Handle the helpline "restored" event.
     *
     * @param  \App\Helpline  $helpline
     * @return void
     */
    public function restored(Helpline $helpline)
    {

    }

    /**
     * Handle the helpline "force deleted" event.
     *
     * @param  \App\Helpline  $helpline
     * @return void
     */
    public function forceDeleted(Helpline $helpline)
    {
        $statistics = Statistics::where('tracking_id', '=', $helpline->id)->first();
        $statistics -> delete();

        $log = new HelplinesLog(array_merge(collect($helpline)->all(), ['change' => 'DELETE', 'changed_by' => Auth::id(), 'reference_id' => $helpline->id]));
        $log->save();
    }
}
