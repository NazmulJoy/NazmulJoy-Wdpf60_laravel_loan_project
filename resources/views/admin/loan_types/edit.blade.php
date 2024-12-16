@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Edit Loan Type';
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Loan Type</h5>
            </div>
            <div class="card-body">
     
                <form action="{{ route('admin.loan-types.update', $loanType->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Loan Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $loanType->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $loanType->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Minimum Amount</label>
                        <input type="number" name="min_amount" class="form-control" value="{{ $loanType->min_amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Maximum Amount</label>
                        <input type="number" name="max_amount" class="form-control" value="{{ $loanType->max_amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Default Interest Rate (%)</label>
                        <input type="number" name="default_interest_rate" class="form-control" value="{{ $loanType->default_interest_rate }}" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Update Loan Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
