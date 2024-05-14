                                        <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add a New currency</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
                                                    <form action="{{ url('forex/currencies/add') }}" method="POST"name="myForm"  class="needs-validation"  onsubmit="return validateForm()" >
                                                        <div class="modal-body">

                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <div class="mb-3">
                                                                            <label for="CategoryName" class="form-label">Currency Name</label>
                                                                            <input type="text" id="CategoryName" class="form-control" name="currency_name" value="{{old('currency_name')}}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="currency_country" class="form-label">Country Name</label>
                                                                            <input type="text" id="currency_country"  class="form-control" name="currency_country" value="{{old('currency_country')}}">
                                                                        </div>
                                                                        <input type="hidden" id="buying_rate"  class="form-control" name="buying_rate"  value="0">
                                                                        {{-- <div class="mb-3">
                                                                            <label for="buying_rate" class="form-label">Buying Rate</label>
                                                                            <input type="text" id="buying_rate"  class="form-control" name="buying_rate" onchange="fillm()" value="{{old('buying_rate')}}">
                                                                        </div> --}}
                                                                        {{-- <div class="mb-3">
                                                                            <label for="selling_rate" class="form-label">Selling Rate</label>
                                                                            <input type="text" id="selling_rate" class="form-control" name="selling_rate" onchange="fillm()" value="{{old('selling_rate')}}">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="usd_exrate" class="form-label">{{$mycur}} % Profit Rate</label>
                                                                            <input type="text" id="usd_exrate" class="form-control" name="usd_exrate"  value="{{old('usd_exrate')}}">
                                                                        </div> --}}
                                                                    </div> <!-- end col -->

                                                                </div>

                                                        </div>
                                                        <script>
                                                               function fillm() {
                                                                var mrate = document.getElementById("buying_rate").value;
                                                               document.getElementById("usd_exrate").value = mrate;

                                                                }
                                                        </script>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
												</div>
											</div>
										</div>
                                        <script>

                                            function validateForm() {
                                            var x = document.forms["myForm"]["buying_rate"].value-0;
                                            var y = document.forms["myForm"]["selling_rate"].value-0;

                                          if (x > y) {

                                            swal('Eroor ', 'The selling rate must be higher than buying rate!', 'error');
                                            return false;
                                          }
                                          else if (y > x) {
                                         swal('Good Job', 'Your details will be submitted!', 'success');

                                            return true;
                                          }



                                        }
                                  </script>
