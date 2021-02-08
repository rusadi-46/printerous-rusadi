<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;


class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = 'Users';
        $this->submenu = 'Users';
        $this->breadcrumbs = [
            ['url' => route('user.index'), 'title' => 'User'],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $table = $this->getTableData($request);

        return view('user.index', [
            'page' => $this, 
            'table' => $table
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->breadcrumbs[] = ['url' => route('user.create'), 'title' => 'Add New'];
        return view('user.add', [
            'page' => $this
        ]);
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request, $id = null)
    {
        return Validator::make($request->all(), [
            "name" => "bail|required|string|max:255",
            "is_admin" => "bail|required",
            "email" => "bail|sometimes|required|email|max:255|unique:App\Models\User,email,$id,id,deleted_at,NULL",
            "password" => "bail|sometimes|required|string|min:8|max:255|confirmed"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validateFormRequest($request);
        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            $request->merge(['is_admin' => ($request->is_admin == "1") ? true : false]);
            $data = User::create($request->all());

            DB::commit();
            return redirect()->route('user.index')->with('message', 'User saved successfully');

        } catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('message', $e->getMessage())->with('state', 'error')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->breadcrumbs[] = ['url' => route('user.edit', [$user->id]), 'title' => 'Edit'];
        return view('user.edit', [
            'page' => $this,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = $this->validateFormRequest($request, $user->id);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $user->update($request->all());

            DB::commit();
            return redirect()->route('user.index')->with('message','User update successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('message', $e->getMessage())->with('state', 'error')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return redirect()->route('user.index')->with('message', 'User deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('message', $e->getMessage())->with('state', 'error')->withInput();
        }
    }

    /**
     *
     * Handle get data for table
     *
     */
    public function getTableData($request)
    {
        $paginate = $request->has('paginate') && $request->input('paginate') ? $request->input('paginate') : 10;

        $query = User::query();

        $collection = $query->get();
        
        if ($request->has('generalSearch') && $request->input('generalSearch')) {
            $generalSearch = $request->input('generalSearch');
            $collection = $collection->filter(function ($value, $key) use ($generalSearch) {
                return stripos($value, $generalSearch) !== false;
            });

            $collection = collect(array_values($collection->toArray()));
        }

        return $collection->paginate($paginate);
    }
}
