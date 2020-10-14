<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-tag"></i>
                <h3 class="box-title">Citas reservadas</h3>
                <div class="box-tools pull-right">
                    <?php
                    $infoUser = json_decode( $_COOKIE["_data0U"],true);//Mostrar solo si es administrador
                    if($infoUser['sistema'] == 1){
                    ?>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Nuevo Registro" onclick="add()" id="btn1">
                            <i class="fa fa-plus"></i> Agregar
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="box-body" id="box_body">
                <!--ventana modal para el calendario-->
                <div class="modal fade" id="events-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn btn-default pull-right btn-sm" data-dismiss="modal" title="Cerrar">X</button>
                            </div>
                            <div class="modal-body">
                                <p>One fine body&hellip;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="circle_small center-block" align="center" id="circleLoading">
                    Cargando...
                    <div class="loader_small">
                        <div class="loader_small">
                            <div class="loader_small">
                                <div class="loader_small">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="dataTable0" class="table table-bordered table-hover" width="100%" style="display: none;">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Servicio</td>
                            <td>Cliente</td>
                            <td>Estilista</td>
                            <td>Inicia</td>
                            <td>Finaliza</td>
                            <td>Estado</td>
                            <td></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="subContent"></div>

<script type="text/javascript">
    loadCSS('./views/calendar/tmpls/card.css');//css card
    $.getScript("./views/visit/js/script0.js");
</script>