<?php

namespace App\Http\Controllers;

use App\Models\LoanType;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{
    
    public function index()
    {
        $loanTypes = LoanType::all();  
        return view('admin.loan_types.index', compact('loanTypes'));
    }
    public function create()
    {
      
        return view('admin.loan_types.create');
    }
    
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'min_amount' => 'required|numeric|min:0',
        'max_amount' => 'required|numeric|min:0|gte:min_amount',
        'default_interest_rate' => 'required|numeric|min:0|max:100',
    ]);
 
    LoanType::create($validatedData);

    return redirect()->route('admin.loan-types.index')
        ->with('success', 'Loan Type created successfully.');
}

    
    public function edit($id)
{
    $loanType = LoanType::findOrFail($id); 
    return view('admin.loan_types.edit', compact('loanType')); 
}


   
    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'min_amount' => 'required|numeric|min:0',
        'max_amount' => 'required|numeric|gte:min_amount',
        'default_interest_rate' => 'required|numeric|min:0|max:100',
    ]);

    $loanType = LoanType::findOrFail($id);
    $loanType->update($validatedData);

    return redirect()->route('admin.loan-types.index')
                     ->with('success', 'Loan type updated successfully.');
}


  
    public function destroy($id)
    {
        $loanType = LoanType::findOrFail($id);
        $loanType->delete();  

        return redirect()->route('admin.loan-types.index')->with('success', 'Loan Type deleted successfully.');
    }
}
