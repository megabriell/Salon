<?php
    include_once dirname(__file__,3).'/models/user.php';
    include_once dirname(__file__,3).'/models/service.php';
    $users = new User();
    $services = new Service();
?>
<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agendar nueva visita</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="dataForm" autocomplete="off">
                    <div class="box-body">
                        <div class="form-group">
                            <span class="text-muted">Selecciones un estilista de su preferencia</span>
                            <label for="stylist" class="col-sm-3 control-label">Estilista</label>
                            <div class="col-sm-9">
                                <select id="stylist" name="stylist" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <?php
                                        $rows_0 = $users->getTypeUsers(2);
                                        if ($rows_0) {
                                            foreach ($rows_0 as $key => $value) {
                                                $id = $value->Id_Usuario;
                                                $name = $value->Nombre.' '.$value->Apellido;
                                                echo '<option value="'.$id.'">'.$name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="service" class="col-sm-3 control-label">Servicio</label>
                            <div class="col-sm-9">
                                <span class="text-muted">Selecciones el tipo de servicio que desea</span>
                                <select id="service" name="service" class="form-control">
                                    <option disabled="disabled" selected="selected" value="">--Selecciona una opción--</option>
                                    <?php
                                        $rows_1 = $services->getServicesAct();
                                        if ($rows_1) {
                                            foreach ($rows_1 as $key => $value) {
                                                $id = $value->Id_Servicio;
                                                $des = $value->Descripcion;
                                                echo '<option value="'.$id.'">'.$des.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="bg-gray-active color-palette text-center" style="color:#001731" id="time"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Fecha </label>
                            <div class="col-sm-9">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" class="form-control" id="date" name="date" placeholder="Seleccione la fecha de si visita">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                 <div class="bg-gray-active color-palette text-center" style="color:#001731" id="time2"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="comment" class="col-sm-3 control-label">Comentario </label>
                            <div class="col-sm-9">
                                <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Escriba un cometario aquí, si lo desea..." maxlength="100"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success" value="Agregar" name="create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $.getScript("./views/date/js/script1.js");
</script>