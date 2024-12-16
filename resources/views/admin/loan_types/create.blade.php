@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Add a New Loan Type';
@endphp

@section('content')

    <div class="row justify-content-center gy-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Loan Type Form</h5>
                </div>
                <div class="card-body">
             
                    <form action="{{ route('admin.loan-types.store') }}" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Loan Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Loan Name" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Minimum Amount</label>
                                <input type="number" name="min_amount" class="form-control" placeholder="Enter Minimum Amount" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Maximum Amount</label>
                                <input type="number" name="max_amount" class="form-control" placeholder="Enter Maximum Amount" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Default Interest Rate (%)</label>
                                <input type="number" name="default_interest_rate" class="form-control" placeholder="Enter Interest Rate" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary-600">Save Loan Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

