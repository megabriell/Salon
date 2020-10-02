<?php
    include_once dirname(__file__,3).'/models/provider.php';

    $provider = new Provider();
    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $provider->getProviderById($id);
    if ($data) {
        $id = $data->Id_Proveedor;
        echo "<script>$('#state_0 option[value=\"".$data->Estado."\"]').prop('selected', true)</script>";
?>

<div class="modal" tabindex="-1" id="Modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction_0" class="col-sm-3 control-label">Proveedor </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id_0" id="id_0" value="<?php echo $id?>">
                                <input type="text" class="form-control" id="descripction_0" name="descripction_0" placeholder="Nombre de proveedor" value="<?php echo $data->Descripcion ?>" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state_0" class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-9">
                                <select id="state_0" name="state_0" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Actualizar" name="edit" id="btnFrm_0">
                        </button>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-label="Close">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div><!-- End body modal -->
        </div><!-- End content modal -->
    </div>
</div>


<script>
    $.getScript("./views/provider/js/script.js").done(function(){
        var bootstrapValidator = idForm.data('bootstrapValidator');
        bootstrapValidator.enableFieldValidators('state_0',true);
    });
</script>

<?php
    }
?>