@extends('forex.layouts.formLayout')
@section('title',''.$appName.' | New Payment')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Payment</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Payment</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">New Payment</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-header pt-0">
                                    <form method="POST" action="{{ url('forex/payments/add/m') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                       @csrf
                                        <div class="row mb-2 mt-3">
                                            <input type="hidden" class="form-control" name="reff_number"  readonly value="{{ rand(8960,765555).time() }}">
                                             <div class="col-sm-5">
                                                 <div class="text-sm">
                                                 <label>From</label>
                                                 <select class="single-select form-select" name="from_id" id="from_id" required >
                                                     <option>Select Account</option>
                                                     @foreach($accounts as $item)
                                                         <option value="{{$item->actId}}">{{$item->account_name.'  ('.$item->currency_name.')'}}</option>
                                                         @endforeach
                                                 </select>
                                                 </div>
                                                 <input type="hidden" readonly  class="form-control"  name="from_acct" id="from_acct" required>
                                             </div><!-- end col-->

                                             <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Amount available (UGX)</label>
                                                    <input type="text" readonly value="0" class="form-control"  name="avamount" id="avamount" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="text-sm">
                                                <label>To supplier</label>
                                                <select class="single-select form-select" name="to_acct" id="to_id" required >
                                                    <option value="">Select Suppliert</option>
                                                    @foreach($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->sup_name.'  ('.$supplier->balance.')'}}</option>
                                                        @endforeach
                                                </select>
                                                </div>
                                                <input type="hidden" readonly  class="form-control"  name="to_name" id="to_acct" required>

                                            </div>



                                            <script>
                                                $(document).ready(function(){
                                                $('#from_id').change(function() {

                                                    var acct1 = $(this).val();

                                                    document.getElementById('avamount').value =0;
                                                    document.getElementById('from_acct').value ="";
                                                    // $("#supplier").empty();
                                                    if (acct1) {
                                                        $.ajax({
                                                            type: "GET",
                                                            url: "{{ url('forex/transfer/getAcct1') }}?act_id=" + acct1,
                                                            success: function(response) {

                                                                var len = 0;
                                                     if(response['data'] != null){
                                                       len = response['data'].length;
                                                     }

                                                     if(len > 0){
                                                       // Read data and create <option >
                                                       for(var i=0; i<len; i++){

                                                         var acct1 = response['data'][i].account_number;
                                                        var exrate =  response['data'][i].usd_exrate;
                                                        var balance =  response['data'][i].available_balance;
                                                        var urate1 = balance*exrate;

                                                        document.getElementById('avamount').value =balance;
                                                        document.getElementById('total_amount').value =0;
                                                        document.getElementById('from_acct').value =acct1;


                                                       }
                                                     }
                                                            }
                                                        });
                                                    } else {
                                                        document.getElementById('avamount').value =0;
                                                    document.getElementById('total_amount').value =0;
                                                    document.getElementById('from_acct').value ="";
                                                    }
                                                });
                                            });
                                            </script>
                                        </div>


                                        <div class="row mb-2 mt-3">
                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label> Amount Required</label>
                                                    <input type="text" class="form-control" id="initial_amount" readonly required name="initial_amount">
                                                </div>
                                            </div><!-- end col-->
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Amount to pay</label>
                                                     <input type="text" class="form-control" onchange="fill()" value="0" min="0" required name="total_amount" id="total_amount">
                                                 </div>
                                             </div><!-- end col-->
                                             <div class="col-sm-2">
                                                 <div class="text-sm">
                                                     <label>Balance</label>
                                                     <input type="text" readonly required class="form-control" name="ex_amount" id="ex_amount">
                                                 </div>
                                             </div>
                                             <div class="col-sm-2">
                                                <div class="text-sm">
                                                    <label>Date</label>
                                                    <input type="date" required class="form-control" value="{{date('Y-m-d')}}" name="date_added" id="date_added">
                                                </div>
                                            </div>

                                             <div class="col-sm-2">
                                                 <div class="text-sm-end pt-2">
                                                     <button type="submit" class="btn btn-primary mb-2 me-1 d-block">Save Payment</button>
                                                 </div>
                                             </div><!-- end col-->
                                          </div>
                                          <script>
                                            $(document).ready(function(){
                                            $('#to_id').change(function() {

                                                var acct2 = $(this).val();

                                               // document.getElementById('avamount').value =0;
                                               // document.getElementById('total_amount').value =0;
                                                document.getElementById('to_acct').value ="";
                                                document.getElementById('initial_amount').value =0;
                                                // $("#supplier").empty();
                                                if (acct2) {
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{ url('forex/payments/getSupp') }}?sup_id=" + acct2,
                                                        success: function(response) {

                                                            var len = 0;
                                                 if(response['data'] != null){
                                                   len = response['data'].length;
                                                 }

                                                 if(len > 0){
                                                   // Read data and create <option >
                                                   for(var i=0; i<len; i++){

                                                     var sup = response['data'][i].sup_name;
                                                    var balance =  response['data'][i].balance;


                                                    document.getElementById('initial_amount').value =balance;
                                                    document.getElementById('to_acct').value =sup;


                                                   }
                                                 }
                                                        }
                                                    });
                                                } else {
                                                document.getElementById('initial_amount').value =0;
                                                document.getElementById('to_acct').value ="";
                                                }
                                            });
                                        });
                                        </script>
                                         </form>

                                     </div>


                            </div>

                        </div>
                    </div>
                    <script>

                        function fill() {

                            var tamt1 = document.getElementById("initial_amount").value-0;
                            var tamt2 = document.getElementById("total_amount").value-0;

                             document.getElementById("ex_amount").value = tamt1-tamt2;


                        }

                    </script>


<script>


    function validateForm() {

     var q1 = document.forms["myForm"]["total_amount"].value-0;
     var q2 = document.forms["myForm"]["initial_amount"].value-0;
     var q3 = document.forms["myForm"]["avamount"].value-0;
     var stm = 'Amount on hand is: ' +q3+ ' and  requested required is: ' +q1;
     var ex = document.getElementById("ex_amount").value;



 if (q1 > q3) {

  //  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
  swal('Error','You do not have enough amount, ' + stm + '!', 'warning');
    return false;
  }
   else if (q1 > q2) {
   swal('Error', 'The paid amount can not exceed the loan amount !', 'warning');
    return false;
  }

  else if (isNaN(ex)){
   swal('Error', 'Invalid Amount !', 'warning');
    return false;
  }

  else if (ex=="Infinity"){
   swal('Error', 'Invalid Amount, or enter charges !', 'warning');
    return false;
  }
  else if (ex < 0) {
   swal('Error', 'You cant not have a negative balance!', 'warning');
    return false;
  }
  else if (q1 < 1) {
   swal('Error', 'You cant make a 0 amount payment!', 'warning');
    return false;
  }
  else{
    return true;
  }

}
                   </script>

			</div>

 @endsection
