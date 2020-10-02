<?php
    include_once dirname(__file__,3).'/models/provider.php';
    include_once dirname(__file__,3).'/models/category.php';
    $provider = new Provider();
    $category = new Category();
?>
<div class="modal" tabindex="-1" id="Modal2" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm2" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction_2" class="col-sm-3 control-label">Descripción </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="descripction_2" name="descripction_2" placeholder="Descripción del producto" maxlength="80">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category" class="col-sm-3 control-label">Categoria</label>
                            <div class="col-sm-9">
                                <select id="category" name="category" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <?php
                                        $rows_0 = $category->getCategoriesAct();
                                        if ($rows_0) {
                                            foreach ($rows_0 as $key => $value) {
                                                $id = $value->Id_Categoria;
                                                $des = $value->Descripcion;
                                                echo '<option value="'.$id.'">'.$des.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provider" class="col-sm-3 control-label">Proveedor</label>
                            <div class="col-sm-9">
                                <select id="provider" name="provider" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <?php
                                        $rows_1 = $provider->getProvidersAct();
                                        if ($rows_1) {
                                            foreach ($rows_1 as $key => $value) {
                                                $id = $value->Id_Proveedor;
                                                $des = $value->Descripcion;
                                                echo '<option value="'.$id.'">'.$des.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost" class="col-sm-3 control-label">Costo</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="cost" name="cost" placeholder="Costo del producto (Q)" step="any" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Precio del producto (Q)" step="any" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stock" class="col-sm-3 control-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock (Existencia)" maxlength="10">
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Agregar" name="create" id="btnFrm_2">
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
    $.getScript("./views/product/js/script.js");
</script>