<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="loginForm">
                <div class="modal-body">

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" name="username" autocomplete="off" class=" username form-control" required placeholder="Enter username"  data-error="Please enter username">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="password" id="password" class="password form-control" required placeholder="Enter password" data-error="Please enter password">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-common btn-login" style="cursor: pointer;">Login</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>