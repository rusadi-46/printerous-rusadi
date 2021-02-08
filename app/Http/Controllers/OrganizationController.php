<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Organization;
use Illuminate\Support\Str;
use App\Models\User;

class OrganizationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = 'Organization';
        $this->submenu = '';
        $this->breadcrumbs = [
            ['url' => route('organization.index'), 'title' => 'Organization'],
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

        return view('organization.index', [
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
        $this->breadcrumbs = [
            ['url' => route('organization.create'), 'title' => 'Add Organization'],
        ];

        return view('organization.add', [ 
            'page' => $this,
            'user' => User::where('is_admin', false)->get()
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
            "user_id" => "bail|required|exists:App\Models\User,id",
            'name' => 'bail|required|string',
            'phone' => 'bail|required',
            'email' => 'bail|required',
            'website' => 'bail|required',
            'logo' => 'bail|sometimes|required|mimes:jpg,jpeg,png',
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
            $data = Organization::create($request->all());
            if ($request->hasFile('logo')) {
                $file_logo = $request->file('logo');
                $file_name_logo = $request->name. '-' . uniqid() . '.' . $file_logo->getClientOriginalExtension();
                Storage::disk('uploads')->putFileAs('', $file_logo, $file_name_logo
                    );
                $data->logo = $file_name_logo;
                $data->save();
            }

            DB::commit();
            return redirect()->route('organization.index')->with('message', 'Organization saved successfully');

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
    public function edit(Organization $organization)
    {
        $this->breadcrumbs = [
            ['url' => route('organization.edit', [$organization->id]), 'title' => 'Edit Organization'],
        ];

        return view('organization.edit', [
            'data' => $organization, 
            'page' => $this,
            'user' => User::where('is_admin', false)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            $organization->update($request->all());
            if ($request->hasFile('logo')) {
                $file_logo = $request->file('logo');
                $file_name_logo = $request->name. '-' . uniqid() . '.' . $file_logo->getClientOriginalExtension();
                Storage::disk('uploads')->putFileAs('', $file_logo, $file_name_logo
                    );
                $data->logo = $file_name_logo;
                $data->save();
            }

            DB::commit();
            return redirect()->route('organization.index')->with('message', 'Organization update successfully');

        } catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('message', $e->getMessage())->with('state', 'error')->withInput();
        }//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        DB::beginTransaction();
        try {
            $organization->delete();
            DB::commit();
            return redirect()->route('organization.index')->with('message', 'Organization deleted successfully');
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

        if (\Auth::user()->is_admin == true) {
            $query = Organization::query();
        } else {
            if (\Auth::user()->doesntHave('organization')) {
                $query = Organization::query();
            } else {
                $query = Organization::where('user_id', \Auth::user()->id);
            }
        }

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
