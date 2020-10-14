	var idForm = $('#dataFrm0'),
    idModal = $('#modal0'),
    idTable = $('#dataTable0');

    idModal.modal();
    idForm.bootstrapValidator({
		feedbackIcons: {
    		valid: 'fa fa-check',
    		invalid: 'fa fa-times',
    		validating: 'fa fa-refresh'
		},
		fields: {
			descripction_1: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    stringLength: {
                        max: 80,
                        message: 'El campo debe tener un maximo de 50 caracteres'
                    }
                }
            },
            discount: {
                validators: {
                    notEmpty: {
                        message: 'El campo es requerido'
                    },
                    regexp: {
                        //regexp: /^(100(\.0{1,2})?|([0-9]?[0-9](\.[0-9]{1,2})?)%?)$/,
                        regexp: /^(([0-9]?[0-9](\.[0-9]{1,2})?)%)$/,
                        message: 'Debe aplicar un % de descuento, ejemplo 5%'
                    },
                    stringLength: {
                        max: 10,
                        message: 'El campo debe tener un maximo de 50 caracteres'
                    }
                }
            },
        }
    }).on('success.form.bv', function(form){
        form.preventDefault();
        var $form = $(form.target), option = $('#btnFrm_1'),
        form_data = new FormData($form[0]);
        form_data.append(option.attr('name'), '');//option create or update
        form_data.append('modal', '$("#'+idModal.attr('id')+'")');//for hide model when have success
        option.button('loading');
        $.ajax({
        	url: "./controllers/tpay_controller.php",
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