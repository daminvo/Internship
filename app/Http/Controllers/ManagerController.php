<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;

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
}
