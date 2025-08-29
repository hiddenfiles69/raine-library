<?php

namespace App\Http\Controllers;

use App\Models\Patron;
use Illuminate\Http\Request;

class PatronController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $patrons = Patron::query()
            ->when($search, function ($query, $search) {
                $query->where('patronname', 'like', "%{$search}%")
                      ->orWhere('phonenumber', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString(); // keep search on pagination links
            if ($request->ajax()) {
                return view('patrons.partials.patron_table', compact('patrons'))->render();
            }
            return view('patrons.index', compact('patrons'));
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patrons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patronname' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'address' => 'required',
        ]);

        // Patron::create($request->all());
        $patron = Patron::create($request->all());
        if ($request->ajax()) {
    return response()->json([
        'message' => 'Patron created successfully.',
        'patron' => $patron,
    ]);
}
         return redirect()->route('patrons.index')->with('success', 'Patron created successfully.');
    }
        

    public function show(Patron $patron)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patron $patron)
    {
        return view ('patrons.edit', compact('patron'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patron $patron)
    {
        $request->validate([
            'patronname' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'address' => 'required',
        ]);

        $patron->update($request->only(['patronname', 'phonenumber', 'email', 'address']));

         if ($request->ajax()) {
    return response()->json([
        'message' => 'Patron updated successfully.',
        'patron' => $patron,
    ]);

        }

        return redirect()->route('patrons.index')->with('success', 'Patron updated successfully.');
    }
  public function destroy(Patron $patron)
{
    $patron->delete();
    return response()->json(['message' => 'Patron deleted successfully.']);
}

}
