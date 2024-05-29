<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $users = User::role('Super Admin')->where('id','!=',1)->get();
        return view('backend.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required'],
        ]);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('admin.users.index')
            ->with('status', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $wishlists = $user->wishlists;
        $orders = $user->customer_orders;
        $saved_addresses = $user->customer_addresses;
        $payment_method = Order::payment_method();
        return view('backend.users.customer-details', compact('user', 'wishlists', 'orders', 'saved_addresses', 'payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $userRole = $user->roles->pluck('id', 'id')->all();
        $roles = Role::all();
        return view('backend.users.edit', compact('user', 'userRole', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roles' => ['required'],
        ]);

        if ($request->password) {
            $input['password'] = Hash::make($input['password']);
        }
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')
            ->with('status', 'User Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user() == $user) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Current User Can not be Deleted.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('status', 'User Deleted successfully');
    }

    public function customers()
    {
        $roles = Role::all();
        $customers = User::role('customer')->orderBy('created_at','desc')->get();
        return view('backend.users.customers', compact('customers', 'roles'));
    }
}
