<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AjkerBani;

class BaniController extends Controller
{
    // Display all bani and form to create new bani
    public function index()
    {
        $banis = AjkerBani::orderBy('created_at', 'desc')->paginate(3);  
        return view('stories.bani', compact('banis'));
        
    }

    // Store new bani
    public function store(Request $request)
    {
        $request->validate([
            'bani_writer' => 'required|string|max:255',
            'bani' => 'required|string|max:255',
            'status' => 'nullable|in:0,1',
        ]);

        // Check if status = 1 already exists
        if ($request->status == 1 && AjkerBani::where('status', 1)->exists()) {
            return redirect()->back()->with('error', 'You can choose only one bani with status 1.');
        }

        // If status not provided, set default to 0
        $status = $request->status ?? 0;

        AjkerBani::create([
            'bani_writer' => $request->bani_writer,
            'bani' => $request->bani,
            'status' => $status,
        ]);

        return redirect()->route('stories.bani.index')->with('success', 'Bani added successfully!');
    }

    // Show form to edit bani
    public function edit($id)
    {
        $bani = AjkerBani::findOrFail($id);
        return view('stories.edit_bani', compact('bani'));
    }

    // Update bani
    public function update(Request $request, $id)
    {
        $request->validate([
            'bani_writer' => 'required|string|max:255',
            'bani' => 'required|string|max:255',
            'status' => 'nullable|in:0,1',
        ]);

        $bani = AjkerBani::findOrFail($id);

        // Check if trying to set status to 1 when another bani already has status 1
        if ($request->status == 1 && AjkerBani::where('status', 1)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'You can choose only one bani with status 1.');
        }

        // If the checkbox is not checked, set status to 0
        $status = $request->has('status') ? 1 : 0;

        $bani->update([
            'bani_writer' => $request->bani_writer,
            'bani' => $request->bani,
            'status' => $status,
        ]);

        return redirect()->route('stories.bani.index')->with('success', 'Bani updated successfully!');
    }


    // Delete bani
    public function destroy($id)
    {
        $bani = AjkerBani::findOrFail($id);
        $bani->delete();

        return redirect()->route('stories.bani.index')->with('success', 'Bani deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $bani = AjkerBani::findOrFail($id);

        // Check if trying to set status to 1 when another bani already has status 1
        if ($bani->status == 0 && AjkerBani::where('status', 1)->exists()) {
            return redirect()->back()->with('error', 'You can feature only one bani at a time.');
        }

        // Toggle status
        $bani->status = $bani->status == 1 ? 0 : 1;
        $bani->save();

        $message = $bani->status == 1 ? 'Bani activated successfully!' : 'Bani inactivated successfully!';

        return redirect()->back()->with('success', $message);
    }
}
