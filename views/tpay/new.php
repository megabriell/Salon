<div class="modal" tabindex="-1" id="modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="form-group">
                            <label for="descripction" class="col-sm-3 control-label">Descripción</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="descripction" name="descripction" placeholder="Descripción del tipo de pago" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="discount" class="col-sm-3 control-label">Descuento</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="discount" name="discount" placeholder="Descuento a aplicar" maxlength="10">
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
    $.getScript("./views/tpay/js/script.js");
</script>