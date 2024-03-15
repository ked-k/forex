@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Accounts')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Accounts</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Accounts Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AccountModal">Add a new Account</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Account list</h6>
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
                                                    <th>Acconut Name</th>
                                                    <th>Acconut NO.</th>
                                                    <th>Currency</th>
                                                    <th>Account Type</th>
                                                     <th>Buying</th>
                                                    <th>Selling</th>
                                                    <th>Actual balance</th>

                                                    <th class="text-end">Balance({{$mycur}})</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->account_name}}</td>
                                                    <td>{{ $value->account_number}}</td>
                                                    <td>{{ $value->currency_name}}</td>
                                                    <td>{{ $value->account_type}}</td>
                                                    <td>{{ $value->buying_rate}}</td>
                                                    <td>{{ $value->selling_rate}}</td>
                                                    <td>
                                                     @php($x=$value->available_balance/$value->buying_rate)
                                                      @money($x)</td>
                                                    <td class="text-end">@money($value->available_balance) <input type="hidden" value="{{$value->available_balance}}" name="amount"></td>
                                                    <td class="table-action">
                                                        @if($value->is_active==1)
                                                        <span class="badge bg-success">Active</span>
                                                        @php($satate='Active' AND $Stvalue=1)
                                                        @elseif($value->is_active==0)
                                                        <span class="badge bg-danger">InActive</span>
                                                        @php($satate='InActive' AND $Stvalue=0)
                                                        @endif
                                                        <a href="javascript: void(0);" class="icon"> <i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#AccountModal{{ $value->actId }}"></i></a>
                                                        @role('superadministrator')
                                                        <a onclick="return confirm('Are you sure you want to delete?');" href="{{ url('forex/accounts/delete/'.$value->actId) }}"  data-toggle="tooltip" title="Delete!" class="action-icon"> <i class="bx bx-trash"></i></a>
                                                        @endrole
                                                           <!-- Edit Modal -->
                                                           <div class="modal fade" id="AccountModal{{$value->actId}}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Create a Customer</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ url('forex/accounts/update/'.$value->actId) }}" method="POST">
                                                                        <div class="modal-body">

                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
                                                                                        <div class="mb-3">
                                                                                            <label for="account_name" class="form-label">account_name</label>
                                                                                            <input type="text" id="account_name" name="account_name" value="{{ $value->account_name}}" class="form-control"  required>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="account_type" class="form-label">Account Type</label>
                                                                                            <select name="account_type" class="form-control" id="account_type">
                                                                                                <option value="{{ $value->account_type}}">{{ $value->account_type}} Account</option>
                                                                                                <option value="Bank">Bank Account</option>
                                                                                                <option value="Cash">Cash Account</option>
                                                                                                <option value="Line">Line Account</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="account_number" class="form-label">Account Number</label>
                                                                                            <input type="text" id="account_number" name="account_number" value="{{ $value->account_number}}"  class="form-control"  required>
                                                                                        </div>

                                                                                        <div class="mb-3 d-none">
                                                                                            <label class="form-label">Select Currency</label>
                                                                                            <div class="input-group">
                                                                                                <select class="single-select form-select" name="default_currency" required>
                                                                                                    <option selected value="{{$value->default_currency}}">{{$value->currency_name}}</option>
                                                                                                    @if(count($currencies)>0)
                                                                                                @foreach($currencies as $cur)
                                                                                                    <option value="{{ $cur->id}}">{{ $cur->currency_name}}</option>
                                                                                                @endforeach
                                                                                                @endif
                                                                                                </select>
                                                                                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class='bx bx-add'></i>New
                                                                                                </button>
                                                                                            </div>
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

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                                    <p class="text-end text-primary mt-4">Total Amount: <strong><span id="totalamount"></span></strong></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    @include("forex.modals.newcurrency")
                    @include("forex.modals.newAccount")
                    <script type="text/javascript">

                        window.sumInputs = function() {
                            var inputs = document.getElementsByName('amount'),

                                sum = 0;

                            for(var i=0; i<inputs.length; i++) {
                                var ip = inputs[i];

                                if (ip.name && ip.name.indexOf("total") < 0) {
                                    sum += parseFloat(ip.value) || 0;
                                }

                            }


                            var ked = sum;
                          var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        document.getElementById('totalamount').innerHTML = num;

                        }
                        sumInputs();
                        </script>
			</div>
 @endsection
