@extends('forex.layouts.formLayout')
@section('title',''.$appName.' | New Transfers')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Transfers</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Transfer</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">New Transfer</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-header pt-0">
                                    <form method="POST" action="{{ url('forex/transfer/add') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                       @csrf
                                        <div class="row mb-2 mt-3">
                                            <input type="hidden" class="form-control" name="reff_number"  readonly value="{{ $code }}">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="form-label">Select Currency</label>
                                                    <div class="input-group">
                                                        <select class="single-select form-select" name="currency" id="currency" required>
                                                            <option value="">Select</option>
                                                            @if(count($currencies)>0)
                                                        @foreach($currencies as $cur)
                                                            <option value="{{$cur->id}}">{{ $cur->currency_name}}</option>
                                                        @endforeach
                                                        @endif
                                                        </select>
                                                        <input type="text" placeholder="Selling rate"  class="form-control" readonly  name="rate" id="rate" required>
                                                        <input type="hidden" placeholder="Selling rate"  class="form-control"  name="rate2" id="rate2" required>
                                                    </div>
                                                    <script>
                                                        $(document).ready(function(){
                                                        $('#currency').change(function() {

                                                            var curId = $(this).val();

                                                            document.getElementById('avamount').value =0;
                                                           // document.getElementById('total_amount').value =0;
                                                            document.getElementById('rate').value ="";
                                                            document.getElementById('rate2').value ="";
                                                             $("#from_id").empty();
                                                             $("#from_id").append('<option value="">Select a sending account</option>');
                                                             $("#to_id").empty();
                                                             $("#to_id").append('<option value="">Select a receiving account</option>');

                                                            if (curId) {
                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: "{{ url('forex/transactions/getAccts') }}?cur_id=" + curId,
                                                                    success: function(response) {

                                                                        var len = 0;
                                                             if(response['data'] != null){
                                                               len = response['data'].length;
                                                             }

                                                             if(len > 0){
                                                               // Read data and create <option >
                                                               for(var i=0; i<len; i++){

                                                                 var acctid = response['data'][i].Aid;
                                                                var salerate =  response['data'][i].buyrate;
                                                                var acctname = response['data'][i].account_name;
                                                                var options = "<option value='"+acctid+"'>"+acctname+"</option>";
                                                                 $("#from_id").append(options);
                                                                 $("#to_id").append(options);
                                                                document.getElementById('rate').value =salerate;
                                                                document.getElementById('rate2').value =salerate;

                                                               }
                                                             }
                                                                    }
                                                                });
                                                            } else {
                                                                document.getElementById('rate').value ="";
                                                            document.getElementById('rate2').value ="";
                                                            }
                                                        });
                                                    });
                                                    </script>

                                                </div>

                                            </div>
                                             <div class="col-sm-5">
                                                 <div class="text-sm">
                                                 <label>Sending Account</label>
                                                 <select class="single-select form-select" name="from_id" id="from_id" required >
                                                     <option>Select Account</option>
                                                     @foreach($accounts as $item)
                                                         <option value="{{$item->actId}}">{{$item->account_name.'  ('.$item->currency_name.')'}}</option>
                                                         @endforeach
                                                 </select>
                                                 </div>
                                                 <input type="hidden" readonly  class="form-control"  name="from_acct" id="from_acct" required>
                                             </div><!-- end col-->

                                             <div class="col-sm-4">
                                                <div class="text-sm">
                                                    <label>Amount available (UGX)</label>
                                                    <input type="text" readonly value="0" class="form-control"  name="avamount" id="avamount" required>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label> Trans Amount (Foreign)</label>
                                                    <input type="text" class="form-control" id="initial_amount" onchange="fillme()"  required name="ex_amount">
                                                </div>
                                            </div><!-- end col-->

                                            <script>
                                                $(document).ready(function(){
                                                $('#from_id').change(function() {

                                                    var acct1 = $(this).val();

                                                    document.getElementById('avamount').value =0;
                                                    document.getElementById('initial_amount').value =0;
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
                                                        document.getElementById('from_acct').value =acct1;


                                                       }
                                                     }
                                                            }
                                                        });
                                                    } else {
                                                        document.getElementById('avamount').value =0;
                                                    document.getElementById('from_acct').value ="";
                                                    }
                                                });
                                            });
                                            </script>
                                        </div>


                                        <div class="row mb-2 mt-3">
                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                <label>Receiving Account</label>
                                                <select class="single-select form-select" name="to_id" id="to_id" required >
                                                    <option value="">Select Account</option>
                                                    @foreach($accounts as $item)
                                                        <option value="{{$item->actId}}">{{$item->account_name.'  ('.$item->currency_name.')'}}</option>
                                                        @endforeach
                                                </select>
                                                </div>
                                                <input type="hidden" readonly  class="form-control"  name="to_acct" id="to_acct" required>
                                                <input type="hidden" readonly  class="form-control" value="1"  name="exrate2" id="exrate2" required>
                                            </div>
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Total Amount</label>
                                                     <input type="text" class="form-control"  value="0"  required name="total_amount" id="total_amount">
                                                 </div>
                                             </div><!-- end col-->

                                             <div class="col-sm-2">
                                                <div class="text-sm">
                                                    <label>Charges</label>
                                                    <input type="text" class="form-control" onchange="fillme()" value="0" min="0" required name="trans_charges" id="trans_charges">
                                                </div>
                                            </div><!-- end col-->
                                               <div class="col-sm-2">
                                                <div class="text-sm">
                                                    <label>Date</label>
                                                    <input type="date" required class="form-control" name="date_added" id="date_added">
                                                </div>
                                            </div>
                                             <div class="col-sm-2">
                                                 <div class="text-sm-end mt-2">
                                                     <button type="submit" {{$bstate}} class="btn btn-primary mb-2 me-1 d-block">Save Tranfer</button>
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
                                                document.getElementById('exrate2').value =0;
                                                // $("#supplier").empty();
                                                if (acct2) {
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{ url('forex/transfer/getAcct2') }}?act_id=" + acct2,
                                                        success: function(response) {

                                                            var len = 0;
                                                 if(response['data'] != null){
                                                   len = response['data'].length;
                                                 }

                                                 if(len > 0){
                                                   // Read data and create <option >
                                                   for(var i=0; i<len; i++){

                                                     var acct2 = response['data'][i].account_number;
                                                    var exrate2 =  response['data'][i].usd_exrate;


                                                    document.getElementById('exrate2').value =exrate2;
                                                    document.getElementById('to_acct').value =acct2;


                                                   }
                                                 }
                                                        }
                                                    });
                                                } else {
                                                    document.getElementById('exrate2').value =0;
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

                        function fillme() {

                            var tamt1 = document.getElementById("initial_amount").value-0;
                             var tcharges = document.getElementById("trans_charges").value-0;
                             var trate = document.getElementById("rate").value-0;

                             var tt = tamt1 + tcharges  ;
                             var mytotal = tt * trate;
                             document.getElementById("total_amount").value = mytotal.toFixed(2);

                        }

                    </script>


<script>


    function validateForm() {

     var q1 = document.forms["myForm"]["avamount"].value-0;
     var q2 = document.forms["myForm"]["initial_amount"].value-0;
     var stm = 'Amount on hand is: ' +q1+ ' and  requested required is: ' +q2;
     var z = document.getElementById("total_amount").value;
     var act1 = document.getElementById("to_id").value;
     var act2 = document.getElementById("from_id").value;


 if (q2 > q1) {

  //  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
  swal('Error','You do not have enough amount, ' + stm + '!', 'warning');
    return false;
  }
   else if (z < 1) {
   swal('Error', 'Total transfer amount must be greater than 0 !', 'warning');
    return false;
  }
  else if (isNaN(z)){
   swal('Error', 'Invalid Amount !', 'warning');
    return false;
  }

  else if (z=="Infinity"){
   swal('Error', 'Invalid Amount, or enter charges !', 'warning');
    return false;
  }

  else if (act1 == act2) {
   swal('Error', 'You cant not transfer money to similar accounts, Please choose different two accounts!', 'warning');
    return false;
  }
  else{
    return true;
  }

}
                   </script>

			</div>
            @include("forex.modals.newAccount")
 @endsection
