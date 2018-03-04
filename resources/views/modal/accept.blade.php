<div class="modal fade" tabindex="-1" role="dialog" id="acceptModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <input type="hidden" name="currentID" id="currentID" />
            <div class="modal-header">
                <h3>Payment</h3>
            </div>
            <div class="modal-body">
                @yield('modal')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-success btn-sm" ><i class="fa fa-money"></i> Submit</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="ignoreModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <input type="hidden" name="currentID" id="currentID" />
            <div class="modal-header">
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                @yield('modal2')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Ignore</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="subjectModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="name_reviewee">Name here...</h3>
            </div>
            <div class="modal-body">
                <div class="subject_grade">Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
