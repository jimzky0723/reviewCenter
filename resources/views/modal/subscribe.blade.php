<!-- Modal -->
<div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Subscribe Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <style>
                .input {
                    cursor: pointer;
                }
                .hide {
                    display: none;
                }
            </style>
            <form method="post" action="{{ url('subscribe') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <fieldset>
                        <legend>Basic Information</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Name of review center" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="need" class="form-control" placeholder="No. of Students Needed" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="owner" class="form-control" placeholder="Name of Owner" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="contact" class="form-control" placeholder="Contact" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Email" required>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="no_month" class="form-control" required>
                                    <option value="">Subscription validity...</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">1 Year</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Address</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="province" id="province2" class="form-control" required data-error="Please select province">
                                    <option value="">Select Province...</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov->provCode }}">{{ $prov->desc }}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="muncity" id="muncity2" class="form-control" required data-error="Please select municipality / city">
                                    <option value="">Select Municipality / City...</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="barangay" id="barangay2" class="form-control" required data-error="Please select barangay">
                                    <option value="">Select Barangay...</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Account Information</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input autocomplete="off" type="text" name="username" class="form-control" required placeholder="Enter username"  data-error="Please enter username">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" required placeholder="Enter password" data-error="Please enter password">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" style="cursor: pointer" class="btn btn-common btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>