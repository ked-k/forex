
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show" id="sales" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Sales Report form</h5>
            <form method="POST" target="_blank" action="{{route('reportSales')}}">
                @csrf
                    <div class="row">
                    <div class="col-md-6 ">
                        <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6 ">
                            <div class="form-group">
                            <label>To</label>
                            <input type="date" name="to" class="form-control" value="{{date('Y-m-d')}}" required="">
                            </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <div>
                        <label>Select Type</label>
                        <select class="form-control" name="type" id="">
                            <option selected value="0">All</option>
                            <option  value="Cash">Cash</option>
                            <option value="Credit">Credit</option>
                        </select>
                        </div>
                     </div>
                    <div class="col-md-8 mt-2">
                        <div>
                        <label>Select Account</label>
                        <select class="single-select form-select" name="acct" id="acctS">
                            <option selected value="0">All</option>
                            @foreach($accounts as $item)
                            <option value="{{$item->act}}">{{$item->account_name.' ('.$item->account_number.'-'.$item->currency_name.')'  }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    </div>
                    <button type="submit" class="btn btn-primary mt-2 text-sm-end"><i class="fa fa-file"></i> Show report</button>
            </form>
    </div>
    