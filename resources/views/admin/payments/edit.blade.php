@extends('admin.layout.layout')

@php
$title = 'dashboard';
$subTitle = 'Edit Payment';
$script = '<script>
let table = new DataTable("#dataTable");
</script>';
@endphp

@section('content')
    <h4>Edit Payment</h4>

    <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}">
        @csrf
        @method('PUT')

       
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required onchange="fetchRepayments(this.value)">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $payment->repayment->loan->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

      
        <div class="mb-3">
            <label for="repayment_id" class="form-label">Repayment</label>
            <select name="repayment_id" id="repayment_id" class="form-select" required>
                <option value="">Select Repayment</option>
                @foreach($payment->repayment->loan->repayments as $repayment)
                    <option value="{{ $repayment->id }}" {{ $payment->repayment_id == $repayment->id ? 'selected' : '' }}>
                        Installment #{{ $repayment->installment_number }}
                    </option>
                @endforeach
            </select>
        </div>

       
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="text" name="amount" id="amount" class="form-control" value="{{ $payment->amount }}" readonly>
        </div>

   
        <div class="mb-3">
            <label for="method" class="form-label">Payment Method</label>
            <select name="method" id="method" class="form-select" required>
                <option value="bkash" {{ $payment->method == 'bkash' ? 'selected' : '' }}>Bkash</option>
                <option value="nagad" {{ $payment->method == 'nagad' ? 'selected' : '' }}>Nagad</option>
                <option value="rocket" {{ $payment->method == 'rocket' ? 'selected' : '' }}>Rocket</option>
                <option value="bank" {{ $payment->method == 'bank' ? 'selected' : '' }}>Bank</option>
            </select>
        </div>

       
        <div class="mb-3">
            <label for="transaction_id" class="form-label">Transaction ID</label>
            <input type="text" name="transaction_id" id="transaction_id" class="form-control" value="{{ $payment->transaction_id }}" required>
        </div>

     
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Payment</button>
        </div>
    </form>
@endsection

<script>
   
    function fetchRepayments(userId) {
        if (!userId) {
            document.getElementById('repayment_id').innerHTML = '<option value="">Select Repayment</option>';
            document.getElementById('amount').value = '';
            return;
        }

        fetch(`/admin/payments/get-repayments/${userId}`)
            .then(response => response.json())
            .then(data => {
                let repaymentSelect = document.getElementById('repayment_id');
                repaymentSelect.innerHTML = '<option value="">Select Repayment</option>';
                data.repayments.forEach(repayment => {
                    let option = document.createElement('option');
                    option.value = repayment.id;
                    option.textContent = `Installment #${repayment.installment_number}`;
                    repaymentSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching repayments:', error));
    }

 
    document.getElementById('repayment_id').addEventListener('change', function () {
        const selectedRepayment = this.selectedOptions[0];
        if (selectedRepayment) {
            const repaymentId = selectedRepayment.value;
            fetch(`/admin/payments/get-repayment-details/${repaymentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('amount').value = data.amount;
                })
                .catch(error => console.error('Error fetching repayment details:', error));
        }
    });
</script>