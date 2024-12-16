@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Loan Types';
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
    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('admin.loan-types.create') }}'">
        Add Loan Type
    </button>
    
    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Loan Types</h5>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;">S.L</th>
                        <th scope="col" style="text-align: center;">Name</th>
                        <th scope="col" style="text-align: center;">Description</th>
                        <th scope="col" style="text-align: center;">Min Amount</th>
                        <th scope="col" style="text-align: center;">Max Amount</th>
                        <th scope="col" style="text-align: center;">Interest Rate (%)</th>
                        <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loanTypes as $index => $loanType)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="text-align: center;">{{ $loanType->name }}</td>
                            <td style="text-align: center;">{{ $loanType->description }}</td>
                            <td style="text-align: center;">৳{{ number_format($loanType->min_amount, 2) }}</td>
                            <td style="text-align: center;">৳{{ number_format($loanType->max_amount, 2) }}</td>
                            <td style="text-align: center;">{{ $loanType->default_interest_rate }}%</td>
                            <td style="text-align: center;">
                       
                                <a href="{{ route('admin.loan-types.edit', $loanType->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                            
                                <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $loanType->id }}">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this loan type?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
         
            var button = event.relatedTarget;
           
            var loanTypeId = button.getAttribute('data-id');
        
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = '/admin/loan-types/' + loanTypeId;
        });
    </script>
@endsection
