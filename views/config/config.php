<?php include_once dirname(__file__,3)."/config/session.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-users"></i>
                <h3 class="box-title">Configuraciones Generales</h3>
            </div>
            <div class="box-body" id="box_body">
                <div class="row">

                    <div class="col-sm-6">
                        <form class="form-horizontal" id="frmCompany" autocomplete="off">
                            <input type="hidden" name="id" id="id">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="company" class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company" id="company" placeholder="Nombre de la empresa">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address" id="address" placeholder="Dirección de la empresa">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tel" class="col-sm-2 control-label">Teléfono</label>
                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" name="tel" id="tel" placeholder="Teléfono de la empresa">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Correo</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Correo de la empresa">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nit" class="col-sm-2 control-label">NIT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nit" id="nit" placeholder="NIT de la empresa">
                                    </div>
                                </div>

                            </div>
                            <div class="box-footer pull-right">
                                <input type="submit" name="update" class="btn btn-primary" value="Actualizar">
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-6">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1" data-toggle="tab" aria-expanded="true">
                                        Imagen principal
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_2" data-toggle="tab" aria-expanded="true">
                                        Imagen segundaria
                                    </a>
                                </li>
                                <li>
                                    <a href="#tab_3" data-toggle="tab">
                                        Favicon
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane text-center active" id="tab_1">
                                    Logo general, sera mostrado en reportes y pantallas grandes
                                    <div class="file-loading">
                                        <input type="file" name="imgP" id="imgP" accept="image/*" >
                                    </div>
                                </div>

                                <div class="tab-pane text-center" id="tab_2">
                                    Logo para dispositivos mobiles y pantallas pequeñas
                                    <div class="file-loading">
                                        <input type="file" name="imgS" id="imgS" accept="image/*" >
                                    </div>
                                </div>

                                <div class="tab-pane text-center" id="tab_3">
                                    Logo para mostrar en la web(Internet) mas conocido como favicon.
                                    <div class="file-loading">
                                        <input type="file" name="favicon" id="favicon" accept="image/*" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="subContent"></div>

<script>
    $.getScript("./views/config/js/script.js")
</script>


                        