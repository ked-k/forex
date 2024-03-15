@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Payments')
@section('content')
			<div class="page-content">

                <div class="card radius-10">
					<div class="card-content">
						<div class="row row-group row-cols-1 row-cols-xl-4">
                            <div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0"><b>Customer:</b>{{$customer->cust_name}}</p>
											<h6 class="mb-0 text-warning"><b>Balance:</b>@money($customer->balance)</h6>
										</div>
										
									</div>

									<p class="mb-0 font-13"> <strong>Email:</strong>{{$customer->email}} <b>Contact:</b> {{$customer->contact}}</p>
								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total credits Received</p>
											<h4 class="mb-0 text-primary">@money($received)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-cart font-35 text-primary"></i>
										</div>
									</div>

									<p class="mb-0 font-13">Payments</p>
								</div>
							</div>
			
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Customer Credits</p>
											<h4 class="mb-0 text-warning">@money($credits)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-line-chart-down font-35 text-warning"></i>
										</div>
									</div>

									<p class="mb-0 font-13">Given</p>
								</div>
							</div>

                            <div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Customer Sales</p>
											<h4 class="mb-0 text-success">@money($cash)</h4>
										</div>
										<div class="ms-auto"><i class="bx bx-line-chart-down font-35 text-success"></i>
										</div>
									</div>

									<p class="mb-0 font-13">Made</p>
								</div>
							</div>
						
						</div>
					</div>
				</div>
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Done Payments</div>

					<div class="ms-auto">
                        <a class="btn btn-primary" href="{{url('forex/customers/transactions/'.$customer->id)}}">Customer Sales Transactions</a>
                        <div class="dropdown btn-group d-none">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Payment Options
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated">

                                <a class="dropdown-item" href="{{url('forex/customers/transactions/'.$customer->id)}}">Customer Transaction</a>
                                 <a class="dropdown-item" href="{{url('forex/customers/show/'.$customer->id)}}"></i>Customer Payments</a>

                            </div>
                        </div>
					</div>
				</div>
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
                                                    <th>Refference</th>
                                                    <th>From Account</th>
                                                    <th>Paid to</th>
                                                    <th>User</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
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
                                                    <td>{{ $value->from_acct}}</td>
                                                    <td>{{ $value->to_name}}</td>
                                                    <td>{{ $value->name}}</td>
                                                    <td>{{ $value->date_added}}</td>
                                                    <td>{{ $value->type}}</td>
                                                    <td>@money($value->total_amount)</td>
													<td class="table-action">
                                                        <a href="javascript: void(0);" class="icon"> <i class="bx bx-trash" data-bs-toggle="modal" data-bs-target="#AccountModal{{ $value->reff_number}}"></i></a>

                                                           <!-- Edit Modal -->
                                                           <div class="modal fade" id="AccountModal{{$value->reff_number}}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete ({{$value->from_acct}}) payment Transaction</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ url('forex/payments/delete') }}" method="POST">
                                                                        <div class="modal-body">

                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
                                                                                        <div class="mb-3">
                                                                                            <label for="account_name" class="form-label">Account</label>
                                                                                            <input type="text"  name="account_name" value="{{ $value->to_name}}" class="form-control"  required readonly>
                                                                                            <input type="hidden"  name="to_acct" value="{{ $value->to_acct}}" class="form-control"  required readonly>
                                                                                            <input type="hidden"  name="customer_id" value="{{ $value->from_id}}" class="form-control"  required readonly>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="account_number" class="form-label">Transaction Number</label>
                                                                                            <input type="text"  name="reff_number" value="{{ $value->reff_number}}"  class="form-control"  required readonly>
                                                                                        </div>
                                                                                        <div class="col-xs-6">
                                                                                            <div class="mb-3">
                                                                                                <label for="amount" class="form-label">Total Amount(UGX) </label>
                                                                                                <input type="text"  name="total_amount" value="{{ $value->total_amount}}"  class="form-control"  required readonly>
                                                                                            </div>
                                                                                        </div>                                                                                    
                                                                                     

                                                                                    </div> <!-- end col -->

                                                                                </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this transaction?');" class="btn btn-danger">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
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

			</div>

 @endsection
