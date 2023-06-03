<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\intern;
use App\internship;
use App\Student;
use App\departmentHeader;
use App\User;
use App\company;
use App\internshipManager;
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function generatePDF(Request $request)
    {
        $intern = intern::find($request->id);
        $data = [
            'title' => 'Welcome to ',
            'firstname' =>  $intern->internship->manager->user->first_name,
            'familyname' =>  $intern->internship->manager->user->family_name,
            'fststudent' =>  $intern->student->user->first_name,
            'fmstudent' =>  $intern->student->user->family_name,
            'theme' =>  $intern->internship->title,
            'birthday'=>  $intern->student->birthday,
            'birth_place'=>  $intern->student->birth_place,
            'speciality'=>  $intern->student->speciality,
            'company_name'=>  $intern->internship->manager->company->name,
            'start_date'=>  $intern->start_date,
            'end_date'=>  $intern->end_date,
            'company_adresse'=>  $intern->internship->manager->company->address,
            'date' => date('m/d/Y'),
        ];

        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('laraveltuts.pdf');

    }
}
