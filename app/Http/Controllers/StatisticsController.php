<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\ReportRole;
use App\ResourceType;
use App\ContentType;
use App\SubmissionType;
use App\ReferenceBy;
use App\ReferenceTo;
use App\Status;
use App\ActionTaken;
use App\Statistics;
use Validator;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $submission_types = SubmissionType::all();
        $report_roles = ReportRole::all();
        $resource_types = ResourceType::all();
        $content_types = ContentType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $actions = ActionTaken::all();

        $users = User::all();
        $status = Status::all();
        $statistics = Statistics::all();
        //$statistics = Statistics::paginate(10);

        return view('statistics.index',[
            'report_roles'=>$report_roles,
            'resource_types'=>$resource_types,
            'content_types'=>$content_types,
            'submission_types'=> $submission_types,
            'statistics' => $statistics,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'users' => $users,
            'status'=> $status,
            'actionsTaken' => $actions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $report_roles = ReportRole::all();
        $content_types = ContentType::all();
        $resource_types = ResourceType::all();
        $actions = ActionTaken::all();
        $references_by = ReferenceTo::all();
        $references_to = ReferenceBy::all();
    
        $submission_types = SubmissionType::all();
        $report_roles = ReportRole::all();

        $users = User::all();
        $status = Status::all();
        
        $request->flash();

        // --------------- //
        // FORM VALIDATION //
        $validator = Validator::make($request->all(), [
            'fromDate' => 'nullable|date',
            'toDate' => 'nullable|date',
        ])->validate(); 

        // --------------- //
        // APPLY FILTERING //
        $statusSelected = $request->filterStatus;

        if($request->fromDate == null){
            $fromDate = "*";
        } else {
            //Change the received date with carbon so we can search in our database with its structure
            $date = Carbon::parse($request->fromDate)->format('Y-m-d H:i:s');
            $fromDate = new \DateTime($date);
            $fromDate->setTime(1,0);
        }

        if($request->toDate == null){
            $toDate = Carbon::now();
        } else {
            //Change the received date with carbon so we can search in our database with its structure
            $date = Carbon::parse($request->toDate)->format('Y-m-d H:i:s');
            $toDate = new \DateTime($date);
            $toDate->setTime(23,0);
        }

        //check user permissions
        $user = auth()->user();
        $IsUserOnlyHelpline=$user->hasRole("Ηelpline") ;

        
        //dd($IsUserOnlyHelpline);
        if (!$IsUserOnlyHelpline) {
            // ...set filters but dont get resuts yet, due to pagination and export conflict
            $statistics = Statistics::ofStatus($statusSelected)->get()->whereBetween('created_at', [$fromDate, $toDate]);
        }
        else {
            // ...set filters but dont get resuts yet, due to pagination and export conflict and also check
            //to show the helpline only statistics
            $statistics = Statistics::ofStatus($statusSelected)->get()->whereBetween('created_at', [$fromDate, $toDate])->where('is_it_hotline','false');
        }

        // --------------- //
        // EXPORT RESULTS  //
        if($request->exportThis != null) {

            $date = new \DateTime();
            $tbody ='';
            
            foreach( $statistics as $index => $value ) {
                $tbody .= '
                    <tr>
                        <td>'. $index . '</td>
                        <td>'. $value->resource_type .'</td>
                        <td>'. $value->content_type .'</td>
                        <td>'. $value->age .'</td>
                        <td>'. $value->gender .'</td>
                        <td>'. $value->reference_by .'</td>
                        <td>'. $value->reference_to .'</td>
                        <td>'. $value->actions .'</td>
                        <td>'. $value->priority .'</td>
                        <td>'. $value->submission_type .'</td>
                        <td>'. $value->status .'</td>
                        <td>'. $value->created_at .'</td>
                        <td>'. $value->updated_at .'</td>
                    </tr>';
            }

            $output = '
                <table class="table" bordered="1">
                    <thead>
                        <tr>
                            <th>Entry </th>
                            <th>Resource Type</th>
                            <th>Content Type</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Reference by</th>
                            <th>Reference to</th>
                            <th>Operator actions</th>
                            <th>Priority</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $tbody .'
                    </tbody>
                </table>
            ';
            header("Content-Type: application/xls");
            header("Content-Disposition:attachment; filename =". $date->format('d/m/Y') .".xls");
            echo $output;

        // --------------- //
        // FILTER VIEW     //
        } else {

            //$statistics = $statistics->paginate(10);

            return view('statistics.index',[
                'report_roles'=>$report_roles,
                'resource_types'=>$resource_types,
                'content_types'=>$content_types,
                'submission_types'=> $submission_types,                
                'statistics' => $statistics ,
                'reference_by' => $references_by, 
                'reference_to' => $references_to, 
                'users' => $users,
                'status'=> $status, 
                'actionstaken' => $actions
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function show(Statistics $statistics)
    {
        
        $date = new \DateTime();
            $tbody ='';
            
            foreach( $statistics as $index => $value ) {
                $tbody .= '
                    <tr>
                        <td>'. $index . '</td>
                        <td>'. $value->resource_type .'</td>
                        <td>'. $value->content_type .'</td>
                        <td>'. $value->age .'</td>
                        <td>'. $value->gender .'</td>
                        <td>'. $value->reference_by .'</td>
                        <td>'. $value->reference_to .'</td>
                        <td>'. $value->actions .'</td>
                        <td>'. $value->priority .'</td>
                        <td>'. $value->submission_type .'</td>
                        <td>'. $value->status .'</td>
                        <td>'. $value->created_at .'</td>
                        <td>'. $value->updated_at .'</td>
                    </tr>';
            }

            $output = '
                <table class="table" bordered="1">
                    <thead>
                        <tr>
                            <th>Entry </th>
                            <th>Resource Type</th>
                            <th>Content Type</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Reference by</th>
                            <th>Reference to</th>
                            <th>Operator actions</th>
                            <th>Priority</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $tbody .'
                    </tbody>
                </table>
            ';

            header("Content-Type: application/xls");
            header("Content-Disposition:attachment; filename =". $date->format('d/m/Y') .".xls");
            echo $output;
    }

}

