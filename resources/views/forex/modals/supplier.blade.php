                                        <div class="modal fade" id="SupplierModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-md">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Create a new supplier</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
                                                    <form action="{{ url('forex/suppliers/add') }}" method="POST">
                                                        <div class="modal-body">

                                                                @csrf

                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <div class="mb-3">
                                                                            <label for="sup_name" class="form-label">Supplier Name</label>
                                                                            <input type="text" id="sup_name" name="sup_name" class="form-control" value="{{old('sup_name')}}"  required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="address" class="form-label">Address</label>
                                                                            <input type="text" id="address" name="address" class="form-control" value="{{old('address')}}"  required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="contact" class="form-label">Contact</label>
                                                                            <input type="text" id="contact" name="contact" class="form-control" value="{{old('contact')}}" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="CategoryName" class="form-label">Email</label>
                                                                            <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" >
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="balance" class="form-label">Starting Balance</label>
                                                                            <input type="text" id="balance" name="balance" value="0" class="form-control" value="{{old('balance')}}"  required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="CategoryName" class="form-label">Description</label>
                                                                            <textarea name="description" class="form-control"></textarea>
                                                                        </div>



                                                                    </div> <!-- end col -->

                                                                </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
												</div>
											</div>
										</div>
