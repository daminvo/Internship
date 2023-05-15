<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use App\InternshipOffer;

class FavoriteController extends Controller
{

    public function addToFavorite(Request $request, InternshipOffer $offer)
    {
        $user_id = $request->user()->student()->pluck('id');

        Favorite::updateOrCreate([
            'offer_id' => $offer->id,
            'student_id' => $user_id[0],
        ], ['status' => $request->post('status')]);

        $favorites = Favorite::with('student.user:first_name,family_name,email')->where('student_id', $user_id[0])->where('status', true)->get();

        if ($request->post('status') === true) {
            return response()->json([
                'message' => 'Project has been added to your Favorites',
                'favorites' => $favorites,
            ]);
        }

        return response()->json([
            'message' => 'Project has been removed from your Favorites',
            'favorites' => $favorites,
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
