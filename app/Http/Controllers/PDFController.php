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
use App\InternshipManager;
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
            'firstname' =>  $intern->internsip->manager->user->firstname,
            'familyname' =>  $intern->internsip->manager->user->familyname,
            'fstname' =>  $intern->student->user->firstname,
            'fmname' =>  $intern->student->user->familyname,
            'theme' =>  $intern->internship->title,
            'birthday'=>  $intern->student->birthday,
            'birthday_place'=>  $intern->student->birth_place,
            'speciality'=>  $intern->student->speciality,
            'company_name'=>  $intern->internsip->manager->company->name,
            'company_address'=>  $intern->internsip->manager->company->address,
            'date' => date('m/d/Y'),
        ];

        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('laraveltuts.pdf');
    }
}
