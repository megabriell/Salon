<div class="modal" tabindex="-1" id="Modal1" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm1" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="descripction_1" class="col-sm-3 control-label">Categoria de Producto </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="descripction_1" name="descripction_1" placeholder="Categoria del producto" maxlength="80">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Agregar" name="create" id="btnFrm_1">
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
    $.getScript("./views/category/js/script.js");
</script>