<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Repayment;
use App\Models\User;

class PaymentController extends Controller
{
    
    public function index(Request $request)
{
    $status = $request->input('status');
    $repaymentId = $request->input('repayment_id');

    $payments = Payment::with('user')
        ->when($status, fn($query) => $query->where('status', $status))
        ->when($repaymentId, fn($query) => $query->where('repayment_id', $repaymentId))
        ->get();

    return view('admin.payments.index', compact('payments', 'status', 'repaymentId'));
}

public function updateStatus(Request $request, Payment $payment)
{
    $validatedData = $request->validate([
        'status' => 'required|in:pending,completed,failed',
    ]);

    
    $payment->status = $validatedData['status'];
    $payment->save();

  
    if ($validatedData['status'] === 'completed') {
        $repayment = $payment->repayment; 
        if ($repayment && $repayment->status === 'pending') {
            $repayment->status = 'paid';
            $repayment->save();
        }
    }

    return redirect()->back()->with('success', 'Payment status updated successfully.');
}


public function show(Payment $payment)
{
    $payment->load('user', 'repayment.loan.loanType'); 
    return response()->json($payment);
}







   
public function create()
{
    $users = User::all(); 
    return view('admin.payments.create', compact('users'));
}


    
public function store(Request $request)
{
    $validatedData = $request->validate([
        'repayment_id' => 'required|exists:repayments,id',
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
        'method' => 'required|string',
        'transaction_id' => 'required|string',
        'status' => 'required|in:pending,completed,failed',
    ]);

   
    $payment = Payment::create($validatedData);

  
    $repayment = Repayment::find($validatedData['repayment_id']);
    if ($repayment && $repayment->status === 'pending') {
        $repayment->status = 'paid';
        $repayment->save();
    }

    return redirect()->route('admin.payments.index')->with('success', 'Payment created and repayment status updated to paid.');
}



    
public function getRepayments($userId)
{
    $repayments = Repayment::whereHas('loan', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->where('status', 'pending') 
    ->get();

    return response()->json(['repayments' => $repayments]);
}

public function getRepaymentDetails($repaymentId)
{
    $repayment = Repayment::find($repaymentId);

    if (!$repayment) {
        return response()->json(['error' => 'Repayment not found'], 404);
    }

    return response()->json(['amount' => $repayment->amount]);
}


    
    public function edit(Payment $payment)
{
    $repayments = Repayment::all();
    $users = User::all();
    return view('admin.payments.edit', compact('payment', 'repayments', 'users'));
}


   
    public function update(Request $request, Payment $payment)
{
    $validatedData = $request->validate([
        'repayment_id' => 'required|exists:repayments,id',
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
        'method' => 'required|string',
        'transaction_id' => 'nullable|string',
        'status' => 'required|in:pending,completed,failed',
    ]);

    $payment->update($validatedData);

    return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
}


    
    public function destroy(Payment $payment)
{
    $payment->delete();
    return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
}

}
