@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Losses')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Losses</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Loss Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lossModal">Register a new loss</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Losses list</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Reffernce</th>
                                                    <th>Description</th>
                                                    <th>Account</th>
                                                    <th>User</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Amount({{$mycur}})</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->reff_number}}</td>
                                                    <td>{{ $value->description}}</td>
                                                    <td>{{ $value->account_name}}</td>
                                                    <td>{{ $value->name}}</td>
                                                    <td>{{ $value->type}}</td>
                                                    <td>{{ $value->date_added}}  </td>
                                                    <td>{{ $value->loss_amount}}</td>
                                                    <td>
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('forex/losses/delete/'.$value->LId) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>

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

			</div>
            <div class="modal fade" id="lossModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Register a new loss</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('forex/losses/add') }}" method="POST"name="myForm"  class="needs-validation"  onsubmit="return validateForm()" >
                            <div class="modal-body">

                                    @csrf

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="mb-3">
                                                <label for="reff" class="form-label">Reff number</label>
                                                <input type="text" id="reff" class="form-control" name="reff_number" value="{{old('reff_number')}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="account_id" class="form-label">Account</label>

                                                <select id="account_id"  class="form-control" name="account_id"  >
                                                    <option value="">Not applicable</option>
                                                    @foreach($accounts as $item)
                                                        <option value="{{$item->actId}}">{{$item->account_name.'  ('.$item->currency_name.')'}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <input type="text" id="description"  class="form-control" name="description"  value="{{old('description')}}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="loss_amount" class="form-label">Amount {{$mycur}}</label>
                                                <input type="text" id="loss_amount" class="form-control" name="loss_amount" value="{{old('loss_amount')}}">
                                            </div>
                                            <div class="mb-3">
                                                <select name="type" id="type"  class="form-control" required>
                                                    <option value="">Select loss type</option>
                                                    <option value="Transaction loss">Transaction loss</option>
                                                    <option value="Transfer loss">Transfer loss</option>
                                                    <option value="Other">Other</option>
                                                </select>

                                            </div>
                                        </div> <!-- end col -->

                                    </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
 @endsection
