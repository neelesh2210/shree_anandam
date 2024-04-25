<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request){
        $search_start_date = $request->search_start_date;
        $search_end_date = $request->search_end_date;
        $search_block_status = $request->search_block_status;
        $search_verify_status = $request->search_verify_status;
        $search_key = $request->search_key;

        $users = User::latest();

        if($search_start_date){
            $d1=strtotime($search_start_date);
            $d2=strtotime($search_end_date);
            $da1=date('Y-m-d',$d1);
            $da2=date('Y-m-d',$d2);
            $startDate = Carbon::createFromFormat('Y-m-d', $da1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $da2)->endOfDay();

            $users = $users->whereBetween('created_at', [$startDate, $endDate]);
        }

        $users = $users->when($search_block_status, function ($q) use ($search_block_status){
            return $q->where('is_block',$search_block_status);
        })->when($search_verify_status, function ($q) use ($search_verify_status){
            return $q->where('is_verify',$search_verify_status);
        })->when($search_key, function ($q) use ($search_key){
            return $q->where(function($query) use ($search_key){
                $query->where('name','LIKE','%'.$search_key.'%')->orWhere('phone_number',$search_key)->orWhere('referral_code',$search_key);
            });
        })->paginate(10);

        if($request->ajax()){
            return view('admin.user.table',compact('users','search_start_date','search_end_date','search_block_status','search_verify_status','search_key'));
        }

        return view('admin.user.index',compact('users','search_start_date','search_end_date','search_block_status','search_verify_status','search_key'),['page_title'=>'User List']);
    }

    public function create(){
        return view('admin.user.create',['page_title'=>'Add User']);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:30',
            'phone_number'=>'required|integer|digits:10|unique:users,phone_number',
            'address'=>'required',
            'password'=>'required|min:8',
            'referrer_code'=>'nullable|exists:users,referral_code'
        ]);

        $latest_user = User::oldest('id')->first();
        if($latest_user){
            $least_child_user = User::where('number_of_child','<',5)->oldest('id')->first();
            $parent_id = $least_child_user->id;
            if(!$request->referrer_code){
                $referrer_code = $latest_user->referral_code;
            }else{
                $referrer_code = $request->referrer_code;
            }
        }else{
            $parent_id = null;
            $referrer_code = $request->referrer_code;
        }

        $user = new User;
        $user->parent_id = $parent_id;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->referral_code = mt_rand(11111111,99999999);
        $user->referrer_code = $referrer_code;
        $user->save();

        if(isset($least_child_user)){
            $least_child_user->number_of_child = $least_child_user->number_of_child + 1;
            $least_child_user->save();
        }

        return redirect()->route('admin.users.index')->with('success','User Added Successfully!');
    }

    public function edit(User $user){
        return view('admin.user.edit',compact('user'),['page_title'=>'Edit User']);
    }

    public function update(Request $request,User $user){
        $request->validate([
            'name'=>'required|max:30',
            'phone_number'=>'required|integer|digits:10|unique:users,phone_number,'.$user->id.',id',
            'address'=>'required',
        ]);

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->save();

        return redirect()->route('admin.users.index')->with('success','User Added Successfully!');
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8'
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message'=>'Password Updated Successfully!']);
    }

    public function userDocumnetDetail($id){
        $user = User::where('id',$id)->with('userDetail')->first();

        return view('admin.user.document_detail',compact('user'),['page_title'=>'Document Detail']);
    }

    public function userDocumnetDetailUpdate(Request $request,$id){
        $request->validate([
            'id_proof_type'=>'nullable|in:aadhar,pan',
            'photo'=>'nullable|mimes:png,jpg,jpeg,webp',
        ]);

        $user_detail = UserDetail::where('user_id',$id)->first();

        if(!$user_detail){
            $user_detail = new UserDetail;
            $user_detail->user_id = $id;
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

        if($request->has('photo')){
            $user_detail->photo = imageUpload($request->file('photo'),'backend/assets/image/documents/');
        }

        $user_detail->save();

        return redirect()->route('admin.users.index')->with('success','Documnet Updated Successfully!');
    }

    public function userBlock($id,$status){
        $user = User::find($id);
        $user->is_block = $status;
        $user->save();

        if($status == '1'){
            return redirect()->back()->with('error','User Blocked Successfully!');
        }else{
            return redirect()->back()->with('success','User Unblocked Successfully!');
        }
    }

    public function userVerify($id,$status){
        $user = User::find($id);
        $user->is_verify = $status;
        $user->save();

        if($status == '1'){
            return redirect()->back()->with('success','User Verified Successfully!');
        }else{
            return redirect()->back()->with('error','User Not Verified Successfully!');
        }
    }

}
