@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = '';
    $script = ''; // Removed inline PHP logic as it will be handled in the controller.
@endphp

@section('content')

    <div class="container-fluid">
        <div class="row gy-4">
            <!-- Total Loan Approved Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Loan Approved</p>
                                <h6 class="mb-0">{{ number_format($totalLoanApproved, 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="gridicons:money" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Interest Amount Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Interest Amount</p>
                                <h6 class="mb-0">{{ number_format($totalInterestAmount, 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fluent:money-24-filled" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <!-- Total Users Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Users</p>
                                <h6 class="mb-0">{{ $totalUsers }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fluent:people-20-filled" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans Approved in Last 30 Days Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Loans Approved in Last 30 Days</p>
                                <h6 class="mb-0">{{ $loansApprovedLast30Days }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="ic:outline-check-circle" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <!-- Installments Collected in Last 30 Days Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Installments Collected in Last 30 Days</p>
                                <h6 class="mb-0">{{ $installmentsCollectedLast30Days }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-danger rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="bx:bx-credit-card" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pending Loan Amount Card -->
            <div class="col-md-6">
                <div class="card shadow-none border bg-gradient-start-6 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Pending Loan Amount</p>
                                <h6 class="mb-0">{{ number_format($totalPendingLoanAmount, 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:exclamation-circle" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
