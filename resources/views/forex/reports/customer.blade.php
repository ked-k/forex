
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show" id="customer" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Customer Report form</h5>
            <form method="POST" target="_blank" action="{{route('reportCustSales')}}">
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

                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                        <label>Select cutomer</label>
                        <select class="single-select form-select" name="cutomer" required>
                            <option selected value="0">All</option>
                            @foreach($customers as $cust)
                            <option value="{{$cust->id}}">{{$cust->cust_name}}</option>
                            @endforeach
                          </select>
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
                    <div class="col-md-2 mt-2">
                        <button type="submit" class="btn btn-primary mt-2 text-sm-end">Show report</button>
                     </div>

                    </div>

            </form>
    </div>



