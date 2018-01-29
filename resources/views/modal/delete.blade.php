<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
    <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <input type="hidden" name="currentID" id="currentID" />
                <div class="modal-header">
                    <h3>Confirmation</h3>
                </div>
                <div class="modal-body">
                    @yield('modal')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i> Yes</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->