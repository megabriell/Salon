	var frmProfile = $('#frmProfile');

    frmProfile.bootstrapValidator({
		feedbackIcons: {
    		valid: 'fa fa-check',
    		invalid: 'fa fa-times',
    		validating: 'fa fa-refresh'
		},
		fields: {
            avatar:{
                validators:{
                    excluded: false
                }
            },
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
            lname: {
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
            nit: {
                validators: {
                    stringLength: {
                        max: 12,
                        message: 'El campo debe tener entre 4 y 50 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9-]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            address: {
                validators: {
                    stringLength: {
                        max: 80,
                        message: 'El campo debe tener entre 4 y 50 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-_,. ]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un numero de telefono. Formato: (502) 1234-5678'
                    },
                    regexp: {
                        regexp: /^\(\d{3}\) +\d{4}-\d{4}/,
                        message: 'Ingrese un numero telefonico valido. Formato: (502) 1234-5678'
                    },
                    stringLength: {
                        max: 15,
                        message: 'Ingrese un numero telefonico valido. Formato: (502) 1234-5678'
                    }
                }
            },
            email: {
                validators: {
                    stringLength: {
                        max: 50,
                        message: 'El campo debe tener un maximo de 50 caracteres'
                    },
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    emailAddress: {
                        message: 'El valor introducido no es un correo valido'
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
            lPsw: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    }
                }
            },
            newPsw: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    },
                    stringLength: {
                        min: 8,
                        message: 'La contraseña debe tener minimo 8 caracteres'
                    },
                    identical: {
                        field: 'cPsw',
                        message: 'La contraseña no es la misma'
                    },
                    different: {
                        field: 'lPsw',
                        message: 'La nueva contraseña debe ser distinta'
                    }
                }
            },
            cPsw: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    },
                    identical: {
                        field: 'newPsw',
                        message: 'La contraseña no es la misma'
                    }
                }
            }
        }
    }).on('change', '#changepsw', function(event){
        var bootstrapValidator = frmProfile.data('bootstrapValidator');
        if( $(this).is(':checked') ){
            bootstrapValidator.enableFieldValidators('newPsw',true)
            .enableFieldValidators('cPsw',true)
            .enableFieldValidators('lPsw',true);
        }else{
            bootstrapValidator.enableFieldValidators('newPsw',false)
            .enableFieldValidators('cPsw',false)
            .enableFieldValidators('lPsw',false);
        }
    }).on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]').attr('name'),
        form_data = new FormData($form[0]);
        form_data.append(option, '');//option update
        $.ajax({
        	url: "./controllers/profile_controller.php",
        	type: "POST",
        	data:  form_data,
            processData: false,
            contentType: false,
            cache: false,
        	success: function(data){
                data;
        	}
        });
    });

    var img = '';
    $.post("controllers/profile_controller.php", {getInf:''}, function(json){
        $('#name').val(json['Nombre']);
        $('#lname').val(json['Apellido']);
        $('#nit').val(json['NIT']);
        $('#address').val(json['Direccion']);
        $('#email').val(json['CorreoP']);
        $('#phone').val(json['Telefono']);
        $('#user').val(json['Usuario']);
        $('#emailU').val(json['CorreoA']);
        if (json['imgPerfil'] != 'default-avatar.png') {
            img = "<img src='/misc/img/usuario/"+json['imgPerfil']+"' class='img-responsive' alt='avatar' title='avatar'>";
        }
    });//values of input

    loadCSS('./plugins/switch/css/switch.css'); //css switch
    loadCSS('./plugins/bootstrap-fileinput/css/fileinput.min.css'); //css fileinput
    $.getScript("./plugins/bootstrap-fileinput/js/fileinput.js").done(function(script, textStatus){//js fileinput
        $.getScript("./plugins/bootstrap-fileinput/js/locales/es.js").done(function(script, textStatus){
            var btnCust = '<button type="button" class="btn btn-default" title="Quitar foto" ' + 
            'onclick="alert(\'Call your custom code here.\')">' +
            '<i class="glyphicon glyphicon-trash"></i>' +
            '</button>'; 

            $("#avatar").fileinput({
                language: 'es',
                //overwriteInitial: true,
                initialPreview:img,
                showClose: false,
                showCaption: false,
                browseOnZoneClick: true,
                removeLabel: '',
                browseLabel: '',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                elErrorContainer: '#avatarError',
                defaultPreviewContent: '<img src="misc/img/usuario/default-avatar.png"'+
                'class="img-responsive" alt="Your Avatar"><h6 class="text-muted">Click to select</h6>',
                layoutTemplates: {main2: '{preview}' + btnCust + ' {remove} {browse}',actionDelete:''},
                allowedFileExtensions: ["jpg", "png", "gif"]
            });

        });
    });