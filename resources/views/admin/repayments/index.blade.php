@extends('admin.layout.layout')

@php
$title = 'dashboard';
$subTitle = 'Repayment Details';
$script = '<script>
let table = new DataTable("#dataTable");
</script>';
@endphp

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('error') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-3" style="width: 30%; max-width: 300px;">
    <label for="statusFilter" class="form-label">Filter by Status:</label>
    <select id="statusFilter" class="form-select" onchange="filterStatus()">
        <option value="">Select Status</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
    </select>
</div>

<div class="mb-3" style="width: 30%; max-width: 300px;">
    <label for="loanFilter" class="form-label">Filter by Loan ID:</label>
    <input type="text" class="form-control" id="loanFilter" placeholder="Enter Loan ID" value="{{ request('loan_id') }}" oninput="filterLoanId()">
</div>

<div class="card basic-data-table">
    <div class="card-header">
        <h5 class="card-title mb-0">Repayment Details</h5>
    </div>
    <div class="card-body">
        <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
    <thead>
        <tr>
            <th scope="col" style="text-align: center;">#</th>
            <th scope="col" style="text-align: center;">Loan ID</th>
            <th scope="col" style="text-align: center;">Borrower Name</th>
            <th scope="col" style="text-align: center;">Installment #</th>
            <th scope="col" style="text-align: center;">Due Date</th>
            <th scope="col" style="text-align: center;">Status</th>
            <th scope="col" style="text-align: center;">Installment Amount</th>
            <th scope="col" style="text-align: center;">Total Paid Amount</th>
            <th scope="col" style="text-align: center;">Remaining Loan Amount</th>
            <th scope="col" style="text-align: center;">Action</th>
        </tr>
    </thead>
    <tbody>
       
            @php
                
                $loan = $repayments->first()->loan ?? null;
                $loanAmount = $loan->amount ?? 0;
                $interestRate = $loan->interest_rate ?? 0;
                $duration = $loan->duration ?? 0;
                $totalInterest = ($loanAmount * $interestRate * $duration) / 100;
                $totalPayableAmount = $loanAmount + $totalInterest;
                $cumulativePaidAmount = 0; 
            @endphp

            @foreach($repayments as $index => $repayment)
                @if($repayment->loan)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $repayment->loan_id }}</td>
                    <td style="text-align: center;">{{ $repayment->loan->user->name ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $repayment->installment_number }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($repayment->due_date)->format('d M Y') }}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.repayments.updateStatus', $repayment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="paid" {{ $repayment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ $repayment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="overdue" {{ $repayment->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </form>
                    </td>
                    <td style="text-align: center;">{{ number_format($repayment->amount) }}</td>
                    <td style="text-align: center;">
                        @php
                           
                            if ($repayment->status === 'paid') {
                                $cumulativePaidAmount += $repayment->amount;
                            }
                        @endphp
                        {{ number_format($cumulativePaidAmount) }}
                    </td>
                    <td style="text-align: center;">
                        @php
                          
                            $remainingAmount = $totalPayableAmount - $cumulativePaidAmount;
                        @endphp
                        {{ number_format($remainingAmount) }}
                    </td>
                    <td style="text-align: center;">
                        <a href="javascript:void(0)" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $repayment->id }}">
                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </a>
                    </td>
                </tr>
                @endif 
            @endforeach
      
    </tbody>
</table>

        
        
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Repayment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure you want to delete this repayment record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<script>
    $(document).ready(function() { $('#dataTable').DataTable({ "language": { "emptyTable": "No records found for the selected status." }, "drawCallback": function(settings) { if (settings.aoData.length === 0) { $('#dataTable tbody').html('<tr><td colspan="10" style="text-align: center;">No records found for the selected status.</td></tr>'); } } }); });
    function filterStatus() {
        const status = document.getElementById("statusFilter").value;
        const loanId = document.getElementById("loanFilter").value;
        let url = `?status=${status}`;
        if (loanId) url += `&loan_id=${loanId}`;
        window.location.href = url;
    }

    function filterLoanId() {
        const status = document.getElementById("statusFilter").value;
        const loanId = document.getElementById("loanFilter").value;
        let url = `?loan_id=${loanId}`;
        if (status) url += `&status=${status}`;
        window.location.href = url;
    }
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('[data-bs-target="#deleteModal"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const repaymentId = button.getAttribute('data-id');
                const deleteForm = document.getElementById('deleteForm');
                const deleteUrl = `{{ url('admin/repayments') }}/${repaymentId}`;
                deleteForm.setAttribute('action', deleteUrl);
            });
        });
    });
    
</script>
