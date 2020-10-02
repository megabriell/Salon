	var idForm = $('#dataFrm1'),
    idModal = $('#Modal1'),
    idTable = $('#dataTable1');

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
            state_1: {
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
        var $form = $(form.target), option = $('#btnFrm_1'),
        form_data = new FormData($form[0]);
        form_data.append(option.attr('name'), '');//option create or update
        form_data.append('modal', '$("#'+idModal.attr('id')+'")');//for hide model when have success
        option.button('loading');
        $.ajax({
        	url: "./controllers/category_controller.php",
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