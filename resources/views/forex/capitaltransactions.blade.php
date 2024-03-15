@extends('forex.layouts.tableLayout')
@section('title',''.$appName.' | Capital Transactions')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Capital Transactions</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Transactions Table</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Capital Transactions list</h6>
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
                                                    <th>Currency</th>
                                                    <th>Total Amount UGX</th>
                                                    <th>Ex Amount</th>
                                                    <th>Description</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->reff_number}}</td>
                                                    <td>{{ $value->account_name}}</td>
                                                    <td>{{ $value->currency_name}}</td>
                                                    <td>@money($value->total_amount)</td>
                                                    <td>@money($value->foreign_amount)</td>
                                                    <td>{{$value->Description}}</td>
                                                    <td>{{ $value->date_added}}</td>
                                                    <td>{{ $value->trans_type}}</td>
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
