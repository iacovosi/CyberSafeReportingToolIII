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
use App\Gender;
use App\Fakenews;
use App\FakenewsType;
use App\FakenewsPictures;
use App\FakenewsPictureReff;
use App\FakenewsSourceType;
use App\FakenewsStatistics;
use App\report_chart_type;
use App\Charts\FakenewsStatisticsChart;

use Lang;
use Session;
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
        //dd(Statistics::where('is_it_hotline','=','true')->count());
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gen_charts(Request $request)
    {
        $report_chart_types = report_chart_type::all();
        $charts = Array();

        if(!empty($request->to_date))
            {
                //dd($request->all(); 
                // Set validation rules for fields
                $rules = [
                    'from_date' => 'required|date',
                    'to_date' => 'required|date|after:from_date|before:tomorrow',
                    'data_sellection' => 'required',
                    'chart_type' => 'required|array'
                ];
                // Generate a new validator instance
                $validator = Validator::make($request->all(), $rules, Lang::get('validation.custom.entry', array(), Session::get('lang')));
                if ($validator->fails()) {
                    return redirect()->back()->with(['errors' => $validator->messages()])->withInput();
                }
                
                
                $data = $request->all();
                $all_check = false;
                function querry_call($request){
                    $data=$request->all();
                    $end_of_day_to_date = Carbon::parse($request->to_date)->endOfDay()->format('Y-m-d H:m:s');
                    if ($data['data_sellection'] == 'helpline'){
                        $stats =  Statistics::whereBetween('created_at',[$data['from_date'], $end_of_day_to_date])->where('is_it_hotline','=','false');
                    }else if ($data['data_sellection'] == 'hotline'){
                        $stats =  Statistics::whereBetween('created_at',[$data['from_date'], $end_of_day_to_date])->where('is_it_hotline','=','true');
                    }else if ($data['data_sellection'] == 'fakenews'){
                        $stats =  FakenewsStatistics::whereBetween('created_at',[$data['from_date'], $end_of_day_to_date]);
                    }
                    return($stats);
                }


                //the all charts check
                if (in_array('all',$data['chart_type'])){
                    $all_check = true;
                }
                // generating the requested charts
                if (in_array('Adult to Non-Adult Ratio',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    $All_cases=$stats->count();
                    $adults_num = $stats->where('age','=','18+')->count();
                    $non_adult_num = $All_cases-$adults_num ;
                    $data_age = [$adults_num,$non_adult_num];
                    $age_lab = ['Adults', 'Non-adults'];
                    $age_chart = new FakenewsStatisticsChart;
                    $age_chart -> labels($age_lab);
                    $age_chart -> dataset('Adults vs Non-adults','bar',$data_age)->backgroundColor(['yellow','blue']);
                    $age_chart -> title('Adults vs Non-adults');
                    array_push($charts,$age_chart);
                }
                //dd(Carbon::parse($request->to_date)->diffInMonths(Carbon::parse($request->from_date)->format('Y-m-d')));
                // generating the requested charts
                
                if (in_array('Monthly Report Counts',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    $num_months = Carbon::parse($request->to_date)->diffInMonths(Carbon::parse($request->from_date)->format('Y-m-d')) +1  ;
                    $init_date = $request->from_date;
                    $cases_dataset = Array();
                    $cases_labels = Array();
                    //dd($num_months);
                    for ($i = 0 ; $i < $num_months; $i++){
                        $end_of_month = Carbon::parse($init_date)->endOfMonth();
                        if ($i==$num_months-1){
                            $end_of_month=Carbon::parse($request->to_date)->endOfDay()->format('Y-m-d H:m:s');
                            //dd($end_of_month);
                        }
                        //dd(date('Y/m/d',strtotime($init_date)));
                        //dd($stats->pluck('id'));
                        $num_cases = $stats->whereBetween('created_at',[date($init_date), date('Y-m-d H:m:s',strtotime($end_of_month))])->count();
                        array_push($cases_dataset, $num_cases);
                        array_push($cases_labels, date('Y/m/d',strtotime($init_date)) . ' - '.date('Y/m/d',strtotime($end_of_month)));
                        if ($i!=$num_months-1){
                            $init_date = $end_of_month->addDay();
                        }
                        $stats = querry_call($request);

                    }
                    //dd([$cases_labels,$cases_dataset]);
                    $cases_chart = new FakenewsStatisticsChart;
                    $cases_chart -> labels($cases_labels);
                    $cases_chart -> dataset('Reported Cases Per Month','bar',$cases_dataset)->backgroundColor('blue');
                    $cases_chart -> title('Reported Cases Per Month');
                    array_push($charts,$cases_chart);
                }

                if (in_array('Description of Reporters',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    $role_types = ReportRole::pluck('name')->values();
                    $role_dataset = Array();
                    $role_labels = Array();
                    //dd($role_types);
                    foreach($role_types as $role){
                        $cntr = $stats->where('report_role', '=', $role)->count();
                        array_push($role_dataset, $cntr);
                        array_push($role_labels,$role);
                        $stats = querry_call($request);
                    }
                    //dd($role_dataset);
                    $cntr = $stats->where('report_role', '=', 'Not set')->count();
                    array_push($role_dataset, $cntr);
                    array_push($role_labels, 'Not set');
                    $roles_chart = new FakenewsStatisticsChart;
                    $roles_chart -> labels($role_labels);
                    $roles_chart -> dataset('Cases Reported by Each Role','bar',$role_dataset)->backgroundColor(['blue','blue','yellow','yellow','blue','blue']);
                    $roles_chart -> title('Cases Reported by Each Role');
                    array_push($charts,$roles_chart);
                }

                if (in_array('Gender Ratio',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    $genders = Gender::pluck('name')->values();
                    $gender_dataset = Array();
                    $gender_labels = Array();
                    //dd($role_types);
                    foreach($genders as $gender){
                        $cntr = $stats->where('gender', '=', $gender)->count();
                        array_push($gender_dataset, $cntr);
                        array_push($gender_labels, $gender);
                        $stats = querry_call($request);
                    }
                    $cntr = $stats->where('gender', '=','Not set')->count();
                    array_push($gender_dataset, $cntr);
                    array_push($gender_labels, 'Not set');
                    //dd([$genders,$gender_dataset]);
                    $gender_chart = new FakenewsStatisticsChart;
                    $gender_chart -> labels($gender_labels);
                    $gender_chart -> dataset('Cases Reported by Each Gender','bar',$gender_dataset)->backgroundColor(['yellow','blue']);
                    $gender_chart -> title('Cases Reported by Each Gender');
                    array_push($charts,$gender_chart);
                }

                if (in_array('Report Methods',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    $sub_types = SubmissionType::pluck('name')->values();
                    $sub_type_dataset = Array();

                    foreach($sub_types as $type){
                        $cntr = $stats->where('submission_type', '=', $type)->count();
                        array_push($sub_type_dataset, $cntr);
                        $stats = querry_call($request);
                    }

                    $sub_type_chart = new FakenewsStatisticsChart;
                    $sub_type_chart -> labels($sub_types);
                    $sub_type_chart -> dataset('Cases Reported by Each Submission Method','bar',$sub_type_dataset)->backgroundColor('blue');
                    $sub_type_chart -> title('Cases Reported by Each Submission Method');
                    array_push($charts,$sub_type_chart);
                }
                if (in_array('Report Types',$data['chart_type']) | ($all_check == true)){
                    $stats = querry_call($request);

                    if ($data['data_sellection']=='helpline'){
                        $rep_types = ContentType::where('is_for','=','helpline')->pluck('name')->values();
                    }else if($data['data_sellection']=='hotline'){
                        $rep_types = ContentType::where('is_for','=','hotline')->pluck('name')->values();
                    }else if($data['data_sellection']=='fakenews'){
                        $rep_types = FakenewsSourceType::pluck('typename')->values();
                    }
                    $cont_type_dataset = Array();

                    foreach($rep_types as $type){
                        if ($data['data_sellection']=='helpline'|$data['data_sellection']=='hotline'){
                            $cntr = $stats->where('content_type', '=', $type)->count();
                        }else if ($data['data_sellection']=='fakenews'){
                            $cntr = $stats->where('fakenews_source_type', '=', $type)->count();
                        }
                        array_push($cont_type_dataset, $cntr);
                        $stats = querry_call($request);
                    }

                    $cont_type_chart = new FakenewsStatisticsChart;
                    $cont_type_chart -> labels($rep_types);
                    $cont_type_chart -> dataset('Cases Reported for Each Source Type','bar',$cont_type_dataset)->backgroundColor('blue');
                    $cont_type_chart -> title('Cases Reported for Each Source Type');
                    array_push($charts,$cont_type_chart);
                }
            }

        return view('statistics.gen_graphs',[
            'report_chart_types' => $report_chart_types,
            'charts' => $charts
            ]);
    }

}