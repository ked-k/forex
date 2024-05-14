 <!-- ADD NEW USER Modal -->
 
 <div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New User(<span class="text-danger">*</span>is required)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        
                        <div class="mb-3 col-md-5">
                            <label for="surname" class="form-label">Username<span class="text-danger">*</span></label>
                            <input type="text" id="surname" class="form-control" name="name" required value="{{ old('name', '') }}">
                        </div>
                        <div class="mb-3 col-md-7">
                            <label for="first_name" class="form-label">Full Name<span class="text-danger">*</span></label>
                            <input type="text" id="first_name" class="form-control" name="full_name" required value="{{ old('full_name', '') }}">
                        </div>
                       
                            
                        <div class="mb-3 col-md-4">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" id="email" class="form-control" name="email" required value="{{ old('email', '') }}">
                        </div> 
                        <div class="mb-3 col-md-4">
                            <label for="contact" class="form-label">Contact<span class="text-danger">*</span></label>
                            <input type="text" id="contact" class="form-control" name="contact" required value="{{ old('contact', '') }}">
                        </div> 

                        {{-- <div class="mb-3 col-md-4">
                            <label for="designation_id" class="form-label">Facility<span class="text-danger">*</span></label>
                            <select class="form-select" id="designation_id" name="designation_id" required>
                                <option value="" selected>Select Role</option>                          
                                 @if(count($locations)>0)
                                @foreach($locations as $facility)
                                <option value="{{ $facility->name }}">{{$facility->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div> --}}
                       
                    
                      
                            
                        <div class="mb-3 col-md-4">
                            <label for="is_active" class="form-label">Status<span class="text-danger">*</span></label>
                            <select class="form-select" id="is_active" name="is_active" required>
                                <option value="1" style="color: green" selected>Active</option>
                                <option value="0" style="color: red">Suspended</option>
                            </select>
                        </div>
                           
                        <div class="mb-3 col-md-8">
                            <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                            <input type="text" id="password" value="123456" class="form-control" name="password" required>
                        </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"  id="submitBtn"> Add User</button>
                    </div>
                </form>
            </div>
            
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
 <!-- UPDATE USER Modal -->
@foreach ($users as $key=>$user)
 <div class="modal fade" id="editUser{{$user->uid}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">UPDATE USER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form method="POST" action="{{route('users.update',[$user->uid])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="row col-md-12">
                           
                            <div class="mb-3 col-md-4">
                                <label for="surname2" class="form-label">Surname<span class="text-danger">*</span></label>
                                <input type="text" id="surname2" class="form-control" name="name" required value="{{$user->name}}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="first_name2" class="form-label">First Name<span class="text-danger">*</span></label>
                                <input type="text" id="first_name2" class="form-control" name="full_name" required value="{{$user->full_name}}">
                            </div>
                            
                            <div class="mb-3 col-md-4">
                                <label for="email2" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" id="email2" class="form-control" name="email" required value="{{$user->email}}">
                            </div> 
                            <div class="mb-3 col-md-4">
                                <label for="contact2" class="form-label">Contact<span class="text-danger">*</span></label>
                                <input type="text" id="contact2" class="form-control" name="contact" required value="{{$user->contact}}">
                            </div> 
                        </div> 
                     
                            
                            <div class="mb-3 col-md-4">
                                <label for="is_active2" class="form-label">Status<span class="text-danger">*</span></label>
                                <select class="form-select" id="is_active2" name="is_active" required>
                                    @if ($user->is_active==1)
                                        <option value="{{$user->is_active}}" selected style="color: green">Active</option>  
                                    @else
                                        <option value="{{$user->is_active}}" selected style="color: red">Suspended</option>
                                    @endif
                                    <option value="1" style="color: green">Active</option>
                                    <option value="0" style="color: red">Suspended</option>
                                </select>
                            </div>
                    </div>
                    <!-- end row--> 
                    <div class="d-grid mb-0 text-center">
                        <button class="btn btn-primary" type="submit"  id="submitButton2"> Update User</button>
                    </div>
                </form>
            </div>
            
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
<!-- VIEW USER ACCOUNT DETAILS -->
@foreach ($users as $key=>$user)
<div class="modal fade" id="viewUser{{$user->id}}"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">USER DETAILS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Profile -->
                        <div class="card bg-primary">
                            <div class="card-body profile-user-box">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="avatar-lg">
                                                    <img src="{{asset('storage/'.$user->avatar)}}" alt="" class="rounded-circle img-thumbnail">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div>
                                                    <h4 class="mt-1 mb-1 text-white">{{$user->title.' '.$user->first_name.' '.$user->other.' '.$user->surname}}</h4>
                                                    <p class="font-13 text-white-50">{{$user->email}}</p>

                                                    <ul class="mb-0 list-inline text-light">
                                                       
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Username</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->location_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Facility</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->department_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Department</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->designation_name}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Designation</p>
                                                        </li>
                                                        <li class="list-inline-item me-3">
                                                            <h5 class="mb-1">{{$user->contact}}</h5>
                                                            <p class="mb-0 font-13 text-white-50">Contact</p>
                                                        </li>
                                                       
                                                        <li class="list-inline-item">
                                                            @if ($user->is_active==1)
                                                            <h5 class="mb-1" style="color: rgb(160, 221, 160)">Active</h5>  
                                                                @else
                                                            <h5 class="mb-1" style="color: red">Suspended</h5> 
                                                            @endif
                                                            <p class="mb-0 font-13 text-white-50">Status</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col-->

                                    <div class="col-sm-4">
                                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editUser{{$user->id}}" data-bs-dismiss="modal">
                                                <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                            </button>
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row -->

                            </div> <!-- end card-body/ profile-user-box-->
                        </div><!--end profile/ card -->
                    </div> <!-- end col-->
                </div>
            </div>
        </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
</div> <!-- end modal-->
@endforeach
<script type="text/javascript">
    
    function generatePass()
    {
    var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var passwordLength = 8;
    var password = "";
    var passwordInput = document.getElementById("password");
    for (var i = 0; i <= passwordLength; i++) 
    {
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber +1);
    };
    passwordInput.value = password;
    passwordInput.select();
    document.execCommand("copy");  
    }

</script>
