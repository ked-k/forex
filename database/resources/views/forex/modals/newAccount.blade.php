                                        <div class="modal fade" id="AccountModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Create a new Account</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
                                                    <form action="{{ url('forex/accounts/add') }}" method="POST">
                                                        <div class="modal-body">

                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
                                                                        <div class="mb-3">
                                                                            <label for="account_name" class="form-label">Account name</label>
                                                                            <input type="text" id="account_name" name="account_name" class="form-control"  required value="{{old('account_name')}}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="account_type" class="form-label">Account Type</label>
                                                                            <select name="account_type" class="form-control" id="account_type">
                                                                                <option value="Bank">Bank Account</option>
                                                                                <option value="Line">Line Account</option>
                                                                                <option value="Cash">Cash Account</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="account_number" class="form-label">Account Number</label>
                                                                            <input type="text" id="account_number" name="account_number" class="form-control"  required value="{{old('account_number')}}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Select Currency</label>
                                                                            <div class="input-group">
                                                                                <select class="single-select form-select" name="default_currency" id="currency" required>
                                                                                    <option value="">Select</option>
                                                                                    @if(count($currencies)>0)
                                                                                @foreach($currencies as $cur)
                                                                                    <option value="{{ $cur->id}}">{{ $cur->currency_name}}</option>
                                                                                @endforeach
                                                                                @endif
                                                                                </select>
                                                                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#categoryModal"><i class='bx bx-add'></i>New
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="available_balance" class="form-label">Currency Rate</label>
                                                                            <input type="text" id="rate" readonly name="rate" class="form-control"  required >
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="available_balance" class="form-label">Opening Balance</label>
                                                                            <input type="text" id="openBalance" name="foreign_balance" class="form-control" onchange="fill()"  required >
                                                                        </div>


                                                                        <div class="mb-3">

                                                                            <label for="available_balance" class="form-label">Opening Balance in UGX</label>
                                                                            <input type="text" id="ugx" name="available_balance" class="form-control" onchange="fill2()" required >
                                                                        </div>


                                                                    </div> <!-- end col -->

                                                                </div>
                                                                <script>
                                                                       function fill() {

                                                                        var myrate = document.getElementById("rate").value-0;
                                                                        var salelocal = document.getElementById("openBalance").value-0;

                                                                        var totalforeign = salelocal*myrate;

                                                                        document.getElementById("ugx").value = totalforeign.toFixed(2);

                                                                        }
                                                                        function fill2() {

                                                                            var myrate = document.getElementById("rate").value-0;
                                                                            var salelocal = document.getElementById("ugx").value-0;

                                                                            var totalforeign = salelocal/myrate;

                                                                            document.getElementById("openBalance").value = totalforeign.toFixed(2);

                                                                            }
                                                                </script>
                                                                <script>
                                                                    $(document).ready(function(){
                                                                    $('#currency').change(function() {

                                                                        var curId = $(this).val();

                                                                        document.getElementById('ugx').value =0;
                                                                       document.getElementById('openBalance').value =0;
                                                                        document.getElementById('rate').value ="0";


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

                                                                            document.getElementById('rate').value =salerate;


                                                                           }
                                                                         }
                                                                                }
                                                                            });
                                                                        } else {
                                                                            document.getElementById('rate').value ="";
                                                                        document.getElementById('ugx').value ="";
                                                                        }
                                                                    });
                                                                });
                                                                </script>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
												</div>
											</div>
										</div>
