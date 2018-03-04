<div class="modal fade" tabindex="-1" role="dialog" id="paymentModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form action="{{ url('center/reviewee/pay') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="currentID" id="currentID" />
                <div class="modal-header">
                    <h3>Payment History</h3>
                </div>
                <div class="modal-body">
                    <div class="payment_history">Loading...</div>
                    <hr />
                    <div class="form-group">
                        <label>Amount:</label>
                        <input type="text" name="amount" class="form-control" placeholder="0.00" required />
                    </div>
                    <div class="form-group">
                        <label>Remarks:</label>
                        <input type="text" name="remarks" class="form-control" placeholder="Remarks of the transactions..." required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-money"></i> Pay</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->