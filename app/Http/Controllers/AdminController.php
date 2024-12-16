<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Loan;
use App\Models\Repayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    public function showLoginForm()
    {
       
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.adminlogin'); 
    }

  
    public function login(Request $request)
    {
     
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

      
        if (Auth::attempt(array_merge($credentials, ['role' => 'admin']))) {
            $request->session()->regenerate(); // Prevent session fixation
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or unauthorized access.',
        ]);
    }

  
    public function dashboard()
    {
        
        $totalLoanApproved = Loan::where('status', 'approved')->sum('amount');
        $totalInterestAmount = Loan::where('status', 'approved')
            ->get()
            ->sum(function ($loan) {
                return ($loan->amount * $loan->interest_rate * $loan->duration) / 100;
            });
        $totalUsers = User::where('role', 'user')->count();
        $loansApprovedLast30Days = Loan::where('status', 'approved')
            ->where('approved_at', '>=', now()->subDays(30))
            ->count();
        $installmentsCollectedLast30Days = Repayment::where('paid_at', '>=', now()->subDays(30))->count();
        $totalPendingLoanAmount = Repayment::where('status', 'pending')->sum('amount');
    
        return view('admin.dashboard', compact(
            'totalLoanApproved',
            'totalInterestAmount',
            'totalUsers',
            'loansApprovedLast30Days',
            'installmentsCollectedLast30Days',
            'totalPendingLoanAmount'
        ));
    }

   
    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('admin.login'); 
    }
}
