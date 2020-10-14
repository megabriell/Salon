<?php
    include_once dirname(__file__,3).'/models/product.php';
    $product = new Product();
?>
<div class="modal" tabindex="-1" id="modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="product" class="col-sm-3 control-label">Producto</label>
                            <div class="col-sm-9">
                                <select id="product" name="product" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <?php
                                        $rows_0 = $product->getProductsAct();
                                        if ($rows_0) {
                                            foreach ($rows_0 as $key => $value) {
                                                $id = $value->Id_Producto;
                                                $des = $value->Descripcion;
                                                echo '<option value="'.$id.'">'.$des.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="quantity" class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Cantidad" maxlength="10">
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Agregar" name="create">
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
    $.getScript("./views/reserve/js/script1.js");
</script>