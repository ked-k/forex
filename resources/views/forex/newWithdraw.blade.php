@extends('forex.layouts.formLayout')
@section('title',''.$appName.' | New Withdraw')
@section('content')
			<div class="page-content">
                    		<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">New Withdraw</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Withdraw</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Add New Withdraw</h6>
				<hr/>
                    <div class="row">
                        <div>
                            <div class="card">
                                <div class="card-header pt-0">
                                    <form method="POST" action="{{ url('forex/capital/withdraw/add') }}" name="myForm"  class="needs-validation"  onsubmit="return validateForm()">
                                       @csrf
                                        <div class="row mb-2 mt-3">

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
                                                    <input type="text" placeholder="Selling rate"  class="form-control"  name="rate" id="rate" required onchange="fill3()">
                                                    <input type="hidden" placeholder="Selling rate"  class="form-control"  name="rate2" id="rate2" required>
                                                </div>
                                                <script>
                                                    $(document).ready(function(){
                                                    $('#currency').change(function() {

                                                        var curId = $(this).val();

                                                       document.getElementById('mycharges').value =0;
                                                       document.getElementById('total_foreign').value =0;
                                                       document.getElementById('initial_amount').value =0;
                                                       document.getElementById('total_amount').value =0;
                                                        document.getElementById('rate').value ="";
                                                        document.getElementById('rate2').value ="";
                                                         $("#to_id").empty();
                                                         $("#to_id").append('<option value="">Select An account</option>');

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
                                        <div class="row mb-2 mt-3">



                                            <div class="col-sm-4">
                                                <div class="text-sm">
                                                <label>Paying Account</label>
                                                <select class="single-select form-select" name="account" id="to_id" required>
                                                    <option value="">Select Account</option>
                                                    @foreach($accounts as $item)
                                                        <option value="{{$item->actId}}">{{$item->account_name.'  ('.$item->currency_name.')'}}</option>
                                                        @endforeach
                                                </select>
                                                </div>
                                                <input type="hidden" readonly  class="form-control"  name="to_acct" id="to_acct" >
                                                <input type="hidden" readonly  class="form-control" value="1"  name="exrate2" id="exrate2">
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Amount available (UGX)</label>
                                                    <input type="text" readonly value="0" class="form-control"  name="avamount" id="avamount" required>
                                                </div>
                                            </div>

                                            <script>
                                                $(document).ready(function(){
                                                $('#to_id').change(function() {

                                                    var acct1 = $(this).val();
                                                    document.getElementById('avamount').value = 0;
                                                    document.getElementById("total_foreign").value = 0;
                                                    document.getElementById("initial_amount").value = 0;
                                                    document.getElementById("total_amount").value = 0;
                                                    document.getElementById('mycharges').value =0;

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


                                                       }
                                                     }
                                                            }
                                                        });
                                                    } else {
                                                        document.getElementById('avamount').value =0;
                                                    document.getElementById('total_amount').value =0;
                                                    }
                                                });
                                            });
                                            </script>

                                            <div class="col-sm-5">
                                                <div class="text-sm">
                                                    <label>Description</label>
                                                    <input type="text" class="form-control"  required name="Description" id="Description">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row mb-2 mt-3">


                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Withdraw Amount (Foreign)</label>
                                                     <input type="text" class="form-control" onchange="fill2()" value="0" min="0" required name="total_foreign" id="total_foreign">
                                                 </div>
                                             </div><!-- end col-->
                                             <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Withdraw Amount (UGX)</label>
                                                    <input type="text" class="form-control" id="initial_amount" onchange="fill()" required name="initial_amount">
                                                </div>
                                            </div><!-- end col-->
                                             <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Charges (Foreign)</label>
                                                    <input type="text" class="form-control" onchange="fill2()" value="0" min="0" required name="charges" id="mycharges">
                                                </div>
                                            </div><!-- end col-->
                                             <div class="col-sm-3">
                                                 <div class="text-sm">
                                                     <label>Total Amount (UGX)</label>
                                                     <input type="text" readonly required class="form-control" name="total_amount" id="total_amount">
                                                 </div>
                                             </div>

                                            <div class="col-sm-3">
                                                <div class="text-sm">
                                                    <label>Date</label>
                                                    <input type="date" required class="form-control" value="{{date('Y-m-d')}}" name="date_added" id="date_added">
                                                </div>
                                            </div>


                                             <div class="col-sm-3">
                                                 <div class="text-sm-end pt-2">
                                                     <button type="submit" class="btn btn-primary mb-2 me-1 d-block">Save Deposit</button>
                                                 </div>
                                             </div><!-- end col-->
                                          </div>

                                         </form>

                                     </div>


                            </div>

                        </div>
                    </div>


                    <script>

                        function fill() {

                            var myrate = document.getElementById("rate").value-0;
                            var salelocal = document.getElementById("initial_amount").value-0;
                             var saleforeign = document.getElementById("total_foreign").value-0
                             var totalforeign = salelocal / myrate;

                             document.getElementById("total_foreign").value = totalforeign.toFixed(2);
                             document.getElementById("total_amount").value = salelocal.toFixed(2);

                        }

                        function fill2() {

                        var myrate = document.getElementById("rate").value-0;
                        var salelocal = document.getElementById("initial_amount").value-0;
                        var saleforeign = document.getElementById("total_foreign").value-0
                        var mycharge = document.getElementById("mycharges").value-0

                        var totallocal1 = saleforeign + mycharge;
                        var totallocal = totallocal1 * myrate;

                        document.getElementById("initial_amount").value = totallocal.toFixed(2);
                        document.getElementById("total_amount").value = totallocal.toFixed(2);

                        }
                        function fill3() {
                         document.getElementById("total_foreign").value = 0;
                        document.getElementById("initial_amount").value = 0;
                        document.getElementById("total_amount").value = 0;
                        document.getElementById("mycharges").value = 0;
                        }

                    </script>


<script>


    function validateForm() {

    var q1 = document.forms["myForm"]["avamount"].value-0;
     var q2 = document.forms["myForm"]["total_amount"].value-0;
     var stm = 'Amount on hand is: ' +q1+ ' and  requested required is: ' +q2;

 if (q2 > q1) {

//  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
swal('Error','You do not have enough amount, ' + stm + '!', 'warning');
  return false;
}
else if (q2 < 1) {
   swal('Error', 'Total sale amount must be greater than 0 !', 'warning');
    return false;
  }
  else if (isNaN(q2)){
   swal('Error', 'Invalid Amount !', 'warning');
    return false;
  }

  else if (q2=="Infinity"){
   swal('Error', 'Invalid Amount, or enter charges !', 'warning');
    return false;
  }


  else{
    return true;
  }

}
                   </script>

			</div>

 @endsection
