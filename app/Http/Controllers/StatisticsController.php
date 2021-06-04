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

use App\Fakenews;
use App\FakenewsType;
use App\FakenewsPictures;
use App\FakenewsPictureReff;
use App\FakenewsSourceType;
use App\FakenewsStatistics;
use App\Charts\FakenewsStatisticsChart;

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

        $earliest_date = date(Statistics::orderBy('created_at')->pluck('created_at')->first());
        $up_to =  date('Y-m-d h:i:s', strtotime($earliest_date. '+7 day'));
        $data_week_help_cntr = Array();
        $data_week_hot_cntr = Array();
        $data_date = Array();
        while ($up_to  < date(today())){

            $help_cnt = Statistics::where('is_it_hotline','=','false')->whereBetween('created_at',[$earliest_date,$up_to])->count();
            $hot_cnt = Statistics::where('is_it_hotline','=','true')->whereBetween('created_at',[$earliest_date,$up_to])->count();

            array_push($data_week_help_cntr,$help_cnt);
            array_push($data_week_hot_cntr,$hot_cnt);
            array_push($data_date,date('Y-m-d',strtotime($earliest_date)) . ' to ' . date('Y-m-d', strtotime($up_to)));
            $earliest_date = date('Y-m-d h:i:s', strtotime($earliest_date. '+7 day'));
            $up_to = date('Y-m-d h:i:s', strtotime($up_to. '+7 day'));
        }
        array_push($data_week_help_cntr,Statistics::where('is_it_hotline','=','false')->count()-array_sum($data_week_help_cntr));
        array_push($data_week_hot_cntr,Statistics::where('is_it_hotline','=','true')->count()-array_sum($data_week_hot_cntr));
        array_push($data_date,date('Y-m-d',strtotime($earliest_date)) . ' to ' . 'today');
        //dd([$data_date,$data_week_help_cntr,$data_week_hot_cntr]);

        $weekly_input = new FakenewsStatisticsChart;
        $weekly_input->labels($data_date);
        $weekly_input->dataset('Helpline Reports made','bar',$data_week_help_cntr)->backgroundColor('yellow');
        $weekly_input->dataset('Hotline Reports made','bar',$data_week_hot_cntr)->backgroundColor('red');
        $weekly_input-> title('Number of reports per week');
        
        $resource_pie_data = Array();
        $resources = $resource_types->pluck('name')->values();
        foreach($resources as $source){
            $cntr = Statistics::where('resource_type','=',$source)->pluck('id')->count();
            array_push($resource_pie_data,$cntr);
        }
        $sourcetype_pie = new FakenewsStatisticsChart;
        $sourcetype_pie -> labels($resources);
        $sourcetype_pie -> dataset('Resource Type Pie Distribution','pie',$resource_pie_data)->backgroundColor(['green','red','purple','blue','yellow']);
        $sourcetype_pie -> title('Resource Type Pie Distribution');
        $sourcetype_pie -> displayAxes(false);

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
            'actionsTaken' => $actions,
            'weekly_bar' => $weekly_input,
            'Helpline_types'=> $sourcetype_pie 
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_fakenews(Request $request)
    {
        //
        $submission_types = SubmissionType::all();
        $report_roles = ReportRole::all();
        $fakenews_source_type = FakenewsSourceType::all();
        $fakenews_types = FakenewsType::all();
        $references_by = ReferenceBy::all();
        $references_to = ReferenceTo::all();
        $actions = ActionTaken::all();

        $users = User::all();
        $status = Status::all();
        $statistics = FakenewsStatistics::all();
        //$statistics = Statistics::paginate(10);

        $earliest_date = date(FakenewsStatistics::orderBy('created_at')->pluck('created_at')->first());
        $up_to =  date('Y-m-d h:i:s', strtotime($earliest_date. '+7 day'));
        $data_week_cntr = Array();
        $data_date = Array();
        while ($up_to  < date(today())){
            //dd($up_to  < date(today()));
            $cnt = FakenewsStatistics::whereBetween('created_at',[$earliest_date,$up_to])->count();
            //dd($cnt);
            array_push($data_week_cntr,$cnt);
            array_push($data_date,date('Y-m-d',strtotime($earliest_date)) . ' to ' . date('Y-m-d', strtotime($up_to)));
            $earliest_date = date('Y-m-d h:i:s', strtotime($earliest_date. '+7 day'));
            $up_to = date('Y-m-d h:i:s', strtotime($up_to. '+7 day'));
            //dd($up_to);
        }
        array_push($data_week_cntr,FakenewsStatistics::pluck('id',)->count()-array_sum($data_week_cntr));
        array_push($data_date,date('Y-m-d',strtotime($earliest_date)) . ' to ' . 'today');
        //dd([$data_week_cntr,$data_date]);

        $weekly_input = new FakenewsStatisticsChart;
        $weekly_input->labels($data_date);
        $weekly_input->dataset('Reports made','bar',$data_week_cntr)->backgroundColor('purple');
        $weekly_input-> title('Number of reports per week');
        
        $fakenews_source_pie_data = Array();
        $fake_sources = $fakenews_source_type->pluck('typename_en')->values();
        foreach($fake_sources as $source){
            $cntr = FakenewsStatistics::where('fakenews_source_type','=',$source)->pluck('id')->count();
            array_push($fakenews_source_pie_data,$cntr);
        }
        $sourcetype_pie = new FakenewsStatisticsChart;
        $sourcetype_pie -> labels($fake_sources);
        $sourcetype_pie -> dataset('Fakenews Source Pie Distribution','pie',$fakenews_source_pie_data)->backgroundColor(['green','red','purple','blue','yellow','grey']);
        $sourcetype_pie -> title('Fakenews Source Pie Distribution');
        $sourcetype_pie -> displayAxes(false);

        //$chart->labels([1,2,3,4]);
        //$chart->dataset('Fakenews test chart','line',[1,2,3,4]);


        return view('statistics.index_fakenews',[
            'report_roles'=>$report_roles,
            'fakenews_source_type'=>$fakenews_source_type,
            'fakenews_types'=>$fakenews_types,
            'submission_types'=> $submission_types,
            'statistics' => $statistics,
            'references_by' => $references_by,
            'references_to' => $references_to,
            'users' => $users,
            'status'=> $status,
            'actionsTaken' => $actions,
            'weekly_bar' => $weekly_input,
            'fakenews_source_pie'=> $sourcetype_pie 
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
        $IsUserOnlyHelpline=$user->hasRole("helpline") ;

        
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

