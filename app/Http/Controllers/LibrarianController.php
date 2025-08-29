<?php

namespace App\Http\Controllers;

use App\Models\librarian;
use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $librarians = Librarian::query()
            ->when($search, function ($query, $search) {
                $query->where('librarianname', 'like', "%{$search}%")
                      ->orWhere('phonenumber', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString(); // keep search on pagination links
            if ($request->ajax()) {
                return view('librarians.partials.librarian_table', compact('librarians'))->render();
            }
            return view('librarians.index', compact('librarians'));
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('librarians.create');
    }

    /** 
     * Store a newly created resou  rce in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'librarianname' => 'required',
        'email' => 'required|email',
        'phonenumber' => 'required',
        'address' => 'required',
    ]);

    $librarian = Librarian::create($request->only(['librarianname', 'email', 'phonenumber', 'address']));

    if ($request->ajax()) {
        return response()->json([
            'message' => 'Librarian created successfully.',
            'librarian' => $librarian,
        ]);
    }

    return redirect()->route('librarians.index')->with('success', 'Librarian created successfully.');
}

        


    public function show(librarian $librarian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(librarian $librarian)
    {
        return view ('librarians.edit', compact('librarian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, librarian $librarian)
    {
        $request->validate([
            'librarianname' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'address' => 'required',
        ]);

        $librarian->update($request->only(['librarianname', 'phonenumber', 'email', 'address']));

         if ($request->ajax()) {
          return response()->json([
                'message' => '...',
                'librarian' => $librarian, // when applicable
            ]);
        }

        return redirect()->route('librarians.index')->with('success', 'Librarian updated successfully.');
    }   

   public function destroy(Librarian $librarian)
{
    $librarian->delete();
    return response()->json(['message' => 'Librarian deleted successfully.']);
}
}
