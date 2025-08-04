<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Companies::latest()->get();
        return Inertia::render('Companies/Index',compact('companies'));
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

    public function edit(Companies $company)
    {
          return Inertia::render('Companies/Edit', compact('company'));
    }

    public function update(Request $request, Companies $company)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
        ]);
        $company->update($data);
        return redirect()->route('companies.index')->with('message', 'Company updated successfully.');
    }
}
