<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RegisterController extends Controller
{
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
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
            $request->merge(['is_admin' => true]);
            $data = User::create($request->all());

            DB::commit();
            return redirect()->route('user.index')->with('message', 'User saved successfully');

        } catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with('message', $e->getMessage())->with('state', 'error')->withInput();
        }
    }
}
