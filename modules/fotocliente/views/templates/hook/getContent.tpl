<fieldset>
    <h2>Configuracion del modulo de fotos para los clientes</h2>
    <div class="panel">
        <div class="panel-heading">
            <legend><img src="../img/admin/cog.gif" width="16" alt="">Configuration</legend>
        </div>
        <form action="" method="post">
            <div class="form-group clearfix">
                <label class="col-lg-3"> Añadir Comentario</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" name="enabled_comment" alt="">
                    <input type="radio" id="enabled_comment_1" name="enable_comment" {if ($enable == '1')}checked{/if}  value="1">
                    <label class="t" for="enabled_comment_1">Si</label>

                    <img src="../img/admin/disabled.gif" alt="">
                    <input type="radio" id="enabled_comment_0" name="enable_comment" {if ($enable == '0')} checked {/if} value="0">
                    <label for="enabled_comment_0" class="t">No</label>

                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" class="btn btn-warning pull-right" name="fotocliente_form" value="Guardar">
            </div>
        </form>
    </div>
</fieldset>