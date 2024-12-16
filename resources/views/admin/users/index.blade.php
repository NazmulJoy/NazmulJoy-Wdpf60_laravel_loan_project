@extends('admin.layout.layout')

@php
    $title = 'Dashboard';
    $subTitle = 'Users';
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

    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('admin.users.create') }}'">
        Add User
    </button>

    <div class="card basic-data-table">
        <div class="card-header">
            <h5 class="card-title mb-0">Users</h5>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="dataTable" data-page-length="10">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: center;">S.L</th>
                        <th scope="col" style="text-align: center;">Name</th>
                        <th scope="col" style="text-align: center;">Mobile Number</th>
                        <th scope="col" style="text-align: center;">Marital Status</th>
                        <th scope="col" style="text-align: center;">Date of Birth</th>
                        <th scope="col" style="text-align: center;">Present Address</th>
                        <th scope="col" style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td style="text-align: center;">{{ $user->name }}</td>
                            <td style="text-align: center;">{{ $user->mobile_number }}</td>
                            <td style="text-align: center;">{{ $user->marital_status }}</td>
                            <td style="text-align: center;">{{ $user->date_of_birth }}</td>
                            <td style="text-align: center;">{{ $user->present_address }}</td>
                            <td style="text-align: center;">
                                <!-- Show Button -->
                                <button type="button" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#showUserModal" data-id="{{ $user->id }}">
                                    <iconify-icon icon="lucide:eye"></iconify-icon>
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <!-- Delete Button -->
                                <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $user->id }}">
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


    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
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

    
            const imagePath = data.image ? `/images/${data.image}` : '/images/default-user.jpg';
            document.getElementById('modalImage').src = imagePath;
        })
        .catch(error => console.error('Error:', error));
});
var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
   
        var button = event.relatedTarget;
        
       
        var userId = button.getAttribute('data-id');
        
    
        var deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/admin/users/' + userId; 
    });

    </script>

@endsection
