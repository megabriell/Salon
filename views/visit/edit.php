<?php
    include_once dirname(__file__,3).'/models/calendar.php';
    include_once dirname(__file__,3).'/models/user.php';
    include_once dirname(__file__,3).'/models/service.php';
    $calendar = new Calendar();
    $users = new User();

    $id = isset($_POST['id'])? $_POST['id'] : null;
    $data = $calendar->getCalendarById($id);
    if ($data) {
        $id = $data->Id_Agenda;
        $cliente = $data->Id_Cliente;
        $empleado = $data->Id_Estilista;
        $fecha = $data->Fecha;
        $cometario = $data->Comentario;
        $estado = $data->Estado;
        $servicio = $data->Id_Servicio;
    echo "<script>
        $('#client option[value=\"".$cliente."\"]').prop('selected', true);
        $('#stylist option[value=\"".$empleado."\"]').prop('selected', true);
        $('#service option[value=\"".$servicio."\"]').prop('selected', true);
        $('#state option[value=\"".$estado."\"]').prop('selected', true);
    </script>";
?>
<div class="modal fade" id="add_evento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar cita</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="dataForm1" autocomplete="off">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="user" class="col-sm-3 control-label">Cliente</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>">
                                <select id="user" name="user" class="form-control">
                                    <option disabled selected hidden value="">Selecciones un cliente</option>
                                    <?php
                                        $rows_1 = $users->getTypeUsers(3);
                                        if ($rows_1) {
                                            foreach ($rows_1 as $key => $value) {
                                                $id = $value->Id_Usuario;
                                                $name = $value->Nombre.' '.$value->Apellido;
                                                echo '<option value="'.$id.'">'.$name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <div class="bg-gray-active color-palette text-center" style="color:#001731" id="time"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stylist" class="col-sm-3 control-label">Estilista</label>
                            <div class="col-sm-9">
                                <select id="stylist" name="stylist" class="form-control">
                                    <option disabled selected hidden value="">Selecciones un estilista </option>
                                    <?php
                                        $rows_1 = $users->getTypeUsers(2);
                                        if ($rows_1) {
                                            foreach ($rows_1 as $key => $value) {
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
                                <select id="service" name="service" class="form-control">
                                    <option disabled selected hidden value="">Selecciones el tipo de servicio</option>
                                    <?php
                                        $services = new Service();
                                        $rows_2 = $services->getServicesAct();
                                        if ($rows_2) {
                                            foreach ($rows_2 as $key => $value) {
                                                $id = $value->Id_Servicio;
                                                $des = $value->Descripcion;
                                                echo '<option value="'.$id.'">'.$des.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Fecha </label>
                            <div class="col-sm-9">
                                <div class="input-group date" id="datetimepicker">
                                    <input type="text" class="form-control" id="date" name="date" placeholder="Seleccione la fecha de si visita"
                                    value="<?php echo formatDateTime($fecha,'Y-m-d') ?>">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dataTime" class="col-sm-3 control-label">Hora</label>
                            <div class="col-sm-9 bootstrap-timepicker">
                                <input type="text" class="form-control" id="dataTime" name="dataTime" placeholder="
                                Hora de la cita (H:M)" value="<?php echo formatDateTime($fecha,'H:i A')?>"> 
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: -15px;">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id="timeError"></div>
                        </div>
                        <div class="form-group">
                            <label for="comment" class="col-sm-3 control-label">Comentario </label>
                            <div class="col-sm-9">
                                <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="Escriba un cometario aquí, si lo desea..." maxlength="100"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="state" class="col-sm-3 control-label">Estado</label>
                            <div class="col-sm-9">
                                <select id="state" name="state" class="form-control">
                                    <option disabled selected hidden value="">Estado de la cita</option>
                                    <option value="0">Pendiente</option>
                                    <option value="1">Pospuesto</option>
                                    <option value="2">Completado</option>
                                    <option value="3">Cancelado</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success" value="Modificar" name="edit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $.getScript("./views/visit/js/script1.js").done(function(){
        var bootstrapValidator = idForm.data('bootstrapValidator');
        bootstrapValidator.enableFieldValidators('state',true);
    });
</script>
<?php
}
?>