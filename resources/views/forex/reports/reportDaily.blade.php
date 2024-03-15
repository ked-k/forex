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
                                    <i class="fas fa-globe"></i> DAILY SALES REPORT BETWEEN ({{$from}} AND {{$to}}) <br>
                                    @if($dpt != 'All'){
                                    {{$dpt}}
                                    }
                                    @endif
                                    </h4>
                                </div>
                            <!-- /.col -->
                            </div>
                        <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                <address>
                                <strong>Accounts: </strong>{{$item}}<br>
                                </address>
                                </div>
                                <div class="col-sm-3 invoice-col">
                                    <address>
                                    <strong>Currency: </strong>{{$sale}}<br>
                                    </address>
                                </div>
                            </div>
                        <!-- /.row -->

                                <div class="row">
                                    <div class="col-12">
                                        <table  class="table table-striped table-bordered" style="width:100%;font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Day</th>
                                                    <th class="text-end">Total amount</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($values)>0)
                                                @php($i=1)
                                                @foreach($values as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td class="text-left">{{$value->date}}</td>
                                                    <td>{{ date('l', strtotime($value->date))}}</td>
                                                    <td class="text-end">@money($value->totalamount) <input type="hidden" value="{{$value->totalamount}}" name="myamounts"></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>

                                        </table>
                                    </div>
                                    <p class="text-end text-primary mt-4">Total Amount: <strong><span id="totalamount"></span></strong></p>
                                <!-- /.col -->
                                </div>
                        <!-- /.row -->
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

    }
    sumInputs();
    </script>
@endsection