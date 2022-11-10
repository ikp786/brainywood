<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\State;
use App\StudentClass;
use App\User;
use App\UserSubscription;
use DB;

class UsersController extends Controller
{
	/**
	 * Display a listing of User.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}

		//$users = User::all();
		//$users = User::whereIn("role_id",array(1, 2))->get();
		//$users = User::where("role_id",1)->where("deleted",0)->orderBy("id", "DESC")->get();
		$users = User::where("role_id","!=",2)->where("role_id","!=",3)->where("deleted",0)->orderBy("id", "DESC")->get();

		return view('admin.users.index', compact('users'));
	}
	public function teachers()
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}

		$users = User::where("role_id",2)->where("deleted",0)->orderBy("id", "DESC")->get();

		return view('admin.users.index', compact('users'));
	}
	public function students(Request $request)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}

		//print_r($request->all()); die;
		/*$from = '2021-01-01 00:00:00';
		$to = date('Y-m-d').' 23:59:59';
		$users = array();
		if(!empty($request->created) || !empty($request->school) || !empty($request->class) || !empty($request->city) || !empty($request->subscription) ){
			if($request->created=='today'){
				$from = date('Y-m-d').' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='week'){
				$from = date('Y-m-d', strtotime("this week")).' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='month'){
				$from = date('Y-m-d', strtotime("this month")).' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='year'){
				$from = date('Y-m-d', strtotime("first day of january this year")).' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='before'){
				$from = '2021-01-01 00:00:00';
				$date = strtotime(date('Y').'-12-31 -1 year');
				$to = date('Y-m-d', $date).' 23:59:59';
			}else{
				$users = User::where("role_id",3)->where("deleted",0)->orderBy("id", "DESC")->get();
			}
			if(!empty($request->created) && !empty($request->school) && !empty($request->class) && !empty($request->city) ){
				$users = User::where("role_id",3)->where("deleted",0)->whereBetween("created_at",[$from, $to])->where("school_college",$request->school)->where("class_name",$request->class)->where("city",$request->city)->orderBy("id", "DESC")->get();*/
			if(!empty($request->gender) && !empty($request->school) && !empty($request->class) && !empty($request->state) && !empty($request->city) && !empty($request->from) && !empty($request->to) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("class_name",$request->class)->where("state",$request->state)->where("city",$request->city)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->school) && !empty($request->class) && !empty($request->state) && !empty($request->city) && !empty($request->from) ){
				$to = date('Y-m-d H:i:s');
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("class_name",$request->class)->where("state",$request->state)->where("city",$request->city)->whereBetween("created_at",[$request->from, $to])->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->school) && !empty($request->class) && !empty($request->state) && !empty($request->city) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("class_name",$request->class)->where("state",$request->state)->where("city",$request->city)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->school) && !empty($request->class) && !empty($request->state) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("class_name",$request->class)->where("state",$request->state)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->school) && !empty($request->class) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("class_name",$request->class)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->school) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("school_college",$request->school)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->class) && !empty($request->state) && !empty($request->city) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("class_name",$request->class)->where("state",$request->state)->where("city",$request->city)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->class) && !empty($request->state) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("class_name",$request->class)->where("state",$request->state)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) && !empty($request->class) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("class_name",$request->class)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->gender) ){
				$users = User::where("role_id",3)->where("gender",$request->gender)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->school) && !empty($request->class) ){
				$users = User::where("role_id",3)->where("school_college",$request->school)->where("class_name",$request->class)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->class) && !empty($request->city) ){
				$users = User::where("role_id",3)->where("class_name",$request->class)->where("city",$request->city)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->school) ){
				$users = User::where("role_id",3)->where("school_college",$request->school)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->class) ){
				$users = User::where("role_id",3)->where("class_name",$request->class)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->state) && !empty($request->city) ){
				$users = User::where("role_id",3)->where("state",$request->state)->where("city",$request->city)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->state) ){
				$users = User::where("role_id",3)->where("state",$request->state)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->city) ){
				$users = User::where("role_id",3)->where("city",$request->city)->where("deleted",0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->from) && !empty($request->to) ){
				$users = User::where("role_id",3)->where("deleted",0)->whereBetween('created_at',[$request->from, $request->to.' 23:59:59'])->orderBy("id", "DESC")->get();
			}elseif(!empty($request->from) ){
				$to = date('Y-m-d H:i:s');
				$users = User::where("role_id",3)->whereBetween("created_at",[$request->from, $to])->where("deleted",0)->orderBy("id", "DESC")->get();
			}else{
				$users = User::where("role_id",3)->where("deleted",0)->orderBy("id", "DESC")->get();
			}
		/*} else {
			$users = User::where("role_id",3)->where("deleted",0)->orderBy('id', 'DESC')->get();
		}*/
		$schools = User::select("school_college")->where("school_college","!=","")->groupBy("school_college")->get();
		//$classes = User::select("class_name")->where("class_name","!=","")->groupBy("class_name")->get();
		$classes = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$states = State::orderBy('state', 'ASC')->get();
		//$cities = User::select("city")->where("city","!=","")->groupBy("city")->get();
		$cities = DB::table('cities')->orderBy('city', 'ASC')->get();
		//echo '<pre />'; print_r($schools); die;

		return view('admin.users.index', compact('users','schools','classes','states','cities'));
	}

	/**
	 * Show the form for creating new User.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		return view('admin.users.create', compact('roles'));
	}
	public function studentCreate()
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		$studentClasses = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$states = State::orderBy('state', 'ASC')->get();

		return view('admin.users.create', compact('roles','studentClasses','states'));
	}

	/**
	 * Store a newly created User in storage.
	 *
	 * @param  \App\Http\Requests\StoreUsersRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreUsersRequest $request)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		//$input = $request->all();
		$roles = $request->input('roles') ? $request->input('roles') : [];
		if (isset($roles[0])) {
			//echo $roles[0]; die;
			if ($roles[0]=='Student') {
				$role_id = 3;
			} else {
				$roles = Role::where('name',$roles[0])->first();
				$role_id = $roles->id;
			}
		} else {
			$role_id = 3;
		}
		if ($role_id==3) {
			$user = new User();
			$user->role_id = $role_id;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			$user->dob = date('Y-m-d',strtotime($request->get('dob')));
			$user->gender = $request->gender;
			$user->class_name = $request->class_name;
			$user->school_college = $request->school_college;
			$user->state = $request->state;
			$user->city = $request->city;
			$user->postal_code = $request->postal_code;
			$user->status = 1;
			if (!empty($request->password)) {
				$user->password = bcrypt($request->password);
				$user->userpass = $request->password;
			}
			$user->save();

			\Session::flash('msg', 'Added Successfully.');
			return redirect()->route('admin.students');
		} else {
			$user = User::create($request->all());
			$update = User::where("id",$user->id)->update(array('role_id'=>$role_id,'userpass'=>$request->password));
			$user->assignRole($roles);
		}

		return redirect()->route('admin.users.index');
	}


	/**
	 * Show the form for editing User.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		$user = User::findOrFail($id);

		return view('admin.users.edit', compact('user', 'roles'));
	}
	public function teacherEdit($id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		$user = User::findOrFail($id);

		return view('admin.users.edit', compact('user', 'roles'));
	}
	public function studentEdit($id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		$user = User::findOrFail($id);

		$studentClasses = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$states = State::orderBy('state', 'ASC')->get();

		return view('admin.users.edit', compact('user', 'roles', 'studentClasses', 'states'));
	}

	/**
	 * Update User in storage.
	 *
	 * @param  \App\Http\Requests\UpdateUsersRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateUsersRequest $request, $id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		//echo '<pre />'; print_r($request->all()); die;
		$user = User::findOrFail($id);
		$roles = $request->input('roles') ? $request->input('roles') : [];

		//echo '<pre />'; print_r($roles[0]); die;
		if (isset($roles[0]) && $roles[0]=='Student') {
			$user->name = $request->name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			$user->dob = date('Y-m-d H:i:s',strtotime($request->get('dob')));
			$user->gender = $request->gender;
			$user->class_name = $request->class_name;
			$user->school_college = $request->school_college;
			$user->state = $request->state;
			$user->city = $request->city;
			$user->postal_code = $request->postal_code;
			if (!empty($request->password)) {
				$user->password = bcrypt($request->password);
				$user->userpass = $request->password;
			}
			$user->save();

			\Session::flash('msg', 'Updated Successfully.');
			return redirect()->route('admin.students');
		} else {
			$user->update($request->all());
			$update = User::where("id",$user->id)->update(array('userpass'=>$request->password));
			$roles = $request->input('roles') ? $request->input('roles') : [];
			$user->syncRoles($roles);

			if (isset($roles[0]) && $roles[0]=='Teacher') {
				\Session::flash('msg', 'Updated Successfully.');
				return redirect()->route('admin.teachers');
			} else {
				\Session::flash('msg', 'Updated Successfully.');
				return redirect()->route('admin.users.index');
			}
		}
	}

	/**
	 * Remove User from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$user = User::findOrFail($id);
		$user->deleted=1;
		$user->update();

		//return redirect()->route('admin.users.index');
		return redirect()->back();
	}

	/**
	 * Delete all selected User at once.
	 *
	 * @param Request $request
	 */
	public function massDestroy(Request $request)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		if ($request->input('ids')) {
			$entries = User::whereIn('id', $request->input('ids'))->get();

			foreach ($entries as $entry) {
				//$entry->delete();
			}
		}
	}


	public function show($id)
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}
		$roles = Role::get()->pluck('name', 'name');

		$user = User::findOrFail($id);

		return view('admin.users.view', compact('user', 'roles'));
	}

	public function updateStatus($id,$status)
	{
		$user = User::findOrFail($id);
		$user->status=$status;
		$user->update();

		return redirect()->back();
	}

	public function deletedUsers()
	{
		if (! Gate::allows('users_manage')) {
			return abort(401);
		}

		$users = User::where("deleted",1)->get();

		return view('admin.users.deleted', compact('users'));
	}

	public function restoreUsers($id)
	{
		$user = User::findOrFail($id);
		$user->deleted=0;
		$user->update();

		\Session::flash('msg', 'User Re-stored Successfully.');
		return redirect()->back();
	}

	public function getCitiesByStateName(Request $request)
	{
		$state = $request->state;
		$stateData = State::where('state', $state)->first();
		$stateId = $stateData->id;
		$cities = DB::table('cities')->where('state_id', $stateId)->orderBy('city', 'ASC')->get();
		$output = '<option>Select City</option>';
		foreach ($cities as $key => $value) {
			$output .= '<option value="'.$value->city.'">'.$value->city.'</option>';
		}
		echo $output;
	}

}
