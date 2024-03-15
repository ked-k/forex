@extends('forex.reports.reportLayout')
@section('title', 'Reports')
@section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card-body">
                       
                    <section class="invoice">
                        <!-- title row -->
                            <div class="row">                           
                                <div class="col-12">                          
                                    <h4 class="page-header text-center">
                                    <i class="fas fa-globe"></i> MONTHLY PROFIT LOSS REPORT BETWEEN ({{$from}} AND {{$to}}) 
                                </div>
                            <!-- /.col -->
                            </div>
                        <!-- info row -->
                            <div class="row invoice-info">
                                <div class=" invoice-col">
                                <address>
                                <strong>Account: </strong>{{$item}}<br>
                                </address>
                                </div>
                                
                            </div>
                        <!-- /.row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h3>Income</h3>
                                        <hr>
                                        <h4>Sales (UGX)</h4>
                                        <table  class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Month(YY/MM)</th>
                                                    <th>Amount</th>               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($i=1)
                                                @foreach($sales as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>                                                    
                                                    <td>{{ $value->trans_month}}</td>
                                                    <td class="text-end">@money($value->totalamount) <input type="hidden" value="{{$value->totalamount}}" name="myamounts"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        <p class="text-end text-primary mt-4">Total Sales Amount: <strong><span id="totalamount"></span></strong></p>

                                        <hr>
                                        <h4>Costs/Purchases (UGX)</h4>
                                        <table  class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Month(YY/MM)</th>
                                                    <th>Amount</th>               
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($i=1)
                                                @foreach($purchases as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>                                                    
                                                    <td>{{ $value->trans_month}}</td>
                                                    <td class="text-end">@money($value->totalamount) <input type="hidden" value="{{$value->totalamount}}" name="myamounts2"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        <p class="text-end text-primary mt-4">Total Sales Amount: <strong><span id="totalamount2"></span></strong></p>
                                    </div>                                   
                                    <!-- /.col -->
                                </div>
                        <!-- /.row -->
                        <p class="text-end h5 text-info mt-4">Total Gross Profit: <strong><span id="totalamountp"></span></strong></p>
                         <!-- /.row -->
                         <div class="row">
                            <div class="col-12">
                                <h3>Loss/Expenses</h3>
                                <hr>
                                <h4>Expenses(UGX)</h4>
                                <table  class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Month(YY/MM)</th>
                                            <th>Amount</th>               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
                                        @foreach($expenses as $value)
                                        <tr>
                                            <td>{{$i++}}</td>                                                    
                                            <td>{{ $value->exp_month}}</td>
                                            <td class="text-end">@money($value->totalamount) <input type="hidden" value="{{$value->totalamount}}" name="myamount3"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <p class="text-end text-primary mt-4">Total Expense Amount: <strong><span id="totalamount3"></span></strong></p>

                                <hr>
                                <h4>Losses (UGX)</h4>
                                <table  class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Month(YY/MM)</th>
                                            <th>Amount</th>               
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($i=1)
                                        @foreach($loses as $value)
                                        <tr>
                                            <td>{{$i++}}</td>                                                    
                                            <td>{{ $value->loss_month}}</td>
                                            <td class="text-end">@money($value->totalamount) <input type="hidden" value="{{$value->totalamount}}" name="myamounts4"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                <p class="text-end text-primary mt-4">Total Loss Amount: <strong><span id="totalamount4"></span></strong></p>
                            </div>                                   
                            <!-- /.col -->
                        </div>
                        <p class="text-end h5 text-info mt-4">Total Expenses: <strong><span id="totalamountE"></span></strong></p>
                <!-- /.row -->
                <p class="text-end h4 text-info mt-4">Grand Total Gross Profit: <strong><span id="totalamountG"></span></strong></p>
                            <div class="row">
                            <!-- accepted payments column -->
                                <div class="col-4">
                                <p >Processed by: <strong>{{auth()->user()->name}}</strong></p>
                                </div>
                            <!-- /.col -->
                                <div class="col-4">
                                <p >Date processed: <strong>{{date('Y-m-d')}}</strong></p>
                                </div>
                                <div class="col-2">
                                <button onclick="window.print();"  class="btn btn-default no-print"><i class="mdi mdi-printer-check"></i> Print</button>
                                </div>
                            <!-- /.col -->
                            </div>

                        <!-- /.row -->
                    </section>
                </div> <!-- tab-content -->
            </div> <!-- end #rootwizard-->
        </div>


<script type="text/javascript">

    window.sumInputs = function() {
        var inputs = document.getElementsByName('myamounts'),
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

    //---------------------Purchases----------------------------------------
    var inputs2 = document.getElementsByName('myamounts2'),
            sum2 = 0;
        for(var j=0; j<inputs2.length; j++) {
            var ip2 = inputs2[j];
            if (ip2.name && ip2.name.indexOf("total") < 0) {
                sum2 += parseFloat(ip2.value) || 0;
            }
        }
        var ked2 = sum2;
      var num2 = 'UGX: ' + ked2.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    document.getElementById('totalamount2').innerHTML = num2;
    var profit = sum-sum2;
    document.getElementById('totalamountp').innerHTML = 'UGX: ' + profit.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
 //---------------------Expenses----------------------------------------
 var inputs3 = document.getElementsByName('myamount3'),
            sum3 = 0;
        for(var k=0; k<inputs3.length; k++) {
            var ip3 = inputs3[k];
            if (ip3.name && ip3.name.indexOf("total") < 0) {
                sum3 += parseFloat(ip3.value) || 0;
            }
        }
        var ked3 = sum3;
      var num3 = 'UGX: ' + ked3.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    document.getElementById('totalamount3').innerHTML = num3;

 //---------------------Purchases----------------------------------------
 var inputs4 = document.getElementsByName('myamounts4'),
            sum4 = 0;
        for(var l=0; l<inputs4.length; l++) {
            var ip4 = inputs4[l];
            if (ip4.name && ip4.name.indexOf("total") < 0) {
                sum4 += parseFloat(ip4.value) || 0;
            }
        }
        var ked4 = sum4;
      var num4 = 'UGX: ' + ked4.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    document.getElementById('totalamount4').innerHTML = num4;
    var exp = sum3-sum4;
    document.getElementById('totalamountE').innerHTML = 'UGX: ' + exp.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    var gross = profit -exp;
    document.getElementById('totalamountG').innerHTML = 'UGX: ' + gross.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }


    sumInputs();
    </script>
   
@endsection