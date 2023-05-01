<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function createRequest(){
        //$student_request=student::where ($request->student_id,"id")->;
        if($request->companayId != ""   ){
            $companies['name'] = $request->name;
            $companies['addresse'] = $request->addresse;
            $companies = companies::create($companies);
        if($request->managerId != "")



            $users['first_name'] = $request->firstName;
            $users['family_name'] = $request->familyName;
            $users['email'] = $request->email;
            $users['pass'] = $request->firstName;
        }

        internships::insert(['duration'=>$request->duration,'motivation' => $request->motivation,'description' => $request->description,'state'=>$request->state,'start_date'=>$request->startDate,'end_date'=>$request->endDate,'demand_date'=>$request->demandDate,'start_date'=>$request->startDate,'student_id'=>$request->studentId]);
     return response()->json([
    'msg' => 'information inserted successfuly',
        ]);

    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
