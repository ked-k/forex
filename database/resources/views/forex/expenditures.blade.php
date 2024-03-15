@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Expenditures')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Expenditures</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Expenditure Table</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ExpenseModal">Add a new Expense</button>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Expenditures list</h6>
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
                                                    <th>Account</th>
                                                    <th>Description</th>
                                                    <th>User</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->reff_number}}</td>
                                                    <td>{{$value->account_name !='' ?$value->account_name:'From Transaction account'}} {{'  ('.$value->currency_name.')'}}</td>
                                                    <td>{{ $value->description}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{ $value->date_added}}</td>
                                                    <td>{{ $value->type}}</td>
                                                    <td class="text-end">@money($value->exp_amount) <input type="hidden" value="{{$value->exp_amount}}" name="amount"></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>

                                        </table>
                                    </div>
                                    <p class="text-end text-primary mt-4">Total Expenditures: <strong><span id="totalamount"></span></strong></p>
                                </div>
                            </div>

                        </div>
                    </div>

			</div>
            @include("forex.modals.newExpenditure")
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
 @endsection
