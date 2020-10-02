	var dataForm = $('#frmCompany');

    dataForm.bootstrapValidator({
		feedbackIcons: {
    		valid: 'fa fa-check',
    		invalid: 'fa fa-times',
    		validating: 'fa fa-refresh'
		},
		fields: {
            id: {
                validators: {
                    excluded: false,
                    notEmpty: {
                        message: 'El campo es requerido'
                    }
                }
            },
			company: {
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
                        regexp: /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_,. ]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            address: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        min: 4,
                        max: 100,
                        message: 'El campo debe tener entre 4 y 100 caracteres'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0123456789_. ]+$/,
                        message: 'Introduzca caracteres validos'
                    }
                }
            },
            tel: {
                validators: {
                    notEmpty: {
                        message: 'Debe ingresar un numero de telefono. Formato: (502) 1234-5678'
                    },
                    regexp: {
                        regexp: /^\(502\) +\d{4}-\d{4}/,
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
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        max: 100,
                        message: 'El campo debe tener un maximo de 100 caracteres'
                    },
                    emailAddress: {
                        message: 'El valor introducido no es valido'
                    }
                }
            },
            nit: {
                validators: {
                    notEmpty: {
                        message: 'El campos es requerido'
                    },
                    stringLength: {
                        max: 10,
                        message: 'El campo debe tener un maximo de 10 caracteres'
                    },
                    regexp: {
                        regexp: /^[0-9-]+$/,
                        message: 'El valor introducido no es valido'
                    }
                }
            }
        }
    })
    .on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('input[type="submit"]').attr('name'),
        form_data = new FormData($form[0]);
        form_data.append(option, '');//option update
        $.ajax({
        	url: "./controllers/config_controller.php",
        	type: "POST",
        	data:  form_data,
            processData: false,
            contentType: false,
        	success: function(data){
                data;
        	}
        });
    });

    $.post("controllers/config_controller.php", {getInf:''}, function(json){
        $('#id').val(json[5]);
        $('#company').val(json[0]);
        $('#address').val(json[1]);
        $('#tel').val(json[2]);
        $('#email').val(json[3]);
        $('#nit').val(json[4]);
    });//values of input

    var initial = [];
    $.post("controllers/config_controller.php", {getImg:''}, function(json){initial=json});//get images
    loadCSS('./plugins/bootstrap-fileinput/css/fileinput.min.css'); //css fileinput
    $.getScript("./plugins/bootstrap-fileinput/js/fileinput.js").done(function(script, textStatus){//js fileinput
        $.getScript("./plugins/bootstrap-fileinput/js/locales/es.js").done(function(script, textStatus){

            fileint($('#imgP'), initial['initialPreview'][0], initial['initialPreviewConfig'][0], initial['btndisable'][0]);

            fileint($('#imgS'), initial['initialPreview'][1], initial['initialPreviewConfig'][1], initial['btndisable'][1]);

            fileint($('#favicon'), initial['initialPreview'][2], initial['initialPreviewConfig'][2], initial['btndisable'][2]);

        });
    });
    var fileint = function(selector,Preview,PreviewConfig,showbtn) {
        selector.fileinput({
            initialPreview: Preview,
            initialPreviewConfig: [ PreviewConfig ],
            language: 'es',
            uploadUrl: 'controllers/config_controller.php',
            uploadExtraData: {
                'uploadFile': '',
            },
            showCaption: showbtn,
            showBrowse: showbtn,
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'ico']
        }).on('filebeforedelete', function() {
            return new Promise(function(resolve, reject) {
                $.confirm({
                    title: '¡Advertencia!',
                    content: '¿Está seguro de eliminar la imagen, este proceso es irreversible?',
                    type: 'red',
                    buttons: {   
                        ok: {
                            btnClass: 'btn-primary text-white',
                            keys: ['enter'],
                            action: function(){
                                resolve();
                            }
                        },
                        cancel: function(){
                        }
                    }
                });
            });
        }).on('filedeleted', function(event, key, jqXHR, data) {
            selector.fileinput('refresh',{showCaption:true,showBrowse:true}).removeClass('file-no-browse');
        }).on('fileuploaded', function(event, previewId, index, fileId) {
            selector.fileinput('refresh',{showCaption:false,showBrowse:false,showUpload:false,showRemove:false});
            $.alert({
                title: false,
                content: 'La imagen se ha cargado correctamente. Debe refrescar la'+
                ' pagina para ver los cambios.',
                autoClose: 'Ok|10000',
                type: 'green',
                typeAnimated: true,
                buttons: {
                    Ok: function () {}
                }
            });
        });
    };