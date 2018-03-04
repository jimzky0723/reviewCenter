<div class="modal fade" tabindex="-1" role="dialog" id="feedbackModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="{{ url('reviewee/feedback/store') }}" method="post">
            <div class="modal-header">
                <h3>Feedback / Testimonials</h3>
            </div>
            <div class="modal-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Are you satisfied?</label>
                    <select name="satisfaction" required class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Your Feedback</label>
                    <textarea name="contents" class="form-control" style="resize: none;" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-check"></i> Submit</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="feedbackStatusModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="{{ url('reviewee/feedback/store') }}" method="post">
                <div class="modal-header">
                    <h3>Sent</h3>
                </div>
                <div class="modal-body text-success" style="font-size: 1.3em">
                    <strong>Thank you for your feedback.</strong>
                </div>
                <div class="modal-footer">

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->