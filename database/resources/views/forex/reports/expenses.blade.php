
<!--  --------------------------------------------- -->

     <div class="tab-pane fade show" id="expense" role="tabpanel" aria-labelledby="list-settings-list">
            <h5>Expense Report form</h5>
            <form method="POST" target="_blank" action="{{route('reportexpense')}}">
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

                    <div class="col-md-8 mt-2">
                        <div class="form-group">
                        <label>Expense Type</label>
                        <select class="single-select form-select" name="expense" required>
                            <option selected value="0">All</option>
                            <option value="Miscellaneous">Miscellaneous expenses </option>
                            <option value="Rent">Rent expense </option>
                            <option value="Finance cost">Finance cost </option>
                            <option value="Taxation">Taxation expense</option>
                            <option value="Communication">Communication expense </option>
                            <option value="Utilities costs">Cost of utilities </option>
                            <option value="Depreciation">Depreciation expense </option>
                            <option value="Stationery">Printing and stationery expense </option>
                            <option value="Goods cost">Cost of goods sold </option>
                            <option value="Selling and distribution">Selling and distribution expenses </option>
                            <option value="Operational">Operating, general and administrative expenses </option>
                            <option value="Salaries">Salaries, wages, and benefits </option>
                            <option value="Travel">Staff traveling expense </option>
                            <option value="Repair and Maintenance">Repair and maintenance expense </option>
                            <option value="Insurance"> Insurance cost </option>
                            <option value="Legal">Legal and professional charges </option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2">
                        <button type="submit" class="btn btn-primary mt-2 text-sm-end"><i class="fa fa-file"></i> Show report</button>
                     </div>

                    </div>

            </form>
    </div>



