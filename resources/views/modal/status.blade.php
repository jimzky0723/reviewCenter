<!-- Modal -->
<style>
    .status-info {
        font-size: 1.2em;
    }
</style>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($status==='duplicate')
                <div class="status-info text-danger">Oops! Username is already taken! Please try again.</div>
                @elseif($status==='saved')
                <div class="status-info text-success">Successfully registered! Please wait for the confirmation.</div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-common">Close</button>
            </div>
        </div>
    </div>
</div>