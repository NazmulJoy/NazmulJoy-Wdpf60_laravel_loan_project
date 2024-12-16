@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Loans';
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

    {{-- <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('admin.loans.create') }}'">
        Add Loan
    </button> --}}
    <div class="mb-3" style="width: 30%; max-width: 300px;">
        <label for="statusFilter" class="form-label">Filter by Status:</label>
        <select id="statusFilter" class="form-select">
            <option value="">Select Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="disbursed">Disbursed</option>
            <option value="fully repaid">Fully repaid</option>
        </select>
    </div>
    
    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Loans</h5>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;">S.L</th>
                        <th scope="col" style="text-align: center;">Loan Type</th>
                        <th scope="col" style="text-align: center;">Borrower</th>
                        <th scope="col" style="text-align: center;">Loan Amount</th>
                        <th scope="col" style="text-align: center;">Loan Duration</th>
                        <th scope="col" style="text-align: center;">Interest Rate</th>
                        <th scope="col" style="text-align: center;">Status</th>
                        <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody id="loanTableBody">
                    @foreach($loans as $index => $loan)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="text-align: center;">{{ $loan->loanType->name }}</td>
                            <td style="text-align: center;">{{ $loan->user->name }}</td>
                            <td style="text-align: center;">৳ {{ number_format($loan->amount) }}</td>
                            <td style="text-align: center;">
                                {{ $loan->duration }} Years 
                            </td>
                            <td style="text-align: center;">{{ $loan->interest_rate }}%</td>
                            <td>
                                <form action="{{ route('admin.loans.updateStatus', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $loan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $loan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $loan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="disbursed" {{ $loan->status == 'disbursed' ? 'selected' : '' }}>Disbursed</option>
                                        <option value="fully repaid" {{ $loan->status == 'fully repaid' ? 'selected' : '' }}>Fully repaid</option>
                                    </select>
                                </form>
                            </td>
                            <td style="text-align: center;">
                                <!-- Show Button -->
                                <button type="button" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#showUserModal" data-id="{{ $loan->user->id }}">
                                    <iconify-icon icon="lucide:eye"></iconify-icon>
                                </button>
                                {{-- <!-- Edit Button -->
                                <a href="{{ route('admin.loans.edit', $loan->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a> --}}
<!-- Button to trigger the modal -->
<button type="button" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" 
    data-bs-toggle="modal" data-bs-target="#loanDetailsModal"
    data-loan-id="{{ $loan->id }}"
    data-loan-type="{{ $loan->loanType->name }}"
    data-loan-amount="{{ $loan->amount }}"
    data-loan-duration="{{ $loan->duration }}"
    data-loan-interest="{{ $loan->interest_rate }}"
    data-loan-status="{{ $loan->status }}">
    <iconify-icon icon="lucide:clipboard"></iconify-icon> <!-- Eye Icon for loan details -->
</button>

                                <!-- Delete Button -->
                                <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $loan->id }}">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   
    <!-- Show User Modal -->
    <div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="showUserModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- User Image -->
                        <div class="col-md-4 text-center">
                            <img id="modalImage" src="/images/default-user.jpg" alt="User Image" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ccc;">
                            <h5 id="modalUserName" class="text-primary mt-2"></h5>
                        </div>
                        <!-- User Details -->
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Email:</th>
                                        <td id="modalUserEmail"></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number:</th>
                                        <td id="modalMobileNumber"></td>
                                    </tr>
                                    <tr>
                                        <th>Marital Status:</th>
                                        <td id="modalMaritalStatus"></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth:</th>
                                        <td id="modalDateOfBirth"></td>
                                    </tr>
                                    <tr>
                                        <th>Present Address:</th>
                                        <td id="modalPresentAddress"></td>
                                    </tr>
                                    <tr>
                                        <th>State:</th>
                                        <td id="modalState"></td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td id="modalCity"></td>
                                    </tr>
                                    <tr>
                                        <th>Postal Code:</th>
                                        <td id="modalPostalCode"></td>
                                    </tr>
                                    <tr>
                                        <th>Yearly Salary:</th>
                                        <td id="modalYearlySalary"></td>
                                    </tr>
                                    <tr>
                                        <th>Profession:</th>
                                        <td id="modalProfession"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Loan Details -->
    <div class="modal fade" id="loanDetailsModal" tabindex="-1" aria-labelledby="loanDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loanDetailsModalLabel">Loan Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Loan Type:</strong> <span id="loanType"></span></p>
                    <p><strong>Loan Amount:</strong> <span id="loanAmount"></span></p>
                    <p><strong>Duration:</strong> <span id="loanDuration"></span> Year(s)</p>
                    <p><strong>Interest Rate:</strong> <span id="loanInterestRate"></span>%</p>
                    <p><strong>Status:</strong> <span id="loanStatus"></span></p>
                    <p><strong>Total Interest:</strong> <span id="totalInterest"></span></p> <!-- Total Interest -->
                    <p><strong>Total Payable Amount:</strong> <span id="totalPayableAmount"></span></p>
                    <p><strong>Installment Amount:</strong> <span id="installmentAmount"></span></p>
                    <p><strong>Total Installments:</strong> <span id="totalInstallments"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



 <!-- Delete Confirmation Modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this loan?
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
        var showUserModal = document.getElementById('showUserModal');
        showUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');  

            fetch('/admin/users/' + userId)  
                .then(response => response.json())
                .then(data => {
                  
                    document.getElementById('modalUserName').innerText = data.name;
                    document.getElementById('modalUserEmail').innerText = data.email;
                    document.getElementById('modalMobileNumber').innerText = data.mobile_number;
                    document.getElementById('modalMaritalStatus').innerText = data.marital_status;
                    document.getElementById('modalDateOfBirth').innerText = data.date_of_birth;
                    document.getElementById('modalPresentAddress').innerText = data.present_address;
                    document.getElementById('modalState').innerText = data.state;
                    document.getElementById('modalCity').innerText = data.city;
                    document.getElementById('modalPostalCode').innerText = data.postal_code;
                    document.getElementById('modalYearlySalary').innerText = Math.round(data.yearly_salary);
                    document.getElementById('modalProfession').innerText = data.profession;
                    const imagePath = data.image ? `/images/${data.image}` : '/images/default-user.jpg';
                    document.getElementById('modalImage').src = imagePath;
                });
                
        });
      
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
           
            const loanId = this.getAttribute('data-loan-id');
            const loanType = this.getAttribute('data-loan-type');
            const loanAmount = parseFloat(this.getAttribute('data-loan-amount'));
            const loanDuration = parseInt(this.getAttribute('data-loan-duration'));
            const loanInterest = parseFloat(this.getAttribute('data-loan-interest'));
            const loanStatus = this.getAttribute('data-loan-status');
            
          
            document.getElementById('loanType').textContent = loanType;
            document.getElementById('loanAmount').textContent = '৳ ' + loanAmount.toLocaleString();
            document.getElementById('loanDuration').textContent = loanDuration;
            document.getElementById('loanInterestRate').textContent = loanInterest;
            document.getElementById('loanStatus').textContent = loanStatus.charAt(0).toUpperCase() + loanStatus.slice(1);
            
            
            const totalInterest = (loanAmount * loanInterest * loanDuration) / 100;
            const totalPayableAmount = loanAmount + totalInterest;
            const installmentAmount = totalPayableAmount / (loanDuration * 12);
            const totalInstallments = loanDuration * 12;

            
            document.getElementById('totalInterest').textContent = '৳ ' + totalInterest.toLocaleString();
            document.getElementById('totalPayableAmount').textContent = '৳ ' + totalPayableAmount.toLocaleString();
            document.getElementById('installmentAmount').textContent = '৳ ' + installmentAmount.toFixed(2).toLocaleString();
            document.getElementById('totalInstallments').textContent = totalInstallments;
        });
    });

        var deleteModal = document.getElementById('deleteModal');
       deleteModal.addEventListener('show.bs.modal', function (event) {
           var button = event.relatedTarget;
           var loanId = button.getAttribute('data-id');
           var deleteForm = document.getElementById('deleteForm');
           deleteForm.action = '/admin/loans/' + loanId;
       });

       document.getElementById('statusFilter').addEventListener('change', function () {
    const status = this.value;

    fetch(`/admin/loans?status=${status}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('loanTableBody');
            tableBody.innerHTML = '';

            data.loans.forEach((loan, index) => {
                tableBody.innerHTML += `
                    <tr>
                        <td style="text-align: center;">${index + 1}</td>
                        <td style="text-align: center;">${loan.loan_type}</td>
                        <td style="text-align: center;">${loan.borrower}</td>
                        <td style="text-align: center;">৳ ${new Intl.NumberFormat().format(loan.amount)}</td>
                        <td style="text-align: center;">${loan.duration} Year</td>
                        <td style="text-align: center;">${loan.interest_rate}%</td>
                        <td>
                            <form method="POST" action="/admin/loans/${loan.id}/status" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="pending" ${loan.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="approved" ${loan.status === 'approved' ? 'selected' : ''}>Approved</option>
                                    <option value="rejected" ${loan.status === 'rejected' ? 'selected' : ''}>Rejected</option>
                                    <option value="disbursed" ${loan.status === 'disbursed' ? 'selected' : ''}>Disbursed</option>
                                    <option value="fully repaid" ${loan.status === 'fully repaid' ? 'selected' : ''}>Fully repaid</option>
                                    fully repaid
                                </select>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <!-- Show Button -->
                            <button type="button" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#showUserModal" data-id="${loan.user_id}">
                                <iconify-icon icon="lucide:eye"></iconify-icon>
                            </button>
<button type="button" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" 
    data-bs-toggle="modal" data-bs-target="#loanDetailsModal"
    data-loan-id="{{ $loan->id }}"
    data-loan-type="{{ $loan->loanType->name }}"
    data-loan-amount="{{ $loan->amount }}"
    data-loan-duration="{{ $loan->duration }}"
    data-loan-interest="{{ $loan->interest_rate }}"
    data-loan-status="{{ $loan->status }}">
    <iconify-icon icon="lucide:clipboard"></iconify-icon> <!-- Eye Icon for loan details -->
</button>
                            <!-- Delete Button -->
                            <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="${loan.id}">
                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                            </button>
                            
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error fetching filtered loans:', error));
});

    </script>

@endsection
