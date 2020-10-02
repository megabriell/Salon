<?php
    include_once dirname(__file__,3).'/models/menu.php';

?>

<div class="modal" tabindex="-1" id="userModal" data-backdrop="false" data-keyboard="true" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"><!-- content modal -->
            <div class="modal-body"><!-- body modal -->
                <div class="wizard"><!-- wizard -->
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist"><!-- nab-tabs -->
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Paso 1">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Paso 2">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-earphone"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Paso 3">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-lock"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Paso 4">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-check"></i>
                                    </span>
                                </a>
                            </li>
                        </ul><!-- end nab-tabs -->
                    </div>

                    <form role="form" class="form-horizontal" id="userForm" autocomplete="off"><!-- form -->
                        <div class="tab-content"><!-- tab-content wizard -->
                            <div class="tab-pane active" role="tabpanel" id="step1">
                                <div class="text-center"><p><b>Paso 1: </b>Identificación</p></div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del trabajador">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lname" class="col-sm-2 control-label">Apellido</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Apellido del trabajador">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nit" class="col-sm-2 control-label">NIT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT (Opcional)" maxlength="12">
                                    </div>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button></li>
                                    <li><button type="button" class="btn btn-primary next-step">Siguiente</button></li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="step2">
                                <div class="text-center"><p><b>Paso 2: </b>Contacto</p></div>
                                <div class="form-group">
                                    <label for="phone" class="col-sm-2 control-label">Telefono</label>
                                    <div class="col-sm-10">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefono personal con Formato (502) 1234-56789">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="emailP" class="col-sm-2 control-label">Correo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="emailP" name="emailP" placeholder="Correo personal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Dirección (Opcional)" maxlength="80">
                                    </div>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button></li>
                                    <li><button type="button" class="btn btn-default prev-step">Regresar</button></li>
                                    <li><button type="button" class="btn btn-primary next-step">Siguiente</button></li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="step3">
                                <div class="text-center"><p><b>Paso 3: </b>Usuario de acceso</p></div>
                                <div class="form-group">
                                    <label for="user" class="col-sm-2 control-label">Usuario</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="user" name="user" placeholder="Usuario de acceso alternativo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="emailU" class="col-sm-2 control-label">Correo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="emailU" name="emailU" placeholder="Correo de acceso">
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                        <label>
                                            <input type="checkbox" id="rememberPass" name="rememberPass" disabled=""> Usar contraseña almacenada
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pass" class="col-sm-2 control-label">Contraseña</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="pass" name="pass" autocomplete="false" placeholder="Contraseña de acceso">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirPass" class="col-sm-2 control-label">Confirmar</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="confirPass" name="confirPass" autocomplete="false" placeholder="Confirmar Contraseña">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sistema" class="col-sm-2 control-label">Rol</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="sistema" name="sistema">
                                            <option value="" selected="selected" disabled="disabled">--Seleccione una opcion---</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Estilista</option>
                                            <option value="3">Cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button></li>
                                    <li><button type="button" class="btn btn-default prev-step">Regresar</button></li>
                                    <li><button type="button" class="btn btn-primary next-step">Siguiente</button></li>
                                </ul>
                            </div>

                            <div class="tab-pane" role="tabpanel" id="complete">
                                <div class="text-center"><p><b>Paso 4: </b>Permisos</p>
                                    <span class="help-block" id="validatioMessage"></span>
                                </div>

                                <div class="row" id="Input_permiso" style="padding: 0 15px;">
                                    <div class="form-group"><table width="100%"><tbody>
                                    <?php
                                        $menu = new Menu();
                                        $arrayMenu = $menu->readMenu();
                                        $menu = $arrayMenu[0];//get data of cache
                                        $SubMenu = $arrayMenu[1];//get data of cache

                                        $i = 0; $j = 0;
                                        foreach ($menu as $key => $value) {
                                            $idCheckParent = str_replace(' ', '', $key);
                                            echo  ($i % 3 == 0)?  "<tr>":'';
                                            echo '<td style="border: 1px solid #c9c9c9;padding-top:5px" valign="top" ><div class="col-sm-12">
                                                <label style="border-bottom: 2px solid #c9c9c9; width: 100%" class="permission">
                                                    <input type="checkbox" id="'.$idCheckParent.'" name="primary[]" >'.$key.'
                                                </label><br>';
                                            unset($value["icon"]);
                                            foreach ($value as $subKey => $subVal) {
                                                $j++;
                                                echo '<label class="permission">
                                                    <input type="checkbox" id="input_'.$idCheckParent."_".$j.'" value="'.$subKey.'" name="permission[]">'.$SubMenu[$subKey]["Descripcion"].'
                                                </label><br>';
                                            }
                                            echo '</div></td>';
                                            $i++;
                                        }
                                    ?>
                                    </tr></tbody></table></div>
                                    <style type="text/css">
                                        .form-group.has-success .permission{color:#333!important;}
                                        .form-group.has-error .permission{color:#a94442!important;}
                                    </style>
                                </div>
                                <ul class="list-inline pull-right">
                                    <li><button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancelar</button></li>
                                    <li><button type="button" class="btn btn-default prev-step">Regresar</button></li>
                                    <li><input type="submit" class="btn btn-success" name="create" value="Finalizar"></li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- end tab-content wizard -->
                    </form><!-- end form -->
                </div><!-- End wizard -->
            </div><!-- End body modal -->
        </div><!-- End content modal -->
    </div>
</div>

<link rel="stylesheet" href="../plugins/wizard/wizard.css"><!-- lib style for wizard-->
<link href="../plugins/iCheck/square/blue.css" rel="stylesheet"><!-- lib style for checkbox -->
<script>
    $.getScript("./views/user/js/script.js").done(function( script, textStatus ) {
        frmUser.data('bootstrapValidator').enableFieldValidators('pass',true)
            .enableFieldValidators('confirPass',true);
    });
</script>