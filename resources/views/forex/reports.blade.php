@extends('forex.layouts.formLayout')
@section('title', 'Reports')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Reports</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Reports</li>
							</ol>
						</nav>
					</div>

				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Reports</h6>
				<hr/>
                    <div class="row">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">

                                        <div class="list-group nav-tabs" id="list-tab" role="tablist">

                                            <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" href="#dailysales" role="tab" aria-selected="true">
                                                <i class='bx bx-file font-18 me-1'></i>Daily sale</a>
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#dailysales" role="tab" aria-selected="true">
                                                    <i class='bx bx-file font-18 me-1'></i>Daily Purchase</a>
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#stockpurchase" role="tab" aria-selected="true">
                                                    <i class='bx bx-file font-18 me-1'></i>Purchase List</a>
                                                    <a class="list-group-item list-group-item-action " data-bs-toggle="tab" href="#sales" role="tab" aria-selected="true">
                                                        <i class='bx bx-file font-18 me-1'></i>Sales List</a>
                                                    <a class="list-group-item list-group-item-action " data-bs-toggle="tab" href="#profitMargin" role="tab" aria-selected="true">
                                                     <i class='bx bx-file font-18 me-1'></i>Profit/Loss</a>
                                                
                                                    <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#customer" role="tab" aria-selected="true">
                                                        <i class='bx bx-file font-18 me-1'></i>Customer</a>
                                                    <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#supppurchase" role="tab" aria-selected="true">
                                                            <i class='bx bx-file font-18 me-1'></i>Supplier</a>
                                                        
                                                <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#expense" role="tab" aria-selected="true">
                                                    <i class='bx bx-file font-18 me-1'></i>Expenditure</a>

                                        </div>
                                      </div>
                                  <div class="col-8">
                                    <div class="tab-content" id="nav-tabContent">

                                        @include('forex.reports.sales')
                                        @include('forex.reports.profitMargin')
                                        @include('forex.reports.DailySales')
                                        @include('forex.reports.stockpurchase')
                                        @include('forex.reports.customer')
                                        @include('forex.reports.expenses')
                                        @include('forex.reports.supplierpurchase')
                                 </div>
                                  </div>
                                </div>
                              </div>

                        </div>
                    </div>



			</div>
 @endsection
