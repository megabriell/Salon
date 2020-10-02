<div class="modal" tabindex="-1" id="Modal0" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <form class="form-horizontal" id="dataFrm0" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nameU" class="col-sm-3 control-label">Descripción </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="descripction" name="descripction" placeholder="Descripción del servicio" maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost" class="col-sm-3 control-label">Costo</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="cost" name="cost" placeholder="Costo del servicio (Q)" step="any" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">Precio</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Precio del servicio (Q)" step="any" maxlength="10">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="duration" class="col-sm-3 control-label">Duración(H:M)</label>
                            <div class="col-sm-9 bootstrap-timepicker">
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="
                                Duración del servicio (H:M)">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input type="submit" class="btn btn-success pull-right" value="Agregar" name="create">
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
    $.getScript("./views/service/js/script.js");
</script>