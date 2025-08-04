<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('Companies/Index',[]);
    }
    public function create()
    {
        return Inertia::render('Companies/Create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]); 
        Companies::create($data);
        return redirect()->route('companies.index')->with('message', 'Company created successfully.');
    }
}
