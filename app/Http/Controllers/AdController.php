<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    // Display the latest ads on the jibonjoyi_details page
    public function showAds()
    {
        $ad = Ad::orderBy('created_at', 'desc')->first();  // Fetch the latest ad
        return view('jibonjoyi_details', compact('ad'));   // Pass 'ad' to the view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vertical_ad1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vertical_ad2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'horizontal_ad' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ad = new Ad();

        // Handle vertical_ad1 upload to public/storage/banners
        if ($request->hasFile('vertical_ad1')) {
            $verticalAd1Path = $request->file('vertical_ad1')->storeAs(
                'banners',
                $request->file('vertical_ad1')->getClientOriginalName(),
                'public'
            );
            $ad->vertical_ad1 = $verticalAd1Path;  // Save relative path like 'banners/image-name.png'
        }

        // Handle vertical_ad2 upload
        if ($request->hasFile('vertical_ad2')) {
            $verticalAd2Path = $request->file('vertical_ad2')->storeAs(
                'banners',
                $request->file('vertical_ad2')->getClientOriginalName(),
                'public'
            );
            $ad->vertical_ad2 = $verticalAd2Path;
        }

        // Handle horizontal_ad upload
        if ($request->hasFile('horizontal_ad')) {
            $horizontalAdPath = $request->file('horizontal_ad')->storeAs(
                'banners',
                $request->file('horizontal_ad')->getClientOriginalName(),
                'public'
            );
            $ad->horizontal_ad = $horizontalAdPath;
        }

        $ad->save();

        return redirect()->route('ads.upload')->with('success', 'Ads uploaded successfully!');
    }
    // Display the ad upload form
    public function uploadForm()
    {
        return view('upload_ads');  // Ensure this matches your Blade file name: resources/views/upload_ads.blade.php
    }



}
