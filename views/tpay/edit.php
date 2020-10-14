<?php
    include_once dirname(__file__,3).'/models/tpay.php';

    $pay = new TPay();
    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $pay->getTPayById($id);
    if ($data) {
        $id = $data->Id_Tipo_Pago;
?>

<div class="modal" tabindex="-1" id="modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction" class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" id="id" value="<?php echo $id?>">
                                <input type="text" class="form-control" id="descripction" name="descripction" placeholder="Descripción del tipo de pago" value="<?php echo $data->Descripcion ?>" maxlength="80">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="discount" class="col-sm-3 control-label">Descuento</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="discount" name="discount" placeholder="Descuento a aplicar" value="<?php echo $data->Descuento ?>" maxlength="80">
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
    $.getScript("./views/tpay/js/script.js");
</script>

<?php
    }
?>