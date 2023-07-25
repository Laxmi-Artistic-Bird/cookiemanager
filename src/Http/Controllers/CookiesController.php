<?php

namespace Artisticbird\Cookies\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PackageMessageController;
use App\Models\User;
use Artisticbird\Cookies\Models\CookieDetail;
use Artisticbird\Cookies\Models\CookiesCategory;
use Artisticbird\Cookies\Models\UserDetail;
use Artisticbird\Cookies\Models\WebCookie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class CookiesController extends Controller
{
    public function index(){
        try{
            // $users = User::whereHas('roles',function($q){
            //     $q->where('name','Cookies');
            // })->get();
            
            return view('addCookiesClient::cookiesClient');
        }catch(Exception $e){
            return "Something went wrong";
        }
    }
    
    public function datatable(Request $request)
    {
        try {
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = !empty($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'created_at'; // Column name
                $columnSortOrder = !empty($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc'; // asc or desc
                $searchValue = $search_arr['value']; // Search value


                //total_counter
                $totalRecords = User::select('count(*) as allcount')->whereHas('roles',function($q){
                    $q->where('name','Cookies');
                })->count();

                //filtered counter
                $totalRecordswithFilter = User::select('count(*) as allcount')->whereHas('roles',function($q){
                    $q->where('name','Cookies');
                })->when($searchValue != '', function ($q) use ($searchValue) {
                    $q->where(function($query) use($searchValue){
                        $query->where('name', 'like', '%' . $searchValue . '%')->orWhere('email', 'like', '%' . $searchValue . '%');
                    })->where('created_by', '1');
                })->where('created_by','1')->count();

                //total records
                $records = User::orderBy($columnName, $columnSortOrder)->whereHas('roles',function($q){
                    $q->where('name','Cookies');
                })->when($searchValue != '', function ($q) use ($searchValue) {
                    $q->where(function($query) use($searchValue){
                        $query->where('name', 'like', '%' . $searchValue . '%')->orWhere('email', 'like', '%' . $searchValue . '%');
                    })->where('created_by', '1');
                    })->where('created_by', '1')->skip($start)
                        ->take($rowperpage)
                        ->get();
                
                $data_arr = array();

               

                foreach ($records as $record) {
                    $id = $record->id ?? '';
                    $name = $record->name ?? '';
                    $email = $record->email ?? '';
                    $company = $record->userdetail[0]->company_key ?? '';
                    $action = '';

                 
                        $action = "<a class='btn btn-primary btn-sm mt-1 me-0 me-lg-2 tooltipss' href='" . route('editCookiesClient', $record->id) . "'><span class='tooltiptext'>".__('Edit')."</span><i class='flaticon-edit'></i></a>";
                        $action.= "<a class='btn btn-primary btn-sm mt-1 me-0 me-lg-2 tooltipss' href='" . route('createCookieContent', $record->id) . "'>".__('Cookie Content')."</a>";
                   
                            $action .= "<form action='" . route('deleteCookiesClient', $record->id) . "' method='POST' accept-charset='UTF-8' style='display:inline' onsubmit='return confirm(&quot;Are you sure?&quot;)'>
                            " . csrf_field() . "
                            " . method_field('DELETE') . "
                            <button type='submit' class='btn btn-danger btn-sm text-white mt-1 tooltipss' data-toggle='tooltip' data-placement='top' title='" . __('Delete') . "'>
                                <i class='flaticon-delete'></i>
                            </button>
                        </form>";
                        
               


                    $data_arr[] = array(
                        "name" => $name ?? '',
                        "email" => $email ?? '',
                        "company_key" => $company ?? '',
                        "action" => $action
                    );
                }


                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr,
                );

                return json_encode($response);
                exit;
            }catch(Exception $e){
                return false; 
            }
    }


    public function create(){
        return view('addCookiesClient::addCookiesClient');
    }

    public function store(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'name'=>'required',
                    'email'=>'required|email|unique:users,email',
                    'domain'=>'required',
                    'company_key'=>'required',
            ]);
    
    
            if($validator->fails())  {
                    $messages = $validator->getMessageBag()->first();
                    return redirect()->back()->with('error',__($messages),'input',$request->all())->withInput();
            }
           

          
            $user = new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make(123456);
            $user->created_by=1;
            $resp = $user->save();
            
            $user->assignRole('Cookies');

            if (!empty($request->domain) && is_array($request->domain)) {
                // Prepare the data array for bulk insert
                $dataToInsert = [];
                foreach ($request->domain as $val) {
                    $url = preg_replace('#^https?://#', '', $val);

                    // Remove the last extra slash from the end of the URL (if exists)
                    $url = rtrim($url, '/');
                    $dataToInsert[] = [
                        'user_id' => $user->id ?? '',
                        'domain' => $url ?? '',
                        'company_key' => $request->company_key ?? '',
                        // Add more columns as needed
                    ];
                }
            
                // Insert the data into the database in a single query
                UserDetail::insert($dataToInsert);
            }
           
           
            if($resp){
                return redirect()->route('CookiesClient')->with('success',__('Details has been successfully submitted'));
            }else{
                return redirect()->back()->with('error',__('Error in insertion'));
            }
        }catch(Exception $e){
            Log::info($e->getMessage());
            return redirect()->back()->with('error',__('Something went wrong, try again'));
        }
    }

    public function edit($id){
        try{
            $details = User::findorFail($id);
           $alldomains = !empty($details->userdetail) ? $details->userdetail : [];
            return view('addCookiesClient::editCookieClient',compact('details','alldomains'));
        }catch(Exception $e){
            return "Something went wrong";
        }
    }

    public function update(Request $request,$id){
            try{
                $validator = Validator::make(
                    $request->all(), [
                        'name'=>'required',
                        'email'=>'required|email|unique:users,email,'.$id,
                        'domain'=>'required',
                        'company_key'=>'required',
                ]);
        
        
                if($validator->fails())  {
                        $messages = $validator->getMessageBag()->first();
                        return redirect()->back()->with('error',__($messages),'input',$request->all())->withInput();
                }
               
    // dd($request->all());
              
                $user = User::findorFail($id);
                $user->name=$request->name;
                $user->email=$request->email;
                $resp = $user->save();
                
                $user->assignRole('Cookies');
       
                if (!empty($request->domain) && is_array($request->domain)) {
                    // Prepare the data array for bulk upsert
                    $dataToUpsert = [];
                    $domains = [];
                    foreach ($request->domain as $val) {
                        $url = preg_replace('#^https?://#', '', $val);
                        // Remove the last extra slash from the end of the URL (if exists)
                        $url = rtrim($url, '/');
                        
                        $domain = ['user_id' => $id ?? '', 'domain' => $url ?? '', 'company_key' => $request->company_key ?? ''];
                
                        // Check if the record exists in the database before adding it to the upsert array
                        $existingRecord = UserDetail::where('user_id', $id)->where('domain', $url)->first();
                
                        if ($existingRecord) {
                            // If the record exists, update it with new values
                            $existingRecord->update($domain);
                        } else {
                            // If the record doesn't exist, add it to the upsert array
                            $dataToUpsert[] = $domain;
                        }
                        
                        $domains[] = $url ?? '';
                    }
                
                    // Perform the bulk insert/update using the upsert method
                    DB::table('userdetails')->upsert($dataToUpsert, ['user_id', 'domain'], ['domain', 'company_key']);
                
                    // Delete records that are not present in the incoming array
                    UserDetail::where('user_id', $id)->whereNotIn('domain', $domains)->delete();
                }
              
                if($resp){
                     return redirect()->route('CookiesClient')->with('success',__('Details has been successfully submitted'));
                }else{
                    return redirect()->back()->with('error',__('Error while updating info'));
                }
            }catch(Exception $e){
                Log::info($e->getMessage());
                return redirect()->back()->with('error',__('Something went wrong, try again'));
            }
    }

    public function deleteCookiesClient($id){
        $resp = User::destroy($id);
        if($resp){
            return redirect()->back()->with('success',__('Client Deleted successfully'));
        }else{
            return redirect()->back()->with('error',__('Error,try again'));
        }
    }


    public function createCookieContent(Request $request,$user_id){
        try{
           $domain = $request->query('domain');
           
            $alldomains = UserDetail::where('user_id',$user_id)->pluck('domain','id')->prepend(__('Select'),'');
            $necessaryDetail = CookieDetail::where('category_id','1')->where('domain_id',$domain)->where('user_id',$user_id)->get();
            $functionalDetail = CookieDetail::where('category_id','2')->where('domain_id',$domain)->where('user_id',$user_id)->get();
            $analyticsDetail = CookieDetail::where('category_id','3')->where('domain_id',$domain)->where('user_id',$user_id)->get();
            $performanceDetail = CookieDetail::where('category_id','4')->where('domain_id',$domain)->where('user_id',$user_id)->get();
            $advDetail = CookieDetail::where('category_id','5')->where('domain_id',$domain)->where('user_id',$user_id)->get();
            $categories = CookiesCategory::pluck('title','id');
            
            return view('addCookiesClient::createCookieContent',compact('categories','user_id','necessaryDetail','functionalDetail','analyticsDetail','performanceDetail','advDetail','alldomains'));
        }catch(Exception $e){
            return "Something went wrong";
        }
    }

    public function editcookieContent($id){
        try{
            $data = CookieDetail::findorFail($id);
            $data->details = !empty($data->details) ? json_decode($data->details,true) : [];
            return $data;
        }catch(Exception $e){
            return "Something went wrong";
        }  
        // $data->category_id = !empty($data->category_id) ? $data->categories->title : '';
    }

    public function cookiesContentStore(Request $request){
       try{
        $validator = Validator::make(
            $request->all(), [
                'category'=>'required',
                'user_id'=>'required',
                'domain'=>'required',
                'details.*'=>'required'
        ]);


        if($validator->fails())  {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', __($messages->first()));
        }
        if($request->action == 'Save'){
            $module = new CookieDetail();
            $module->category_id = $request->category;
            $module->user_id = $request->user_id??null;
            $module->domain_id = $request->domain??null; 
            $module->details =  json_encode($request->details);
            $resp = $module->save();
        }
        if($request->action == 'Update'){
        //     print_r($request->all());
        // exit;
            $module = CookieDetail::find($request->id);
            $module->category_id = $request->category;
            $module->domain_id = $request->domain??null; 
            $module->user_id = $request->user_id??null;
            $module->details =  json_encode($request->details);
            $resp = $module->save();
        }
        
       
        if ($request->input('action') == 'Create') {
            return redirect()->back()
                ->with('success', __('content created successfully'));
        } else {
            return redirect()->back()
                ->with('success', __('content Updated successfully'));
        }
        }catch(Exception $e){
            return redirect()->back()
            ->with('error', __('Something went wrong, try again'));
        }
    }

    public function getWebCookies($user_id) {
        $user = User::where('id',$user_id)->first();
        $details = !empty($user->extra) ? json_decode($user->extra,true) : [];
        $domain = $details['domain'];
        $cookies = WebCookie::where('domain',$domain)->get();
    }


    public function webcookiedatatable(Request $request){
        try {
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = !empty($columnName_arr[$columnIndex]['data']) ? $columnName_arr[$columnIndex]['data'] : 'created_at'; // Column name
            $columnSortOrder = !empty($order_arr[0]['dir']) ? $order_arr[0]['dir'] : 'desc'; // asc or desc
            $searchValue = $search_arr['value']; // Search value
            $domain = $request->input('domain');

            //total_counter
            $totalRecords = WebCookie::select('count(*) as allcount')->where('domain_id',$domain)->count();

            //filtered counter
            $totalRecordswithFilter = WebCookie::select('count(*) as allcount')->where('domain_id',$domain)->when($searchValue != '', function ($q) use ($searchValue,$domain) {
                $q->where(function($query) use($searchValue,$domain){
                    $query->where('details', 'like', '%' . $searchValue . '%');
                })->where('domain_id',$domain);
                })->count();

            //total records
            $records = WebCookie::orderBy($columnName, $columnSortOrder)->when($searchValue != '', function ($q) use ($searchValue,$domain) {
                $q->where(function($query) use($searchValue,$domain){
                    $query->where('details', 'like', '%' . $searchValue . '%');
                })->where('domain_id',$domain);
                })->where('domain_id',$domain)->skip($start)
                    ->take($rowperpage)
                    ->get();
            
            $data_arr = array();

           

            foreach ($records as $record) {
                $id = $record->id ?? '';
                $type = $record->type ?? '';
                $action = '';

             
                    $action = "<a class='btn btn-primary btn-sm mt-1 me-0 me-lg-2 tooltipss' href='" . route('webcookies', $record->id) . "'><span class='tooltiptext'>".__('View')."</span><i class='flaticon-edit'></i></a>";
                  
                        $action .= "<form action='" . route('deletewebCookie', $record->id) . "' method='POST' accept-charset='UTF-8' style='display:inline' onsubmit='return confirm(&quot;Are you sure?&quot;)'>
                        " . csrf_field() . "
                        " . method_field('DELETE') . "
                        <button type='submit' class='btn btn-danger btn-sm text-white mt-1 tooltipss' data-toggle='tooltip' data-placement='top' title='" . __('Delete') . "'>
                            <i class='flaticon-delete'></i>
                        </button>
                    </form>";
                    
           


                $data_arr[] = array(
                    "id" => $id ?? '',
                    "type" => $type ?? '',
                    "action" => $action
                );
            }


            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr,
            );

            return json_encode($response);
            exit;
        }catch(Exception $e){
            return false; 
        }
    }

    public function webcookies($id){
        $data = WebCookie::findorFail($id);
        return view('addCookiesClient::webCookie',compact('data'));
    }

    public function deletewebCookie($id){
        $resp = WebCookie::destroy($id);
        if($resp){
            return redirect()->back()->with('success',__('Data Deleted successfully'));
        }else{
            return redirect()->back()->with('error',__('Error,try again'));
        }
    }
}
