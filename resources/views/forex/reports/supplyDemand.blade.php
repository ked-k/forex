
<!--  --------------------------------------------- -->

     <div class="tab-pane fade" id="supply" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Supply Report form</h5>
            <form method="POST" action="">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>From</label>
                        <input type="date" name="from" value="{{date('Y-m-d')}}" class="form-control" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                            <label>To</label>
                            <input type="date" name="to" class="form-control" value="{{date('Y-m-d')}}" required="">
                            </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div>
                        <label>Select currency</label>
                        <select class="single-select form-select" name="items_id" id="items_id">
                            <option selected value="0">All</option>
                            @foreach($currency as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name.' ('.$item->uom_name.')'  }}</option>
                            @endforeach
                        </select>
                        </div>
                     </div>
                    <div class="col-md-8 mt-2">
                        <div>
                        <label>Select Account</label>
                        <select class="single-select form-select" name="items_id" id="items_id">
                            <option selected value="0">All</option>
                            @foreach($accounts as $item)
                            <option value="{{$item->item_id}}">{{$item->item_name.' ('.$item->uom_name.')'  }}</option>
                            @endforeach
                        </select>
                        </div>
                     </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Select Department</label>
                        <select  class="form-control" name="shop">
                                    <option value="">All</option>
                        </select>
                        </div>
                    </div>

                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-file"></i> Show report</button>
            </form>
    </div>
