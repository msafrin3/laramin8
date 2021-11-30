<div class="modal-header">
    <h4 class="modal-title">Parameters</h4>
</div>
<div class="modal-body">
    <code><pre><?php echo json_encode(json_decode($log->params), JSON_PRETTY_PRINT) ?></pre></code>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
</div>