@extends('inventory.layouts.tableLayout')
@section('title',''.$appName.' | print')
@section('content')
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Invoice</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="card">
                <div class="card-body">
                    <div id="invoice">

                        <div class="invoice overflow-auto">
                            <div style="min-width: 600px">
                                <header>
                                    <div class="row">
                                        <div class="col">
                                            <a href="javascript:;">
                                                <img src="assets/images/logo-icon.png" width="80" alt="" />
                                            </a>
                                        </div>
                                        <div class="col company-details">
                                            <h2 class="name">
                                        <a target="_blank" href="javascript:;">

                                            {{$appName}}


                                        </a>
                                    </h2>
                                            <div> {{ $bizname }}</div>
                                            <div>{{$bizcontact}}</div>
                                            <div>{{$bizemail}}</div>
                                        </div>
                                    </div>
                                </header>
                                <main>
                                    <div class="row contacts">
                                        <div class="col invoice-to">
                                            <div class="text-gray-light">INVOICE TO:</div>
                                            <h2 class="to">John Doe</h2>
                                            <div class="address">796 Silver Harbour, TX 79273, US</div>
                                            <div class="email"><a href="mailto:john@example.com">john@example.com</a>
                                            </div>
                                        </div>
                                        <div class="col invoice-details">
                                            <h1 class="invoice-id">INVOICE 3-2-1</h1>
                                            <div class="date">Date of Invoice: 01/10/2018</div>
                                            <div class="date">Due Date: 30/10/2018</div>
                                        </div>
                                    </div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Item</th>
                                                <th class="text-right">Qty</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-right">Discount</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($values)>0)
                                            @php($i=1)
                                            @foreach($values as $value)

                                            <tr>
                                                <td class="no">{{$i++}}</td>
                                                <td class="text-left">{{$value->item_name.'  '.$value->color.' ('.$value->uom_name.')'}}</td>
                                                <td class="text-right">{{ $value->qty_given}} <input type="hidden" name="quantity[]" value="{{$value->qty_given}}"></td>
                                                <td class="text-right">@money($value->sale_price)</td>
                                                <td class="text-right">@money($value->discount)</td>

                                                <td class="total">@money($value->itemamt) <input type="hidden" name="amount" value="{{ $value->total_amount}} "></td>
                                            </tr>
                                            @endforeach
                                                @endif
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="2">SUBTOTAL</td>
                                                        <td>$5,200.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="2">TAX 25%</td>
                                                        <td>$1,300.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td colspan="2">GRAND TOTAL</td>
                                                        <td>$6,500.00</td>
                                                    </tr>
                                                </tfoot>
                                    </table>
                                    <div class="thanks">Thank you!</div>
                                    <div class="notices">
                                        <div>NOTICE:</div>
                                        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                                    </div>
                                </main>
                                <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                            </div>
                            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                            <div></div>
                        </div>
                        <div class="toolbar hidden-print">
                            <div class="text-right">
                                <button type="button" class="btn btn-dark"><i class="fa fa-print"></i> Print</button>
                                <button type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
                            </div>
                            <hr/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page-content-wrapper-->

<!--end page-wrapper-->
 @endsection
