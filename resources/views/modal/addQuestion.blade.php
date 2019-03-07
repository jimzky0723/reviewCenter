<div class="modal fade" tabindex="-1" role="dialog" id="addQuestion">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Question</h3>
            </div>
            <form method="POST" action="{{ url('instructor/question/'.$quiz_id.'/store') }}">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Your Question:</label>
                    <textarea required="required" name="question" class="form-control" rows="5" style="resize: none"></textarea>
                </div>
                <div class="form-group">
                    <input type="text" required="required" name="answer" class="form-control" placeholder="Enter Answer" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input type="text" required="required" name="choice2" class="form-control" placeholder="Enter another choice" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input type="text" required="required" name="choice3" class="form-control" placeholder="Enter another choice" autocomplete="off" />
                </div>
                <div class="form-group">
                    <input type="text" required="required" name="choice4" class="form-control" placeholder="Enter another choice" autocomplete="off" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success btn-sm btn-check" ><i class="fa fa-send"></i> Submit</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="addBulkQuestion">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Bulk Question</h3>
            </div>
            <form method="POST" action="{{ url('instructor/question/'.$quiz_id.'/bulk') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Upload CSV File [<a target="_blank" href="{{ url('view/file/sample.csv') }}" class="text-warning">Format</a>]:</label>
                        <input type="file" name="file" class="form-control" required accept=".csv" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm btn-check" ><i class="fa fa-send"></i> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="updateQuestion">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Question</h3>
            </div>
            <form method="POST" action="{{ url('instructor/question/'.$quiz_id.'/update') }}">
                {{ csrf_field() }}
                <input type="hidden" name="question_id" id="question_id" value="" />
                <div class="modal-body">
                    <div class="form-group">
                        <label>Your Question:</label>
                        <textarea required="required" name="question" id="question" class="form-control" rows="5" style="resize: none"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" required="required" id="answer" autocomplete="off" value="" name="answer" class="form-control" placeholder="Enter Answer" />
                    </div>
                    <div class="form-group">
                        <input type="text" required="required" id="choice2" autocomplete="off" value="" name="choice2" class="form-control" placeholder="Enter another choice" />
                    </div>
                    <div class="form-group">
                        <input type="text" required="required" id="choice3" autocomplete="off" value="" name="choice3" class="form-control" placeholder="Enter another choice" />
                    </div>
                    <div class="form-group">
                        <input type="text" required="required" id="choice4" autocomplete="off" value="" name="choice4" class="form-control" placeholder="Enter another choice" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm btn-check" ><i class="fa fa-send"></i> Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="deleteQuestion">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form action="{{ url('instructor/question/'.$quiz_id.'/destroy') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="question_id" id="deleteQuestionID" />
            <div class="modal-header">
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                <p class="text-danger">Are you sure you want to delete this question?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Yes</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->