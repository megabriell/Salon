<?php
    include_once dirname(__file__,3).'/models/category.php';

    $category = new Category();
    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $category->getCategoryById($id);
    if ($data) {
        $id = $data->Id_Categoria;
        echo "<script>$('#state_1 option[value=\"".$data->Estado."\"]').prop('selected', true)</script>";
?>

<div class="modal" tabindex="-1" id="Modal1" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm1" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction_1" class="col-sm-3 control-label">Categoria de Producto </label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id_1" id="id_1" value="<?php echo $id?>">
                                <input type="text" class="form-control" id="descripction_1" name="descripction_1" placeholder="Nombre de proveedor" value="<?php echo $data->Descripcion ?>" maxlength="80">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state_1" class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-9">
                                <select id="state_1" name="state_1" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Actualizar" name="edit" id="btnFrm_1">
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
    $.getScript("./views/category/js/script.js").done(function(){
        var bootstrapValidator_1 = idForm.data('bootstrapValidator');
        bootstrapValidator_1.enableFieldValidators('state_1',true);
    });
</script>

<?php
    }
?>