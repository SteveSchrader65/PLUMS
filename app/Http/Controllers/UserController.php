<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RequestUserValidation;
use App\Models\UserProfile;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of user records in the application.
     *
     * @return Response
     */
    public function index(): Response
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create(): Response
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created user in the database
     *
     * @param RequestUserValidation $request
     * @return Response
     */
    public function store(RequestUserValidation $request): Response
    {
        $this->validate($request, [
//            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display data on a user record in the application
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified User record
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        $user = User::find()->id;
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update attributes of the specified user record in the database
     *
     * @param RequestUserValidation $request
     * @param User $user
     * @return Response
     */
    public function update(RequestUserValidation $request, User $user): Response
    {
        $this->validate($request, [
//            'name' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find()->id;
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Search for user where search-term matches name parameters
     *
     * @param $search_term
     * @return Response
     */
    public function search($search_term): Response
    {
        //
    }

    /**
     * Mark a user record for deletion from storage (soft delete)
     *
     * @param User $user
     * @return Response
     */
    public function delete(User $user): Response
    {
        //
    }

    /** Delete specified user record from database (hard delete)
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        User::find()->id->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
