<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Register Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="contactForm">
                <div class="modal-body">
                    <fieldset>
                        <legend>Review Centers</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="center" class="form-control" required data-error="Please select review center">
                                    <option value="">Select Review Center...</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Personal Information</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="fname" class="form-control" placeholder="Enter Firstname" required data-error="Please enter your firstname">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="mname" class="form-control" placeholder="Enter Middlename" required data-error="Please enter your middlename">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="lname" class="form-control" placeholder="Enter Lastname" required data-error="Please enter your lastname">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="suffix" class="form-control" data-error="Please select review center">
                                    <option value="">Select Suffix...</option>
                                    <option value="">None</option>
                                    <option>Sr.</option>
                                    <option>Jr.</option>
                                    <option>I</option>
                                    <option>II</option>
                                    <option>III</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="date" name="dob" class="form-control" placeholder="Enter your birthday" required data-error="Enter your birthday">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="contact" class="form-control" placeholder="Enter Contact #" required data-error="Please enter your contact #">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter Email-Address">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Address</legend>
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="province" class="form-control" required data-error="Please select province">
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
                                <select name="muncity" class="form-control" required data-error="Please select municipality / city">
                                    <option value="">Select Municipality / City...</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="barangay" class="form-control" required data-error="Please select barangay">
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
                    <button type="submit" class="btn btn-common">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>