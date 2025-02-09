<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footer;

class FooterController extends Controller
{
    /**
     * Display all footer texts on the liberation page.
     */
    public function footer_index()
    {
        // Fetch all footer texts from the database
        $footer_index = Footer::all();

        // Pass the data to the 'liberation.blade.php' view
        return view('liberation', compact('footer_index'));
    }

    /**
     * Display the form to add new footer text.
     */
    public function create()
{
    $footer_texts = Footer::orderBy('created_at', 'desc')->paginate(3); 

    return view('stories.add-footer', compact('footer_texts'));
}



    /**
     * Store the new footer text in the database.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'text' => 'required|string|max:255',  // Ensure text is required and max 255 characters
        ]);

        // Insert the new footer text into the database
        Footer::create([
            'text' => $request->text,
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('stories.footer.create')->with('success', 'Footer text added successfully!');
    }
    public function edit($id)
    {
        $footer = Footer::findOrFail($id);
        return view('stories.edit-footer', compact('footer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $footer = Footer::findOrFail($id);
        $footer->update(['text' => $request->text]);

        return redirect()->route('stories.footer.create')->with('success', 'Footer text updated successfully!');
    }
    public function destroy($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->delete();

        return redirect()->route('stories.footer.create')->with('success', 'Footer text deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $footer = Footer::findOrFail($id);
        $footer->status = $footer->status ? 0 : 1;  // Toggle between 1 and 0
        $footer->save();

        return redirect()->route('stories.footer.create')->with('success', 'Footer status updated successfully!');
    }


}