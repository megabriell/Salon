<?php
    include_once dirname(__file__,3)."/config/Conexion.php";
    $db = new Conexion();
    $infoCompany = $db->infoCompany();
?>
<!DOCTYPE html>
<html>
<head>

    <title><?php echo $infoCompany['Empresa'] ?></title>
    <meta http-equiv="Content-Language" content="es"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="../../misc/img/sistema/<?php echo $infoCompany['favicon']?>" type="image/png">

    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../template/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../plugins/bootstrap/css/font-awesome.min.css">
</head>
<body class="hold-transition register-page">
    <div class="register-box">

        <div class="register-box-body">
            <p class="login-box-msg">Registrarse por primera vez</p>
            <form id="userForm" autocomplete="off">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="lName" id="lName"  placeholder="Apellido">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="user" id="user"  placeholder="Usuario de acceso">
                    <span class="glyphicon glyphicon glyphicon-off form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="emailU" id="emailU"  placeholder="Correo de acceso">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="pass" name="pass" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="confirPass" id="confirPass" placeholder="Confirma la contraseña">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <!--<label>
                                <input type="checkbox"> I agree to the <a href="#">terms</a>
                            </label>-->
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-primary btn-block btn-flat" value="Register" name="register">
                    </div>
                </div>
            </form>

            <a href="../../" class="text-center">login</a>
        </div>
    </div>

    <script src="../../plugins/jQuery/jquery-3.2.1.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../plugins//Jquery-confirm/jquery-confirm.min.css">
    <script src="../../plugins/Jquery-confirm/jquery-confirm.min.js"></script>
    <script src="../../plugins/bootstrapvalidator/js/bootstrapValidator.min.js"></script>

    <script>
    $('#userForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        min: 4,
                        max: 50,
                        message: 'El campo debe tener entre 4 y 50 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ_. ]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            lName: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        min: 4,
                        max: 50,
                        message: 'El campo debe tener entre 4 y 50 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ_. ]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            user: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        min: 3,
                        max: 15,
                        message: 'El campo debe tener entre 3 y 20 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_.]+$/,
                        message: 'Solo introduzca caracteres alfanumericos'
                    }
                }
            },
            emailU: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        max: 50,
                        message: 'El campo debe tener un maximo de 50 caracteres'
                    },
                    emailAddress: {
                        message: 'El valor introducido no es un correo valido'
                    }
                }
            },
            pass: {
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    },
                    stringLength: {
                        min: 8,
                        message: 'La contraseña debe tener minimo 8 caracteres'
                    },
                    identical: {
                        field: 'confirPass',
                        message: 'La contraseña no es la misma'
                    }
                }
            },
            confirPass: {
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    },
                    identical: {
                        field: 'pass',
                        message: 'La contraseña no es la misma'
                    }
                }
            }
        }
    }).on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]').attr('name'),
        form_data = new FormData($form[0]);
        form_data.append(option, '');//option create or update
        $.ajax({
            url: "../../controllers/users_controller.php",
            type: "POST",
            data:  form_data,
            processData: false,
            contentType: false,
            success: function(data){
                data;
            }
        });
    });
    </script>
</body>
</html>
