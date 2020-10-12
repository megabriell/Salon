	var idModal = $('#modal1'),
	idTable2 = $('#dataTable2');
	
	idModal.modal();
	idTable2.DataTable({
        responsive: true,
        paging: false,
        info: false,
        pageLength: false,
        searching: false,
        drawCallback: function(){
            var api = this.api(),
            total = api.column(4, {page:'current'}).data().sum(),//total tabla
            prop = parseInt($('#reward').text()),
            desc = parseFloat($('#discount').text()),
            total = (total+prop-desc),
            total_suma = $.number( total, 2 , ".", ",");
            $('#total').html('Q ' + total_suma );
        },
        "columnDefs": [
        	{ className: "text-right", "targets": [3,4] },
        ]
    });