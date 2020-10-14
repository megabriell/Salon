	var frmUser = $('#userForm'),
    modal = $('#userModal'),
    dtable = $('#tableUser');

    modal.modal();
    frmUser.bootstrapValidator({
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
            salary: {
                validators: {
                    numeric: {
                        message : 'Introduze un valor valido'
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
            emailP: {
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
            address: {
                validators: {
                    stringLength: {
                        max: 80,
                        message: 'El campo debe tener entre 4 y 50 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-,_. ]+$/,
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
                        field: 'confirPass',
                        message: 'La contraseña no es la misma'
                    }
                }
            },
            confirPass: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida y no puede estar vacia'
                    },
                    identical: {
                        field: 'pass',
                        message: 'La contraseña no es la misma'
                    }
                }
            },
            'permission[]': {
                container:'#validatioMessage',
                feedbackIcons: 'false',
                validators: {
                    choice: {
                        min: 1,
                        message: 'Debe seleccionar como mínimo 1 permiso'
                    }
                }
            },
            sistema: {
                validators: {
                    hoice: {
                        min: 1,
                        max:2,
                        message: 'Debe seleccionar almenos una opción'
                    },
                    notEmpty: {
                        message: 'Debe seleccionar una opción'
                    }
                }
            },
            'primary[]': {
                excluded:true
            },
            rememberPass: {
                excluded:true
            }
        }
    })
    .on('click', '.next-step', function(e){
        var panel = $(this).parent().parent().parent(),
        inputs = panel.find(".form-control"),
        validFrm = frmUser.data('bootstrapValidator');
        $(inputs).each(function() {
            IDS = $( this ).attr("name");
            frmUser.bootstrapValidator('revalidateField', IDS);
        });
        if(validFrm.isValidContainer(panel)){//si los campos son validos pasa a la siguiente seccion
            var $active = $('.wizard .nav-tabs li.active');//obtiene el panel activo
            $active.next().removeClass('disabled');//elimina la clase ccss disable
            nextTab($active);//se posiciona en el panel(seccion) siguinte
        }
    })
    .on('ifChanged', '#rememberPass', function(event){
        var bootstrapValidator = frmUser.data('bootstrapValidator');
        if(event.target.checked){
            bootstrapValidator.enableFieldValidators('pass',false)
            .enableFieldValidators('confirPass',false);
        }else{
            bootstrapValidator.enableFieldValidators('pass',true)
            .enableFieldValidators('confirPass',true);
        }
    })
    .on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]').attr('name'),
        form_data = new FormData($form[0]);
        form_data.append(option, '');//option create or update
        form_data.append('modal', '$("#'+modal.attr('id')+'")');//for hide model when have success
        $.ajax({
        	url: "./controllers/users_controller.php",
        	type: "POST",
        	data:  form_data,
            processData: false,
            contentType: false,
        	success: function(data){
                data;
                dtable.DataTable().ajax.reload( null, false );
        	}
        });
    });

    $.getScript("../plugins/wizard/wizard.js"); //lib Script for wizard-->
    $.getScript("../plugins/iCheck/icheck.js")//lib for checkbox-->
    .done(function( script, textStatus ) {
        $('input:checkbox').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: '<div class="iradio_square-blue"></div>',
            increaseArea: '20%'
        }).on('ifChanged', function(e) {
            var field = $(this).attr('name');// Get the field name
            frmUser.bootstrapValidator('revalidateField', field);
        });
        $("input:checkbox[name='primary[]']").on('ifChanged', function(event){
            var check = (event.target.checked)? "check" : "uncheck";//valida si esta checkeado
            var inputs = $("[id*=input_"+event.target.id+"_]").iCheck(check);//busca todos los elementos con el id input_ mas el nombre del id obtenido
        });

        var parents = $("input:checkbox[name*='primary[]']") ;
        $( parents ).each(function() {
            var IDS = $( this ).attr("id"),
            count = $("[id*=input_"+IDS+"_]").length,
            number_checked = 0;
            $("[id*=input_"+IDS+"_]").each(function() {
                var element = $( this ).attr("id");
                if( $("#"+element).is(":checked") ){
                    number_checked += 1;
                };
            });
            if (count == number_checked) {
                $( this ).iCheck("check");
            };
        });
    });