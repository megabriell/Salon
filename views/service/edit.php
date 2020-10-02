<?php
    include_once dirname(__file__,3).'/models/service.php';

    $service = new Service();
    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $service->getServiceById($id);
    if ($data) {
        $id = $data->Id_Servicio;
        echo "<script>$('#state option[value=\"".$data->Estado."\"]').prop('selected', true)</script>";
?>

<div class="modal" tabindex="-1" id="Modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction" class="col-sm-3 control-label">Descripción </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                                <input type="text" class="form-control" id="descripction" name="descripction" placeholder="Descripción del servicio" maxlength="50" value="<?php echo $data->Descripcion ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost" class="col-sm-3 control-label">Costo</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="cost" name="cost" placeholder="Costo del servicio (Q)" step="any" maxlength="10" value="<?php echo $data->Costo ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Precio del servicio (Q)" step="any" maxlength="10" value="<?php echo $data->Precio ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="duration" class="col-sm-3 control-label">Duración(H:M)</label>
                            <div class="col-sm-9 bootstrap-timepicker">
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="Duración del servicio (H:M)" value="<?php echo $data->Duracion ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state" class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-9">
                                <select id="state" name="state" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Actualizar" name="edit">
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
    $.getScript("./views/service/js/script.js").done(function(){
        var bootstrapValidator = idForm.data('bootstrapValidator');
        bootstrapValidator.enableFieldValidators('state',true);
    });
</script>

<?php
    }
?>