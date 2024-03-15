<div class="modal fade" id="balanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Adjust Custmer</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                        </div> <!-- end modal header -->
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('customer-add_balance') }}" method="POST">
                                                                                @csrf

                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                             <div class="mb-3">
                                                                                            <label for="customer" class="form-label">Customer</label>
                                                                                            <select class="single-select form-select" id="customer" required name="customer">
                                                                                                <option value="">Select</option>
                                                                                                @foreach($values as $value)
                                                                                                <option value="{{$value->id}}">{{ $value->cust_name}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label for="type" class="form-label">Type</label>
                                                                                            <select class="form-control" id="type" required name="type">
                                                                                                <option value="">Select</option>
                                                                                                 <option value="Credit">Credit</option>
                                                                                                  <option value="Debit">Debit</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        
                                                                                        <div class="mb-3">
                                                                                            <label for="amount" class="form-label">Amount</label>
                                                                                            <input type="number" id="amount" value="" class="form-control" name="amount">
                                                                                        </div>
                                                                                    </div> <!-- end col -->

                                                                                </div>
                                                                                <!-- end row-->
                                                                                <div class="d-grid mb-0 text-center">
                                                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                                                </div>

                                                                            </form>

                                                                        </div>

                                                                    </div> <!-- end modal content-->
                                                                </div> <!-- end modal dialog-->
                                                        </div> <!-- end modal-->
                                                    