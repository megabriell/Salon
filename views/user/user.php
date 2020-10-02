<?php include_once dirname(__file__,3)."/config/session.php"; ?>
<script>$.getScript("./views/user/js/funtions.js")</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-users"></i>
                <h3 class="box-title">Usuarios Registrados</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Agregar empleado" onclick="add()">
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
                <table id="tableUser" class="table table-bordered table-hover" width="100%" style="display: none;">
                    <thead>
                        <tr>
                            <td>Codigo Usuario</td>
                            <td>Nombre</td>
                            <td>Usuario</td>
                            <td>Correo Electronico</td>
                            <td>Rol-Sistema</td>
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
		var datacol = new Array('./controllers/users_controller.php',
			[
				{'data':'IdEmpleado'},
				{'data':'nombre'},
				{'data':'usuario'},
				{'data':'correo'},
                {'data':'sistema'},
				{'data':'boton'}
			],
            '',
            {getData:''}
		);
		tableSimple('#tableUser',datacol,[true,true,25],'',false);
</script>
