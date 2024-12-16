@extends('admin.layout.layout')
@php
$title = 'dashboard';
$subTitle = 'Create Payment';
$script = '<script>
let table = new DataTable("#dataTable");
</script>';
@endphp
@section('content')
    <h4>Create Payment</h4>

    <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf
        
        
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required onchange="fetchRepayments(this.value)">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

      
        <div class="mb-3">
            <label for="repayment_id" class="form-label">Repayment</label>
            <select name="repayment_id" id="repayment_id" class="form-select" required onchange="fetchAmount(this.value)">
                <option value="">Select Repayment</option>
            </select>
        </div>

       
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" name="amount" id="amount" class="form-control" readonly>
        </div>

        
        <div class="mb-3">
            <label for="method" class="form-label">Payment Method</label>
            <select name="method" id="method" class="form-select" required>
                <option value="bkash">Bkash</option>
                <option value="nagad">Nagad</option>
                <option value="rocket">Rocket</option>
                <option value="bank">Bank</option>
            </select>
        </div>

      
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
        </div>

    
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="failed">Failed</option>
            </select>
        </div>

       
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Create Payment</button>
        </div>
    </form>
@endsection

<script>
   
    function fetchRepayments(userId) {
        const repaymentSelect = document.getElementById('repayment_id');
        repaymentSelect.innerHTML = '<option value="">Select Repayment</option>';
        document.getElementById('amount').value = ''; 

        if (!userId) return;

        fetch(`/admin/payments/get-repayments/${userId}`)
            .then(response => response.json())
            .then(data => {
                data.repayments.forEach(repayment => {
                    const option = document.createElement('option');
                    option.value = repayment.id;
                    option.textContent = `Installment #${repayment.installment_number}`;
                    repaymentSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching repayments:', error));
    }


    function fetchAmount(repaymentId) {
        const amountInput = document.getElementById('amount');

        if (!repaymentId) {
            amountInput.value = '';
            return;
        }

        fetch(`/admin/payments/get-repayment-details/${repaymentId}`)
            .then(response => response.json())
            .then(data => {
                amountInput.value = data.amount || '';
            })
            .catch(error => console.error('Error fetching repayment details:', error));
    }
</script>
