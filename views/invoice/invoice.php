<?php include_once dirname(__file__,3)."/config/session.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-tag"></i>
                <h3 class="box-title">Facturas registradas</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Nuevo Registro" onclick="add()" id="btn1">
                        <i class="fa fa-plus"></i> Agregar
                    </button>
                </div>
            </div>
            <div class="box-body" id="box_body">
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
                            <td>Cliente</td>
                            <td>Pago</td>
                            <td>Fecha</td>
                            <td>Total</td>
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
    $.getScript("./views/invoice/js/script0.js");
</script>
