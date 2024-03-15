@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Customers')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb  d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Customers</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Customer</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SupplierModal">Add a new Customers</button>
						<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#balanceModal">Add Customer Cerdit/Debit</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Customer's list</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Customer name</th>
                                                    <th>Email</th>
                                                    <th>Contact</th>
                                                    <th>Address</th>
                                                    <th>Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->cust_name}}</td>
                                                    <td>{{ $value->email}}</td>
                                                    <td>{{ $value->contact}}</td>
                                                    <td>{{ $value->address}}</td>
                                                    <td>@money($value->balance)</td>
                                                    <td class="table-action">
                                                        @if($value->is_active==1)
                                                        <span class="badge bg-success float-center">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->is_active==0)
                                                        <span class="badge bg-danger float-center">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                        <a href="javascript: void(0);" class="action-icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#Umodal{{ $value->id }}"></i></a>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('forex/customers/delete/'.$value->id) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                        <a href="{{ url('forex/customers/show/'.$value->id) }}"  title="View customer!" class="action-icon"> <i class="bx bx-book-reader"></i></a>
                                                           <!-- ADD NEW Category Modal -->
                                                        <div class="modal fade" id="Umodal{{ $value->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Edit Custmoer</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ url('forex/customers/update/'.$value->id) }}" method="POST">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">

                                                                                        <div class="mb-3">
                                                                                            <label for="cust_name" class="form-label">Customer Name</label>
                                                                                            <input type="text" id="cust_name" value="{{ $value->cust_name}}" class="form-control" name="sup_name">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="address" class="form-label">Address</label>
                                                                                            <input type="text" id="address" value="{{ $value->address}}" class="form-control" name="address">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="contact" class="form-label">Contact</label>
                                                                                            <input type="text" id="contact" value="{{ $value->contact}}" class="form-control" name="contact">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="email" class="form-label">Email</label>
                                                                                            <input type="text" id="email" value="{{ $value->email}}" class="form-control" name="email">
                                                                                        </div>

                                                                                        <div class="mb-3">
                                                                                            <label for="isActive" class="form-label">State</label>
                                                                                            <select class="form-control" id="isActive" name="isActive">
                                                                                                <option value="{{$Stvalue}}">{{$satate}}</option>
                                                                                                <option value="1">Active</option>
                                                                                                <option value="0">InActive</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div> <!-- end col -->

                                                                                </div>
                                                                                <!-- end row-->
                                                                                <div class="d-grid mb-0 text-center">
                                                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                                                </div>

                                                                            </form>

                                                                        </div>

                                                                    </div> <!-- end modal content-->
                                                                </div> <!-- end modal dialog-->
                                                        </div> <!-- end modal-->
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    @include("forex.modals.customer")
                     @include("forex.modals.customer_balance")
			</div>
 @endsection
