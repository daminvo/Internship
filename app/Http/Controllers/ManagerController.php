<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\InternshipOffer;
use Carbon\Carbon;



class ManagerController extends Controller
{
    public function acceptRequest(Request $request ){
        $intern = intern::where([
            ["id", $request->internId],
            ['internship_id', $request->internshipId]
        ])->first();
        $intern->update(["manager_validation" => 1]);
        return response()->json([
            'msg' => 'information updated successfully',
        ]);

    }

    public function refuseRequest(Request $request ){
        $intern = intern::where([
            ["id", $request->internId],
            ['internship_id', $request->internshipId]
        ])->first();
        $intern->update(["manager_validation" => 0]);
        return response()->json([
            'msg' => 'information updated successfully',
        ]);

    }

    public function getInternshipIterns(Request $request){
       $internship = internship::find($request ->id);
       $intern = $internship->intern;
       return $intern;
    }

    public function createOffer(Request $request){
        $internship = internship::create(['duration'=>$request->duration,'description'=>$request->description,'demand_date'=>Carbon::today()->toDateString(),'manager_id'=>$request->managerId,'title'=>$request->title, 'state' => 'available']);
        $InternshipOffer = InternshipOffer::create(['nmbr_positions'=>$request->nmbrPositions,'photo'=>$request->photo,'internship_id'=>$internship->getKey()]);
        return response()->json([
            'msg' => 'information created successfully',
        ]);
    }

    public function evaluateIntern(Request $request){

    }

}
