@extends('forex.layouts.formLayout')
@section('title', '' . $appName . ' | New currency sale')
@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">New Sale</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sale</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Add New Sale</h6>
        <hr />
        <div class="row">
            <div>
                <div class="card">
                    <div class="card-header pt-0">
                        <form method="POST" action="{{ url('forex/sale/add') }}" name="myForm" class="needs-validation"
                            onsubmit="return validateForm()">
                            @csrf
                            <div class="row mb-2 mt-3">
                                <input type="hidden" class="form-control" name="reff_number" readonly
                                    value="{{ $code }}">
                                <div class="col-sm-3">

                                    <label class="form-label">Sale Type</label>
                                    <select name="sale_type" id="saleType" class="form-control" required
                                        onchange="mycust()">
                                        <option selected value="Cash">Cash</option>
                                        <option value="Credit">Credit</option>
                                    </select>

                                </div>
                                <div class="col-sm-9">
                                    <label class="form-label">Select Currency</label>
                                    <div class="input-group">
                                        <select class="single-select form-select" name="currency" id="currency" required>
                                            <option value="">Select</option>
                                            @if (count($currencies) > 0)
                                                @foreach ($currencies as $cur)
                                                    <option value="{{ $cur->id }}">{{ $cur->currency_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <input type="text" placeholder="Selling rate" class="form-control" name="rate"
                                            id="rate" required onchange="fill3()">
                                        <input type="text" placeholder="buying rate" class="form-control" name="rate2"
                                            id="rate2" required readonly>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            $('#currency').change(function() {

                                                var curId = $(this).val();

                                                document.getElementById('avamount').value = 0;
                                                // document.getElementById('total_amount').value =0;
                                                document.getElementById('rate').value = "";
                                                document.getElementById('rate2').value = "";
                                                $("#from_id").empty();
                                                $("#from_id").append('<option value="">Select An account</option>');

                                                if (curId) {
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{ url('forex/transactions/getAccts') }}?cur_id=" + curId,
                                                        success: function(response) {

                                                            var len = 0;
                                                            if (response['data'] != null) {
                                                                len = response['data'].length;
                                                            }

                                                            if (len > 0) {
                                                                // Read data and create <option >
                                                                for (var i = 0; i < len; i++) {

                                                                    var acctid = response['data'][i].Aid;
                                                                    var salerate = response['data'][i].salerate;
                                                                    var buyrate = response['data'][i].buyrate;
                                                                    var acctname = response['data'][i].account_name;
                                                                    var options = "<option value='" + acctid + "'>" + acctname +
                                                                        "</option>";
                                                                    $("#from_id").append(options);
                                                                    // document.getElementById('rate').value = salerate;
                                                                    document.getElementById('rate2').value = buyrate;

                                                                }
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    document.getElementById('rate').value = "";
                                                    document.getElementById('rate2').value = "";
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="row mb-2 mt-3">
                                <div class="col-sm-4">
                                    <div class="text-sm">
                                        <label>Selling Account</label>
                                        <select class="single-select form-select" name="from_id" id="from_id" required>
                                            <option>Select Account</option>
                                            @foreach ($accounts as $item)
                                                <option value="{{ $item->actId }}">
                                                    {{ $item->account_name . '  (' . $item->currency_name . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" readonly class="form-control" name="from_acct" id="from_acct">
                                </div><!-- end col-->

                                <div class="col-sm-4">
                                    <div class="text-sm">
                                        <label>Amount available</label>
                                        <div class="input-group">
                                            <span class="input-group-text text-success">Foreign</span>
                                            <input type="text" readonly value="0" class="form-control"
                                                name="avamount" id="avamount" required>
                                            <input type="text" readonly value="0" class="form-control"
                                                name="avamountForegin" id="avamountForegin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm">
                                        <label>Receiving Account</label>
                                        <select class="single-select form-select" name="to_id" id="to_id" required>
                                            <option value="">Select Account</option>
                                            @foreach ($accounts->where('currency_name','UGX') as $item)
                                                <option value="{{ $item->actId }}">
                                                    {{ $item->account_name . '  (' . $item->currency_name . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" readonly class="form-control" name="to_acct" id="to_acct">
                                    <input type="hidden" readonly class="form-control" value="1" name="exrate2"
                                        id="exrate2" required>
                                </div>


                                <script>
                                    $(document).ready(function() {
                                        $('#from_id').change(function() {

                                            var acct1 = $(this).val();
                                            document.getElementById('avamount').value = 0;
                                            document.getElementById("total_foreign").value = 0;
                                            document.getElementById("initial_amount").value = 0;
                                            document.getElementById("total_amount").value = 0;
                                            document.getElementById('from_acct').value = "";
                                            // $("#supplier").empty();
                                            if (acct1) {
                                                $.ajax({
                                                    type: "GET",
                                                    url: "{{ url('forex/transfer/getAcct1') }}?act_id=" + acct1,
                                                    success: function(response) {

                                                        var len = 0;
                                                        if (response['data'] != null) {
                                                            len = response['data'].length;
                                                        }

                                                        if (len > 0) {
                                                            // Read data and create <option >
                                                            for (var i = 0; i < len; i++) {
                                                                var newRate = document.getElementById("rate2").value - 0;
                                                                var acct1 = response['data'][i].account_number;
                                                                var exrate = response['data'][i].usd_exrate;
                                                                var balance1 = response['data'][i].available_balance;
                                                                var actual = balance1 / newRate;
                                                                var balance = actual * exrate
                                                                var urate1 = balance * exrate;

                                                                // document.getElementById('avamountForegin').value = actual.toFixed(2);
                                                                document.getElementById('avamount').value = balance1.toFixed(2);
                                                                document.getElementById('total_amount').value = 0;
                                                                document.getElementById('from_acct').value = acct1;


                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                document.getElementById('avamount').value = 0;
                                                document.getElementById('total_amount').value = 0;
                                                document.getElementById('from_acct').value = "";
                                            }
                                        });
                                    });
                                </script>
                            </div>


                            <div class="row mb-2 mt-3">
                                <div class="col-sm-3">
                                    <div class="text-sm">
                                        <label>Sale Amount (Foreign)</label>
                                        <input type="text" class="form-control" onchange="fill2()" value="0"
                                            min="0" required name="total_foreign" id="total_foreign">
                                    </div>
                                </div><!-- end col-->
                                <div class="col-sm-3">
                                    <div class="text-sm">
                                        <label> Sale Amount (UGX)</label>
                                        <input type="text" readonly class="form-control" id="initial_amount" onchange="fill()"
                                            required name="initial_amount">
                                    </div>
                                </div><!-- end col-->


                                <div class="col-sm-3">
                                    <div class="text-sm">
                                        <label>Charges (Foreign)</label>
                                        <input type="text" class="form-control" onchange="fill2()" value="0"
                                            min="0" required name="charges" id="mycharges">
                                    </div>
                                </div><!-- end col-->
                                <div class="col-sm-3">
                                    <div class="text-sm">
                                        <label>Total Amount</label>
                                        <input type="text" readonly required class="form-control" name="total_amount"
                                            id="total_amount">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm">
                                        <label>Customer</label>
                                        <select class="single-select form-select" name="customer_id" id="customer">
                                            <option value="">Select customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->cust_name . '  (' . $customer->balance . ')' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="text-sm">
                                        <label>Date</label>
                                        <input type="date" required class="form-control" name="date_added"
                                            id="date_added">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="text-sm-end pt-2">
                                        <button type="submit" {{ $bstate }}
                                            class="btn btn-primary mb-2 me-1 d-block">Save sale</button>
                                    </div>
                                </div><!-- end col-->
                            </div>

                        </form>

                    </div>


                </div>

            </div>
        </div>
        <script type="text/javascript">
            function mycust() {
                var x = document.getElementById('saleType').value;
                //   var x = document.getElementById('option-1');
                if (x == 'Credit') {
                    document.getElementById("customer").setAttribute("required", "required");

                    document.getElementById("to_id").setAttribute("disabled", "disabled");
                    $("#to_id").append('<option selected value=" ">NA</option>');

                } else {
                    document.getElementById("customer").removeAttribute("required");
                    document.getElementById("to_id").removeAttribute("disabled");
                }
            }
        </script>

        <script>
            function fill() {

                var myrate = document.getElementById("rate").value - 0;
                var salelocal = document.getElementById("initial_amount").value - 0;
                var saleforeign = document.getElementById("total_foreign").value - 0
                var totallocal = salelocal * myrate;

                document.getElementById("initial_amount").value = totallocal.toFixed(2);
                document.getElementById("total_amount").value = saleforeign.toFixed(2);

            }

            function fill2() {

                var myrate = document.getElementById("rate").value - 0;
                var salelocal = document.getElementById("initial_amount").value - 0;
                var saleforeign = document.getElementById("total_foreign").value - 0
                var mycharge = document.getElementById("mycharges").value - 0

                var totallocal1 = saleforeign + mycharge;
                var totallocal = totallocal1 * myrate;

                document.getElementById("initial_amount").value = totallocal.toFixed(2);
                document.getElementById("total_amount").value = totallocal.toFixed(2);

            }

            function fill3() {
                var myNewrate = document.getElementById("rate").value - 0;
                var myactual = document.getElementById('avamountForegin').value - 0;
                var avamount = myNewrate * myactual;
                var roundedAvamount = avamount.toFixed(2); // Round to 2 decimal places
                document.getElementById('avamount').value = roundedAvamount;
                document.getElementById("total_foreign").value = 0;
                document.getElementById("initial_amount").value = 0;
                document.getElementById("total_amount").value = 0;
                document.getElementById("mycharges").value = 0;
            }
        </script>


        <script>
            function validateForm() {

                var q1 = document.forms["myForm"]["avamount"].value - 0;
                var q2 = document.forms["myForm"]["total_foreign"].value - 0;
                var stm = 'Amount on hand is: ' + q1 + ' and  requested required is: ' + q2;
                var act1 = document.getElementById("to_id").value;
                var act2 = document.getElementById("from_id").value;



                if (q2 > q1) {

                    //  swal('Error ',+ q1 q2 + 'The availbe quatity  is less than the input/required quatity ', 'warning');
                    swal('Error', 'You do not have enough amount, ' + stm + '!', 'warning');
                    return false;
                } else if (q2 < 1) {
                    swal('Error', 'Total sale amount must be greater than 0 !', 'warning');
                    return false;
                } else if (isNaN(q2)) {
                    swal('Error', 'Invalid Amount !', 'warning');
                    return false;
                } else if (q2 == "Infinity") {
                    swal('Error', 'Invalid Amount, or enter charges !', 'warning');
                    return false;
                } else if (act1 == act2) {
                    swal('Error', 'You cant not transfer money to similar accounts, Please choose different two accounts!',
                        'warning');
                    return false;
                } else {
                    return true;
                }

            }
        </script>

    </div>

@endsection
