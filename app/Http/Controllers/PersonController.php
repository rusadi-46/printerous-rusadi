<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Person;
use App\Models\Organization;
use Illuminate\Support\Str;

class PersonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = 'Organization';
        $this->submenu = 'Person';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Organization $organization)
    {
        $this->breadcrumbs = [
            ['url' => route('organization.index'), 'title' => 'Organization'],
            ['url' => route('organization.person.index', [$organization->id]), 'title' => 'Person'],
        ];
        $table = $this->getTableData($request, $organization);

        \Log::info($table);
        return view('person.index', [
            'page' => $this, 
            'table' => $table,
            'organization' => $organization
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Organization $organization)
    {
        $this->breadcrumbs = [
            ['url' => route('organization.index'), 'title' => 'Organization'],
            ['url' => route('organization.person.create', [$organization->id]), 'title' => 'Add Person'],
        ];

        return view('person.add', [
            'page' => $this, 
            'organization' => $organization
        ]);
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validateFormRequest($request)
    {
        return Validator::make($request->all(), [
            'name' => 'bail|required|string',
            'email' => 'bail|required',
            'phone' => 'bail|required',
            'avatar' => 'bail|required|mimes:jpg,jpeg,png',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Organization $organization)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            $data = $organization->person()->create($request->all());
            if ($request->hasFile('avatar')) {
                $file_avatar = $request->file('avatar');
                $file_name_avatar = $request->name. '-' . uniqid() . '.' . $file_avatar->getClientOriginalExtension();
                Storage::disk('uploads')->putFileAs('', $file_avatar, $file_name_avatar
                    );
                $data->avatar = $file_name_avatar;
                $data->save();
            }

            DB::commit();
            return redirect()->route('organization.person.index', [$organization->id])->with('message', 'Person saved successfully');

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
    public function edit(Organization $organization, Person $person)
    {
        $this->breadcrumbs = [
            ['url' => route('organization.index'), 'title' => 'Organization'],
            ['url' => route('organization.person.edit', [$organization->id, $person->id]), 'title' => 'Edit Person'],
        ];
        return view('person.edit', [
            'page' => $this,
            'data' => $person,
            'organization' => $organization
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization, Person $person)
    {
        $validator = $this->validateFormRequest($request);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            $data = $person->update($request->all());
            if ($request->hasFile('avatar')) {
                $file_avatar = $request->file('avatar');
                $file_name_avatar = $request->name. '-' . uniqid() . '.' . $file_avatar->getClientOriginalExtension();
                Storage::disk('uploads')->putFileAs('', $file_avatar, $file_name_avatar
                    );
                $data->avatar = $file_name_avatar;
                $data->save();
            }

            DB::commit();
            return redirect()->route('person.index')->with('message', 'Person update successfully');

        } catch (\Exception $e){
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
    public function destroy(Organization $organization, Person $person)
    {
        DB::beginTransaction();
        try {
            $person->delete();
            DB::commit();
            return redirect()->route('person.index')->with('message', 'Person deleted successfully');
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
    public function getTableData($request, $organization)
    {
        $paginate = $request->has('paginate') && $request->input('paginate') ? $request->input('paginate') : 10;

        $query = Person::where('organization_id', $organization->id);

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
