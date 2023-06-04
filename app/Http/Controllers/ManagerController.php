<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\intern;
use App\internship;
use App\InternshipOffer;
use App\Rating;
use App\presence;
use Carbon\Carbon;



class ManagerController extends Controller
{
    public function acceptRequest(Request $request ){
        $intern = intern::where([
            ["id", $request->internId],
        ])->first();
        $intern->update(["manager_validation" => 1]);
        return response()->json([
            'msg' => 'information updated successfully',
        ]);

    }

    public function refuseRequest(Request $request ){
        $intern = intern::where([
            ["id", $request->internId]
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
        $rating = rating::create(['work_ability'=>$request->work_ability,'discipline'=>$request->discipline,'initiative'=>$request->initiative,'capacity_imagination'=>$request->capacity_imagination, 'acquired_knowledge' => $request->acquired_knowledge, 'appreciation' => $request->appreciation, 'total_note' =>($request->work_ability + $request->discipline + $request->initiative + $request->capacity_imagination + $request->acquired_knowledge),'intern_id'=> $request->internId]);
        return response()->json([
            'msg' => 'information created successfully',
        ]);
    }

        public function internPresence(Request $request){
         $presence = presence::create(['entry_time'=>$request->entry_time,'exit_time'=>$request->exit_time,'observation'=>$request->observation,'date'=>$request->date,'intern _id'=>$request->internId]);
         return response()->json([
            'msg' => 'information created successfully',
        ]);
        }

        public function showManagerRequests(Request $request)
        {
            $interns = intern::where([
                ['manager_validation', null],
                ['header_validation', 1]
            ])
            ->whereHas('internship', function ($query) use ($request) {
                $query->where('manager_id', $request->managerId);
            })->with([
                "student.user",
                "student.intern.internship",
                "student.department.faculty.university"
            ])
            ->get();

            return $interns;
        }


}
