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
                                                    <th>Amount Foreign</th>
                                                    <th>Rates</th>
                                                    <th class="text-end">Buying ({{$mycur}})</th>
                                                    <th class="text-end">Selling ({{$mycur}})</th>
                                                    <th class="text-end">Profit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->account_name.' ('.$value->currency_name.')'}}</td>
                                                    <td>{{ $value->account_number}}</td>
                                                    <td class="text-end">
                                                        @php($ex=$value->available_balance/$value->buying_rate)
                                                         @money($ex) ({{$value->currency_name}})</td>
                                                         <td>{{ $value->buying_rate.' : '.$value->selling_rate}}</td>
                                                    <td class="text-end">
                                                     @php($x= $ex*$value->buying_rate)
                                                      @money($x) <input type="hidden" value="{{$x}}" name="amount1"></td>
                                                      <td class="text-end">
                                                        @php($y= $ex*$value->selling_rate)
                                                         @money($y) <input type="hidden" value="{{$y}}" name="amount2"></td>
                                                    <td class="text-end">
                                                        @php($tamt = $y-$x )
                                                        @money($tamt) <input type="hidden" value="{{$tamt}}" name="amount"></td>

                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>

                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Totals:</th>
                                                        <th></th>
                                                         <th class="text-end"><span id="totalamount1"></span></th>
                                                        <th class="text-end"><span id="totalamount2"></span></th>
                                                        <th class="text-end"> <strong><span id="totalamount"></span></strong></th>

                                                    </tr>

                                            </tfoot>

                                        </table>
                                    </div>

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
                           <script type="text/javascript">

                            window.sumInputs = function() {
                                var inputs = document.getElementsByName('amount1'),

                                    sum = 0;

                                for(var i=0; i<inputs.length; i++) {
                                    var ip = inputs[i];

                                    if (ip.name && ip.name.indexOf("total") < 0) {
                                        sum += parseFloat(ip.value) || 0;
                                    }

                                }


                                var ked = sum;
                              var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                            document.getElementById('totalamount1').innerHTML = num;

                            }
                            sumInputs();
                            </script>
                               <script type="text/javascript">

                                window.sumInputs = function() {
                                    var inputs = document.getElementsByName('amount2'),

                                        sum = 0;

                                    for(var i=0; i<inputs.length; i++) {
                                        var ip = inputs[i];

                                        if (ip.name && ip.name.indexOf("total") < 0) {
                                            sum += parseFloat(ip.value) || 0;
                                        }

                                    }


                                    var ked = sum;
                                  var num = 'UGX: ' + ked.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                                document.getElementById('totalamount2').innerHTML = num;

                                }
                                sumInputs();
                                </script>
			</div>
 @endsection
