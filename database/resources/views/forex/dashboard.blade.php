
@extends('forex.layouts.mainLayout')
@section('title',''.$appName.' | Dashboard')
@section('content')
    <!--end header -->
		<!--start page wrapper -->

			<div class="page-content">


                <div class="card radius-10">
					<div class="card-content">
						<div class="row row-group row-cols-1 row-cols-xl-4">
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Accounts</p>
											<h6 class="mb-0 text-primary">{{$TotalAcounts}}</h6>
										</div>
										<div class="ms-auto"><i class="bx bx-cabinet font-35 text-primary"></i>
										</div>
									</div>

									<p class="mb-0 font-13">+Entered</p>
								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Credit</p>
											<h6 class="mb-0 text-danger">@money($TotalCreditsales)</h6>
										</div>
										<div class="ms-auto"><i class="bx bx-wallet font-35 text-danger"></i>
										</div>
									</div>

									<p class="mb-0 font-13">{{$mycur}} Sales</p>
								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Cash</p>
											<h6 class="mb-0 text-success">@money($TotalCashsales)</h6>
										</div>
										<div class="ms-auto"><i class="bx bx-money font-35 text-success"></i>
										</div>
									</div>

									<p class="mb-0 font-13">{{$mycur}} Sales</p>
								</div>
							</div>
							<div class="col">
								<div class="card-body">
									<div class="d-flex align-items-center">
										<div>
											<p class="mb-0">Total Revenue</p>
											<h6 class="mb-0 text-warning">@money($Totalsales)</h6>
										</div>
										<div class="ms-auto"><i class="bx bx-line-chart-down font-35 text-warning"></i>
										</div>
									</div>

									<p class="mb-0 font-13">{{$mycur}} Collected</p>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="row">
                   <div class="col-12 col-lg-12">
                      <div class="card radius-10">
						  <div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Monthly Sales Overview</h6>
								</div>

							</div>
							<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
								<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1 text-info"></i>Downloads</span>
								<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1 text-danger"></i>Earnings</span>
							</div>
							<div class="">
                                <canvas id="canvas" height="60%" width="100%"></canvas>
                              </div>
						  </div>
						  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-0 row-group text-center border-top">
							<div class="col">
							  <div class="p-3">
								<h4 class="mb-0">@money($TotalsalesDaily){{$mycur}}</h4>
								<small class="mb-0">Today's Sales </small>
							  </div>
							</div>
							<div class="col">
							  <div class="p-3">
								<h4 class="mb-0">@money($TotalsalesWeekly){{$mycur}}</h4>
								<small class="mb-0">This Week Sales </small>
							  </div>
							</div>
							<div class="col">
							  <div class="p-3">
								<h4 class="mb-0">@money($TotalsalesMonthly){{$mycur}}</h4>
								<small class="mb-0">This Month Sales</small>
							  </div>
							</div>
							<div class="col">
								<div class="p-3">
								  <h4 class="mb-0">@money($TotalsalesYearly){{$mycur}}</h4>
								  <small class="mb-0">This Year Sales</small>
								</div>
							  </div>
						  </div>
					  </div>
				   </div>
				</div><!--end row-->

				<div class="row">
					<div class="col-12 col-lg-6">
						<div class="card radius-10">
							<div class="card-body">
							 <div class="d-flex align-items-center">
								 <div>
									 <h6 class="mb-0">Daily Sales</h6>
								 </div>

							 </div>
                             <div class="">
                                <canvas id="canvas2" height="70%" width="100%"></canvas>
                              </div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6">
						<div class="card radius-10">
							<div class="card-body">
							 <div class="d-flex align-items-center">
								 <div>
									 <h6 class="mb-0">Daily expenses</h6>
								 </div>

							 </div>
                             <div class="">
                                <canvas id="canvas3" height="70%" width="100%"></canvas>
                              </div>
							</div>
						</div>
					</div>
				</div><!--end row-->






					<div class="row">
						<div class="col-12 col-lg-7 col-xl-6 d-flex">
						  <div class="card radius-10 w-100">
							<div class="card-header bg-transparent">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Sales by Currency</h6>
									</div>

								</div>
							   </div>
							 <div class="card-body">

                                @if(count($TotalsalesByCur)>0)
                                @foreach($TotalsalesByCur as $cur)
                                @php($x = $cur->totalamount/$Totalsales )
                                @php($y = 100*$x )

								<p><span class="text-info strong">{{ $cur->currency_name}}</span> {{ $cur->currency_country}} <span class="float-end">@money($cur->totalamount) {{$mycur}}</span></p>
								 <div class="progress" style="height: 5px;">
										<div class="progress-bar bg-info" role="progressbar" style="width: {{$y}}%"></div>
									</div>
                                    <hr>

                                    @endforeach
                                    @endif

							 </div>
						   </div>
						</div>

						<div class="col-12 col-lg-5 col-xl-6 d-flex">
							<div class="card w-100 radius-10">
							 <div class="card-header bg-transparent">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Total sales by Accounts</h6>
									</div>

								</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table align-items-center table-flush align-middle">
										 <thead>
										  <tr>
											<th>No</th>
											<th>Account Name</th>
											<th>Acct No</th>
											<th>Amount</th>
										  </tr>
										  </thead>

                                          @if(count($TotalsalesByAcct)>0)
                                          @php($i=1)
                                          @foreach($TotalsalesByAcct as $value)
										  <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $value->account_name}}</td>
                                            <td>{{ $value->account_number}}</td>
											<td>@money($value->totalamount)</td>
										  </tr>
                                          @endforeach
                                          @endif
										</table>
									 </div>
 {{$TotalsalesByAcct->links('vendor.pagination.bootstrap-4') }}
								</div>
							</div>

						</div>
					 </div><!--end row-->



			</div>

		<!--end page wrapper -->
		<!--start overlay-->

        <script>
            var gmonth = JSON.parse(`<?php echo $month; ?>`);
            var gsales = JSON.parse(`<?php echo $amount; ?>`);
            var barChartData = {
                labels: gmonth,
                datasets: [{
                    label: 'Total Monthly sales',
                    backgroundColor: "#008CFF",
                    data: gsales
                }]
            };

                    var gmonth2 = JSON.parse(`<?php echo $dmonth; ?>`);
            var gsales2 = JSON.parse(`<?php echo $damount; ?>`);
            var barChartData2 = {
                labels: gmonth2,
                datasets: [{
                    label: 'Daily sales',
                    backgroundColor: "#15CA20",
                    data: gsales2
                }]
            };

            var gmonth3 = JSON.parse(`<?php echo $emonth; ?>`);
    var gsales3 = JSON.parse(`<?php echo $eamount; ?>`);
    var barChartData3 = {
        labels: gmonth3,
        datasets: [{
            label: 'Daily Expenses',
            backgroundColor: "#5C52B2",
            data: gsales3
        }]
    };

//----------------------------------------------------------------------------
            window.onload = function() {
                var ctx = document.getElementById("canvas").getContext("2d");
                window.myBar = new Chart(ctx, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 2,
                                borderColor: '#c1c1c1',
                                borderSkipped: 'bottom'
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                });

//----------------------------------------------------------------------------------------------------

                var ctx2 = document.getElementById("canvas2").getContext("2d");
        window.myBar2 = new Chart(ctx2, {
            type: 'line',
            data: barChartData2,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Days'
                }
            }
        });
//--------------------------------------------------------
var ctx3 = document.getElementById("canvas3").getContext("2d");
        window.myBar3 = new Chart(ctx3, {
            type: 'line',
            data: barChartData3,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Days'
                }
            }
        });


            };
        </script>
	<!--end wrapper-->
	 
	<!--start switcher-->
    @endsection
