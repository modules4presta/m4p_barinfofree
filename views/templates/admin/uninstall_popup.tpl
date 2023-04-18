<div class="modal fade" id="uninstall-popup" tabindex="-1" role="dialog" aria-labelledby="uninstall-popup-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uninstall-popup-label">Czy na pewno chcesz odinstalować {$module_display_name}?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Po odinstalowaniu wszystkie dane modułu zostaną usunięte. Czy na pewno chcesz kontynuować?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                <button type="button" class="btn btn-danger" id="uninstall-module-btn">Odinstaluj</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#uninstall-module-btn').click(function() {
            $('#uninstall-popup').modal('hide');
            document.location.href = '{$smarty.server.REQUEST_URI}&uninstall=1';
        });
    });
</script>
