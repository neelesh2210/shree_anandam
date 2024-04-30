<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{

    public function index(){
        $user_detail = UserDetail::where('user_id',Auth::user()->id)->first();

        if($user_detail && $user_detail->id_proof_type == 'aadhar'){
            $aadhar_front = asset('backend/assets/image/documents/'.$user_detail->id_proof[0]);
            $aadhar_back = asset('backend/assets/image/documents/'.$user_detail->id_proof[1]);

            return response()->json(['id_proof_type'=>$user_detail?$user_detail->id_proof_type:null,'aadhar_front'=>$aadhar_front,'aadhar_back'=>$aadhar_back,'message'=>'Documnet Retrived Successfully!','status'=>200],200);
        }elseif($user_detail && $user_detail->id_proof_type == 'pan'){
            $pan = asset('backend/assets/image/documents/'.$user_detail->id_proof[0]);

            return response()->json(['id_proof_type'=>$user_detail?$user_detail->id_proof_type:null,'pan'=>$pan,'message'=>'Documnet Retrived Successfully!','status'=>200],200);
        }else{
            return response()->json(['id_proof_type'=>$user_detail?$user_detail->id_proof_type:null,'message'=>'Documnet Retrived Successfully!','status'=>200],200);
        }
    }

    public function store(Request $request){
        $request->validate([
            'id_proof_type'=>'required|in:aadhar,pan',
        ]);

        $user_detail = UserDetail::where('user_id',Auth::user()->id)->first();

        if(!$user_detail){
            $user_detail = new UserDetail;
            $user_detail->user_id = Auth::user()->id;
        }

        $id_proof = [];

        if($request->id_proof_type === 'aadhar'){
            if($user_detail->id_proof_type === 'aadhar'){
                if($request->has('aadhar_front_image')){
                    $request->validate([
                        'aadhar_front_image'=>'nullable|mimes:png,jpg,jpeg,webp',
                    ]);
                    $id_proof[] = imageUpload($request->file('aadhar_front_image'),'backend/assets/image/documents/');
                }else{
                    $id_proof[] = $user_detail->id_proof[0];
                }

                if($request->has('aadhar_back_image')){
                    $request->validate([
                        'aadhar_back_image'=>'nullable|mimes:png,jpg,jpeg,webp',
                    ]);
                    $id_proof[] = imageUpload($request->file('aadhar_back_image'),'backend/assets/image/documents/');
                }else{
                    $id_proof[] = $user_detail->id_proof[1];
                }
            }else{
                $request->validate([
                    'aadhar_front_image'=>'required|mimes:png,jpg,jpeg,webp',
                    'aadhar_back_image'=>'required|mimes:png,jpg,jpeg,webp',
                ]);
                $id_proof[] = imageUpload($request->file('aadhar_front_image'),'backend/assets/image/documents/');
                $id_proof[] = imageUpload($request->file('aadhar_back_image'),'backend/assets/image/documents/');
            }
        }elseif($request->id_proof_type === 'pan'){
            if($user_detail->id_proof_type === 'aadhar'){
                $request->validate([
                    'pan_image'=>'required|mimes:png,jpg,jpeg,webp',
                ]);

                $id_proof[] = imageUpload($request->file('pan_image'),'backend/assets/image/documents/');
            }else{
                $request->validate([
                    'pan_image'=>'nullable|mimes:png,jpg,jpeg,webp',
                ]);
                if($request->has('pan_image')){
                    $id_proof[] = imageUpload($request->file('pan_image'),'backend/assets/image/documents/');
                }else{
                    $id_proof[] = $user_detail->id_proof;
                }
            }
        }

        $user_detail->id_proof_type = $request->id_proof_type;
        $user_detail->id_proof = $id_proof;
        $user_detail->save();

        return $this->index();
    }

}
