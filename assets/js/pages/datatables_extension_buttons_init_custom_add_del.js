/* ------------------------------------------------------------------------------
*
*  # Buttons extension for Datatables. Init examples
*
*  Specific JS code additions for datatable_extension_buttons_init.html page
*
*  Version: 1.0
*  Latest update: Nov 9, 2015
*
* ---------------------------------------------------------------------------- */

$(function() { 


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        }
    }); 

    // Basic initialization
    $('.datatable-button-init-basic').DataTable({
        buttons: {
            dom: {
                button: {
                    className: 'btn btn-default'
                }
            },
            buttons: [
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel'},
                {extend: 'pdf'},
                {extend: 'print'}
            ]
        }
    });


   /*  datatables_extension_buttons_init_custom*/
	
	
	

    // Buttons collection
    $('.datatable-button-init-collection').DataTable({
        buttons: [{
                extend: 'collection',
                text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                className: 'btn bg-blue btn-icon',
                buttons: [
                    {
                        text: 'Toggle first name',
                        action: function ( e, dt, node, config ) {
                            dt.column( 0 ).visible( ! dt.column( 0 ).visible() );
                        }
                    },
                    {
                        text: 'Toggle status',
                        action: function ( e, dt, node, config ) {
                            dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                        }
                    }
                ]
            }
        ]
    }); 
	
	

    // Page length
    $('.datatable-button-init-length').DataTable({
        dom: '<"datatable-header"fB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            {
                extend: 'pageLength',
                className: 'btn bg-slate-600'
            }
        ]
    });



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


    // Enable Select2 select for the length option
   
    
});


 $(document).ready(function() {   
	$('.datatable-button-init-custom').DataTable({
		buttons: [{
			text: '<i class="glyphicon glyphicon-remove-circle position-left"></i>Delete',
			className: 'btn border-slate text-slate-800 btn-flat mrglft5',
			action: function(e, dt, node, config) {
				/*swal({
					title: "Good job!",
					text: "Custom button activated",
					confirmButtonColor: "#66BB6A",
					type: "success"
				});*/
				var cstm_frm_name = document.getElementById("cstm_frm_name").value;
				  
				operate_multi_deletions(cstm_frm_name);
			}
		}, { 
			text: '<i class="glyphicon glyphicon-plus position-left"></i>New',
			className: 'btn border-slate text-slate-800 btn-flat mrglft5',
			action: function(e, dt, node, config) {
				var cstm_add_link = document.getElementById("add_new_link").value;
				window.location = cstm_add_link;
				/*swal({
					title: "Good job!",
					text: "Custom button activated",
					confirmButtonColor: "#66BB6A",
					type: "success"
				});*/
			}  
		} 
		] 	 
	});
	
	$('.datatable-button-init-custom tbody').on('click', 'tr', function() {
        $(this).toggleClass('success');
    }); 
	
	
	 
	 $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
	
	
});

 

function reload_datatable_button_init_custom(){
	
	 $(document).ready(function() {   
		$('.datatable-button-init-custom').DataTable({
			buttons: [{
				text: '<i class="glyphicon glyphicon-remove-circle position-left"></i>Delete',
				className: 'btn border-slate text-slate-800 btn-flat mrglft5',
				action: function(e, dt, node, config) {
					/*swal({
						title: "Good job!",
						text: "Custom button activated",
						confirmButtonColor: "#66BB6A",
						type: "success"
					});*/ 
					var cstms_frm_name = document.getElementById("cstm_frm_name").value;
					operate_multi_deletions(cstms_frm_name);
				}
			}, { 
				text: '<i class="glyphicon glyphicon-plus position-left"></i>New',
				className: 'btn border-slate text-slate-800 btn-flat mrglft5',
				action: function(e, dt, node, config) {
					var cstm_add_link = document.getElementById("add_new_link").value;
					window.location = cstm_add_link;
					/*swal({
						title: "Good job!",
						text: "Custom button activated",
						confirmButtonColor: "#66BB6A",
						type: "success"
					});*/
				}  
			} 
			] 	 
		}); 
		
		 
		$('.dataTables_length select').select2({
			minimumResultsForSearch: Infinity,
			width: 'auto'
		}); 
		   
	});	 
}