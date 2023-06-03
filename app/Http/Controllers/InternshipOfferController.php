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


    public function uploadTempThumbnail(Request $request)
    {
        $userAuth = $request->user();

        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:516',
        ]);

        if ($userAuth->role === 'manager' && $request->hasFile('file')) {

            $image = $request->file('file');
            $extension = $image->extension();
            $imgName = $this->generateRandomString(25) . '.' . $extension;
            $destinationPath = storage_path('app/public/images/thumbnail/');
            $image->move($destinationPath, $imgName);

            return response()->json([
                'message' => 'Project Thumbnail has been uploaded',
                'thumbnail' => "{$imgName}",
            ]);
        }
    }

    public function deleteTempThumbnail(Request $request)
    {
        $userAuth = $request->user();

        if ($request->exists('file')) {
            $path = storage_path() . '/app/public/images/thumbnail/' . $request->file;
            if (file_exists($path)) unlink($path);

        }

        return response()->json([
            'message' => 'Project Thumbnail has been deleted',
        ]);
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
