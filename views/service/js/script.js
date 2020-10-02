	var idForm = $('#dataFrm0'),
    idModal = $('#Modal0'),
    idTable = $('#dataTable0');

    idModal.modal();
    idForm.bootstrapValidator({
		feedbackIcons: {
    		valid: 'fa fa-check',
    		invalid: 'fa fa-times',
    		validating: 'fa fa-refresh'
		},
		fields: {
			descripction: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        max: 50,
                        message: 'El campo debe tener un maximo de 50 caracteres'
                    }
                }
            },
            cost: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    numeric: {
                        message : 'Introduze un valor valido'
                    }
                }
            },
            price: {
                validators: {
                     notEmpty: {
                        message: 'El campo es requerido'
                    },
                    numeric: {
                        message : 'Introduze un valor valido'
                    }
                }
            },
            duration: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    regexp: {
                        regexp: /^(0?[1-9]|1[1-9]|2[0123]|00)(:[0-5]\d)$/,
                        message: 'Solo se permiten numeros,'
                    }
                }
            },
            state: {
                enabled: false,
                validators: {
                    hoice: {
                        min: 1,
                        message: 'Debe seleccionar almenos una opción'
                    },
                    notEmpty: {
                        message: 'Debe seleccionar una opción'
                    }
                }
            }
        }
    }).on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]'),
        form_data = new FormData($form[0]);
        form_data.append(option.attr('name'), '');//option create or update
        form_data.append('modal', '$("#'+idModal.attr('id')+'")');//for hide model when have success
        option.button('loading');
        $.ajax({
        	url: "./controllers/service_controller.php",
        	type: "POST",
        	data:  form_data,
            processData: false,
            contentType: false,
        	success: function(data){
                data;
                option.button('reset');
                idTable.DataTable().ajax.reload( null, false );
        	}
        });
    });


    loadCSS('./plugins/timepicker/bootstrap-timepicker.min.css'); //css fileinput
    $.getScript("./plugins/timepicker/bootstrap-timepicker.min.js").done(function(script, textStatus){
        $('#duration').timepicker({
            defaultTime: '01:00',
            minuteStep: 5,
            showInputs: false,
            modalBackdrop: true,
            showSeconds: false,
            showMeridian: false
        }).on('changeTime.timepicker', function(e) {
            idForm.bootstrapValidator('revalidateField', 'duration');
        })
    });