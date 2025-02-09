<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyController extends Controller
{
    // Display the survey
    public function showSurvey() {
        $survey = Survey::first();  // Fetch the first survey
        return view('jibonjoyi_details', compact('survey'));
    }

    // Handle the vote submission
    public function submitVote(Request $request) {
        $survey = Survey::first(); // Assuming single survey

        switch ($request->input('poet')) {
            case 'opt1':
                $survey->increment('opt1_count');
                break;
            case 'opt2':
                $survey->increment('opt2_count');
                break;
            case 'opt3':
                $survey->increment('opt3_count');
                break;
            case 'opt4':
                $survey->increment('opt4_count');
                break;
        }

        return redirect()->back()->with('success', 'Thank you for your vote!');
    }
}
