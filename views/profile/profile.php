<?php include_once dirname(__file__,3)."/config/session.php"; ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body" id="box_body">
                <div class="row">

                    <style>
                        .kv-avatar {
                            display: inline-block;
                        }
                        .kv-avatar .file-input {
                            display: table-cell;
                            width: 213px;
                        }
                    </style>
                    <form class="form form-vertical" id="frmProfile" autocomplete="off" enctype="multipart/form-data">
                        <div class="col-sm-4 text-center">
                            <div class="kv-avatar">
                                <div class="file-loading">
                                    <input id="avatar" name="avatar" type="file">
                                </div>
                            </div>
                            <div><small>Select file < 10 MB</small></div>
                            <div id="avatarError" class="center-block" ></div>
                        </div>

                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nombre a mostrar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname">Apellido</label>
                                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Apellido a mostrar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Correo Personal</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Correo personal de contacto">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Teléfono Personal</label>
                                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Teléfono personal de contacto">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nit">NIT</label>
                                        <input type="tex" class="form-control" name="nit" id="nit" placeholder="NIT (Opcional)"  maxlength="12">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Dirección</label>
                                        <input type="tex" class="form-control" name="address" id="address" placeholder="Dirección (Opcional)"  maxlength="80">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="user">Usuario</label>
                                        <input type="text" class="form-control" name="user" id="user" placeholder="Usuario de acceso">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="emailU">correo</label>
                                        <input type="email" class="form-control" name="emailU" id="emailU" placeholder="Correo de acceso">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <b>Cambiar contraseña</b>
                                    <li class="list-group-item" style="padding-left:35%;padding-right:35%;">
                                        NO/SI
                                        <div class="material-switch pull-right" >
                                            <input id="changepsw" name="changepsw" type="checkbox" />
                                            <label for="changepsw" class="label-primary"></label>
                                        </div>
                                    </li>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lPsw">Contraseña actual</label>
                                        <input type="password" class="form-control" name="lPsw" id="lPsw" placeholder="********">
                                    </div>
                                </div>
                            </div>
                            <div class="row psw">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="newPsw">Nueva contraseña</label>
                                        <input type="password" class="form-control" name="newPsw" id="newPsw" placeholder="********">
                                    </div>
                                </div>
                                <div class="col-sm-6 psw">
                                    <div class="form-group">
                                        <label for="cPsw">Confirmar nueva contraseña</label>
                                        <input type="password" class="form-control" name="cPsw" id="cPsw" placeholder="********">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <hr>
                                <div class="text-right">
                                    <input type="submit" class="btn btn-primary" value="Actualizar" name="update">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="subContent"></div>

<script>
    $.getScript("./views/profile/js/script.js")
</script>


                        