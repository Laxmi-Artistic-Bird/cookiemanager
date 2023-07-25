<?php

namespace Artisticbird\Cookies\Http\Controllers\Apis;
use App\Http\Controllers\Controller;
use App\Models\User;
use Artisticbird\Cookies\Models\CookieDetail;
use Artisticbird\Cookies\Models\UserDetail;
use Artisticbird\Cookies\Models\WebCookie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebCookieController extends Controller
{
    public function index(Request $request){
        try{
            $apikey = $request->header('authorization');
            $keyData = explode('Bearer ',$apikey);
            if(array_key_exists('1',$keyData)){
                $user = UserDetail::where('company_key',$keyData[1])->first();
                if($user){
                    if(!empty($request->query('domain'))){
                        if($userdomain = UserDetail::select('id')->where('domain',$request->query('domain'))->first()){
                            $contents = CookieDetail::select('details')->where('domain_id',$userdomain->id)->where('category_id',$request->category_id)->get()->toArray();
                            return response()->json(['data'=>$contents],200);
                        }else{
                            return response()->json(['message'=>__('Invalid Domain')],401);
                        }
                    }else{
                        return response()->json(['message'=>__('Invalid Domain')],401);
                    }
                  
                }else{
                    return response()->json(['message'=>__('Invalid Key')],401);
                }
            }
            else{
                return response()->json(['message'=>('Unauthorized access')],401);
            }
        }catch(Exception $e){
            Log::info($e->getMessage());
            return response()->json(['message'=>('Something went wrong')],500);
        }
    }

    public function store(Request $request){
        try{
            $apikey = $request->header('authorization');
            $keyData = explode('Bearer ',$apikey);
            if(array_key_exists('1',$keyData)){
                $user = UserDetail::where('company_key',$keyData[1])->first();
                if($user){
                    if(!empty($request->domain)){
                        if($userdomain = UserDetail::select('user_id','id')->where('domain',$request->domain)->first()){
                            $input = $request->all();
                            $data = new WebCookie;
                            $data->domain_id = $userdomain->id;
                            $data->user_id = $userdomain->user_id;
                            $data->type = $request->type;
                            unset($input['type']);
                            unset($input['domain']);
                            $data->details = json_encode($input);
                            $resp = $data->save();
                           if($resp){
                                return response()->json(['message'=>__('Data has been successfully submitted')],200);
                           }else{
                                return response()->json(['message'=>__('Error in insetion')],500);
                           }
                        }else{
                            return response()->json(['message'=>__('Invalid Domain')],401);
                        }
                    }else{
                        return response()->json(['message'=>__('Invalid Domain')],401);
                    }                   
                }else{
                    return response()->json(['message'=>__('Invalid key')],401);
                }
            }
            else{
                return response()->json(['message'=>('Unauthorized access')],401);
            }
        }catch(Exception $e){
            Log::info($e->getMessage());
            return response()->json(['message'=>('Something went wrong')],500);
        }
        
    }
}
