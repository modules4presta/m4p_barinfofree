{extends 'popup.tpl'}

{block name='content'}
    <p>{l s='Are you sure you want to uninstall the module:'}</p>
    <h3>{$module_display_name}</h3>

    <form id="uninstall-form" action="#" method="post">
        <div class="form-group">
            <label for="reason">{l s='Reason for uninstalling:'}</label>
            <textarea id="reason" name="reason" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" value="{l s='Uninstall'}" class="btn btn-danger" />
            <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Cancel'}</button>
        </div>
    </form>
{/block}

{block name='javascript_bottom'}
    <script>
        $(document).ready(function() {
            $('#uninstall-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{$module_link}ajax.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Obsłuż odpowiedź po udanym zatwierdzeniu formularza
                    }
                });
            });
        });
    </script>
{/block}