<?php

namespace App\Http\Controllers;

use App\InternshipOffer;
use Illuminate\Http\Request;

class InternshipOfferController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        $offer = InternshipOffer::with(['internship.manager.user'])
            // ->where('internships.title', 'like', "%{$query}%")s
            ->whereHas('internship', function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%");
            })
            ->simplePaginate(9);

        return response()->json($offer);
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
     * @param  \App\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function show(InternshipOffer $internshipOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(InternshipOffer $internshipOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InternshipOffer $internshipOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InternshipOffer  $internshipOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(InternshipOffer $internshipOffer)
    {
        //
    }
}
