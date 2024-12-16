<?php

namespace App\Http\Controllers;

use App\Models\Repayment;
use App\Models\Loan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RepaymentController extends Controller
{
    
    public function index(Request $request)
{

    $loanId = $request->input('loan_id');
    $status = $request->input('status');


    $repayments = Repayment::with('loan')
        ->when($loanId, fn($query) => $query->where('loan_id', $loanId))
        ->when($status, fn($query) => $query->where('status', $status))
        ->get();


    foreach ($repayments as $repayment) {
        $loan = $repayment->loan;
        $totalInterest = ($loan->amount * $loan->interest_rate * $loan->duration) / 100;
        $totalPayableAmount = $loan->amount + $totalInterest;

   
        $cumulativePaid = Repayment::where('loan_id', $loan->id)
            ->where('status', 'paid')
            ->sum('amount');
        $remainingAmount = $totalPayableAmount - $cumulativePaid;


        $repayment->paid_amount = $cumulativePaid;
        $repayment->remaining_amount = $remainingAmount;


        if ($repayment->status === 'pending' && now()->greaterThan($repayment->due_date)) {
            $repayment->status = 'overdue';
            $repayment->save();

         
            $penalty = $repayment->amount * 0.01;
            Repayment::create([
                'loan_id' => $loan->id,
                'installment_number' => $repayment->installment_number + 1,
                'amount' => $repayment->amount + $penalty,
                'status' => 'pending',
                'due_date' => now()->addMonth(),
            ]);
        }
    }

    return view('admin.repayments.index', compact('repayments', 'loanId', 'status'));
}


public function updateStatus(Request $request, Repayment $repayment)
{
    $repayment->status = $request->input('status');
    $repayment->save();

    if ($repayment->status === 'overdue') {
       
        $penalty = $repayment->amount * 0.01;
        Repayment::create([
            'loan_id' => $repayment->loan_id,
            'installment_number' => $repayment->installment_number + 1,
            'amount' => $repayment->amount + $penalty,
            'status' => 'pending',
            'due_date' => now()->addMonth(),
        ]);
    }

    return redirect()->back()->with('success', 'Repayment status updated successfully.');
}

    


    


   
    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        //
    }

   
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy($id)
    {

        $repayment = Repayment::findOrFail($id);


        $repayment->delete();

        
        return redirect()->route('admin.repayments.index')->with('success', 'Repayment deleted successfully.');
    }
}
