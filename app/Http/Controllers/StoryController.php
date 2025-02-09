<?php

namespace App\Http\Controllers;

use App\Models\AjkerBani;
use App\Models\Story;
use App\Models\Footer;
use App\Models\Ad;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as st;
use Storage;

class StoryController extends Controller
{
    public function edit($id)
    {
        $story = Story::findOrFail($id); // Fetch the story by ID
        return view('stories.edit', compact('story')); // Pass the story to the view
    }

    // Handle the update of the story
    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id); // Find the story by ID

        // Validate the incoming data
        $validated = $request->validate([
            'story_title' => 'required|string|max:255',
            'story_writer' => 'required|string|max:255',
            'story_date' => 'required|date',
            'story_description' => 'required|string',
            'story_category' => 'required|string|max:255', // Make sure this is required
            'story_rating' => 'required|numeric|min:0|max:5', // Rating should be numeric and within the range
            'story_details' => 'required|string', // Ensure story details is required
            'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update the story data
        $story->update($validated);

        // Handle the file uploads if any
        if ($request->file('banner')) {
            // Delete the old banner image before uploading the new one
            if ($story->banner) {
                st::delete('public/' . $story->banner);
            }
            $story->banner = $request->file('banner')->store('banners', 'public');
        }

        if ($request->file('img')) {
            // Delete the old img before uploading the new one
            if ($story->img) {
                st::delete('public/' . $story->img);
            }
            $story->img = $request->file('img')->store('images', 'public');
        }

        $story->save(); // Save the story

        // Redirect with a success message
        return redirect()->route('stories.searchForm')->with('success', 'Story updated successfully!');
    }

    //delete
    public function destroy($id)
    {
        $story = Story::findOrFail($id); // Find the story by ID

        // Delete associated images if they exist
        if ($story->banner) {
            st::delete('public/' . $story->banner);
        }
        if ($story->img) {
            st::delete('public/' . $story->img);
        }

        // Delete the story from the database
        $story->delete();

        // Redirect back to the search results with a success message
        return redirect()->route('stories.searchForm')->with('success', 'Story deleted successfully!');
    }


    //search
    public function searchForm(Request $request)
    {
        // Validate search input
        $request->validate([
            'story_title' => 'nullable|string|max:255', // Title is optional
        ]);

        // Fetch stories based on search title
        $stories = Story::query();

        if ($request->filled('story_title')) {
            $stories = $stories->where('story_title', 'like', '%' . $request->story_title . '%');
        }

        $stories = $stories->paginate(8);

        return view('stories.search', compact('stories')); // Pass results to the view
    }




    public function create()
    {
        return view('stories.create'); // Render form view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'story_title' => 'required|string|max:255',
            'story_writer' => 'required|string|max:255',
            'story_date' => 'required|date',
            'story_description' => 'required|string',
            'story_category' => 'required|string|max:255',
            'story_category1' => 'required|string|max:255',
            'story_details' => 'required|string',
            'banner' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $story = new Story($validated);

        // Handle banner upload to public/storage/banners
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->storeAs('banners', $request->file('banner')->getClientOriginalName(), 'public');
            $story->banner = $bannerPath; // Save the relative path like 'banners/image-name.png'
        }

        $story->save();

        return redirect()->route('stories.create')->with('success', 'Story added successfully!');
    }


    public function incrementClickCount($storyId)
    {
        // Find the story by ID
        $story = Story::findOrFail($storyId);

        // Increment the click count by 1
        $story->increment('click_count');

        // Redirect to the story's details page
        return redirect()->route('jibonjoyi_details', ['id' => $storyId]);
    }

    public function showDetails($id)
    {
        // Fetch the story by ID
        $story = Story::findOrFail($id);

        // Fetch the latest ad
        $ad = Ad::orderBy('created_at', 'desc')->first();

        // Return the view and pass both story and ad data to it
        return view('jibonjoyi_details', compact('story', 'ad'));
    }
    public function showLiberationStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('liberation', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }
    public function showHistoryStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'ইতিহাস') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('history', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }


    public function showTravelStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();
        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'ভ্রমণ') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('travel', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showWorldStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'বিশ্ব') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('world', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showEconomyStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();
        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'অর্থনীতি') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('economy', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'ad',
            'literatureStories'
        ));
    }

    public function showPhilosophyStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'দর্শন') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('philosophy', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showReligionStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();
        $ad = Ad::orderBy('created_at', 'desc')->first();

        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'ধর্ম') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('religion', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showSportsStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'খেলাধুলা') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('sports', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showScienceStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();


        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'বিজ্ঞান') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('science', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showPoliticsStories(Request $request)
    {
        // Fetch the last 6 stories across all categories

        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();


        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'রাজনীতি') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('politics', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showLiteratureStories(Request $request)
    {
        // Fetch the last 6 stories across all categories
        $ad = Ad::orderBy('created_at', 'desc')->first();
        $bani = AjkerBani::latest()->first();
        $footer_index = Footer::all();
        $mostReadStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'writer_img',
            'story_category1',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->orderBy('click_count', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $lastSixStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য')
            ->orderBy('story_date', 'desc') // Order by the newest stories
            ->take(6) // Limit to the last 6 stories
            ->get();

        $AllStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            // ->orderBy('story_date', 'desc') // Order by the newest stories
            // ->take(6) // Limit to the last 6 stories
            ->get();

        // Fetch top two stories where the category is "ইতিহাস"
        $historyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ইতিহাস') // Filter by the "ইতিহাস" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();


        // Fetch top two stories where the category is "দর্শন"
        $philosophyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'দর্শন') // Filter by the "দর্শন" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ধর্ম"
        $religionStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ধর্ম') // Filter by the "ধর্ম" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "খেলাধুলা"
        $sportsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'খেলাধুলা') // Filter by the "খেলাধুলা" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "ভ্রমণ"
        $travelStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'ভ্রমণ') // Filter by the "ভ্রমণ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "মুক্তিযুদ্ধ"
        $liberationStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'মুক্তিযুদ্ধ') // Filter by the "মুক্তিযুদ্ধ" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিশ্ব"
        $worldStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিশ্ব') // Filter by the "বিশ্ব" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "অর্থনীতি"
        $economyStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'অর্থনীতি') // Filter by the "অর্থনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "রাজনীতি"
        $politicsStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'রাজনীতি') // Filter by the "রাজনীতি" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        // Fetch top two stories where the category is "বিজ্ঞান"
        $scienceStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'বিজ্ঞান') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $literatureStories = Story::select([
            'id',
            'story_title',
            'banner',
            'story_writer',
            'story_date',
            'story_description',
            'story_category',
            'story_rating'
        ])
            ->where('story_category', 'সাহিত্য') // Filter by the "বিজ্ঞান" category
            ->orderBy('story_date', 'desc') // Order by story_date in descending order (newest first)
            ->take(2) // Limit the result to only two stories
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();
        $blogs = Story::select(['id', 'banner', 'story_title', 'story_writer', 'story_date', 'story_description', 'story_category', 'story_rating'])
            ->where('story_category', 'সাহিত্য') // Filter content by মুক্তিযুদ্ধ
            ->paginate(6); // Paginate 6 items per page

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials._blogs', compact('blogs'))->render(),
                'links' => (string) $blogs->links(),
            ]);
        }


        // Pass all categories' stories to the view
        return view('literature', compact(
            'historyStories',
            'philosophyStories',
            'footer_index',
            'religionStories',
            'sportsStories',
            'travelStories',
            'liberationStories',
            'worldStories',
            'economyStories',
            'politicsStories',
            'scienceStories',
            'lastSixStories',
            'AllStories',
            'blogs',
            'mostReadStories',
            'literatureStories',
            'bani',
            'literatureStories',
            'ad'
        ));
    }

    public function showDetailsStories($id)
    {
        $story = Story::findOrFail($id);  // Fetch the story

        // Calculate average rating
        $averageRating = $story->rating_count > 0 ? $story->story_rating / $story->rating_count : 0;

        // Fetch additional data like most-read and related stories
        $mostReadStories = Story::orderBy('click_count', 'desc')->take(6)->get();
        $lastSixStories = Story::orderBy('story_date', 'desc')->take(6)->get();

        $relatedStories = Story::where('story_category', $story->story_category)
            ->where('id', '!=', $story->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $ad = Ad::orderBy('created_at', 'desc')->first();

        // Fetch the bani with status = 1
        $bani = AjkerBani::where('status', 1)->first();

        $footer_index = Footer::where('status', 1)->get();

        // Fetch the latest survey
        $survey = Survey::orderBy('created_at', 'desc')->first();

        // Pass all data to the view
        return view('jibonjoyi_details', compact(
            'story',
            'mostReadStories',
            'lastSixStories',
            'relatedStories',
            'averageRating',
            'bani',
            'ad',
            'footer_index',
            'survey'
        ));
    }



    /**
     * Handle rating submission.
     */
    public function rateStory(Request $request, $id)
    {
        // Validate the rating input (1 to 5)
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Find the story
        $story = Story::findOrFail($id);

        // Add new rating to total sum and increment count
        $story->story_rating += $request->rating;
        $story->rating_count += 1;

        // Save changes to the database
        $story->save();

        // Calculate the updated average rating
        $averageRating = $story->rating_count > 0 ? $story->story_rating / $story->rating_count : 0;

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'total_rating' => $story->story_rating,
            'rating_count' => $story->rating_count,
            'average_rating' => round($averageRating, 2)
        ]);
    }
}
