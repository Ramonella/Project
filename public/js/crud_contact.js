$(document).ready(function () {
		  var id_act;
		  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

	   $('#btn-act').click(function(e){
	      	
			/*if (testEmail.test($('#txtUpEmail').val())){
				e.preventDefault();

	            var formData = {
	              id : id_act,
	              first_name : $('#txtUpFirstName').val(),
	              last_name : $('#txtUpLastName').val(),
	              email : $('#txtUpEmail').val(),
	              phone : $('#txtInputPhone1').val(),
	              company : $('#txtUpCompany').val(),
	              image : 'hola',
	            }

	            $.ajax({
	              type : "GET",
	              url : "update",
	              data : formData, 
	              dataType : 'json',
	              success : function(data){
	                    
	                    $('#user'+id_act).replaceWith('<tr id="user'+id_act+'" data-name="'+data.first_name+'" class="rows"><td> <input type=\'button\' class =\'btn btn-info\' value=\'+\' id=\'btn-detalle\' name=\''+id_act+'\'/></td><td>'+data.first_name+'</td><td>'+data.last_name+'</td><td>'+data.email+'</td><td><input type=\'button\' class =\'btn btn-warning\' value=\'Actualizar\' id=\'btn-actualizar\' name=\''+id_act+'\'/>   <input type=\'button\' class =\'btn btn-danger\' value=\'Eliminar\' id=\'btn-borrar\' name=\''+id_act+'\'/></td>   <tr>');
                        alert("Usuario actualizado!");
                        $('#modal-up-user').modal('toggle');
                                         
	                  
	              },
	              error: function(data){
	              	console.log("error ");
	              }

	            });

	            $('#txtUpFirstName').val('');
	            $('#txtUpLastName').val('');
	            $('#txtUpEmail').val('');
	            $('#txtInputPhone1').val('');
	            $('#txtUpCompany').val('');
        	}
			else{
				alert('Por favor envie una dirección valida de correo');
			}
	      	
			*/
            

      });
	$('#lista').on('click', "#btn-borrar", function(){
		var id_contact = $(this).attr("name");
	
        $.ajax({
        	type : "GET", 
        	url : "delete", 
        	data : { id : id_contact },
        	success : function(data){
        		$('#user'+id_contact).remove();
        		
        	},
        	error : function(data){
        		console.log("error");
        	}

        });
        


    });
    $('#lista').on('click', "#btn-actualizar", function(){
    	var id_contact = $(this).attr("name");
        id_act = id_contact;

		$.ajax({
			type : "GET",
			url : "getContact",
			data : { id : id_contact },
			success : function(data){
				var obj = jQuery.parseJSON(data);
				$('#txtUpFirstName').val(obj.first_name);
				$('#txtUpLastName').val(obj.last_name);
				$('#txtUpEmail').val(obj.email);
				$('#txtInputPhone1').val(obj.phone);
				$('#txtUpCompany').val(obj.company);
				$('#imgUp').attr('src','images/'+obj.image);
				$('#modal-up-user').modal('toggle'); 

	        }

	    });

	});


    $('#lista').on('click', "#btn-detalle", function(){
    	var id_contact = $(this).attr("name");

    	$.ajax({
			type : "GET",
			url : "getContact",
			data : {id : id_contact},
			
			success : function(data){
				var obj = jQuery.parseJSON(data);
				console.log(obj);
				$('#txtGetFirstName').html(obj.first_name);
				$('#txtGetLastName').html(obj.last_name);
				$('#txtGetEmail').html(obj.email);
				$('#txtGetPhone').html(obj.phone);
				$('#txtGetCompany').html(obj.company);
				$('#txtGetCreated').html(obj.created_at);
				$('#txtGetUpdated').html(obj.updated_at);
				$('#modal-ver-user').modal('toggle');  

			}, 
			error : function(data){
				console.log("error");
			}
		});
    });

     $("#formup").submit(function(e){
     	e.preventDefault();
     	var fd = new FormData();
    	var file_data = $('input[type="file"]')[0].files;
    	for(var i = 0;i<file_data.length;i++){
        	fd.append("image", file_data[i]);
    	}
    	var other_data = $('#formup').serializeArray();
    	$.each(other_data,function(key,input){
        	fd.append(input.name,input.value);
    	});
    	$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
    	$.ajax({
	       	url: 'guardar',
	       	data: fd,
	       	contentType: false,
	       	processData: false,
	       	type: 'POST',
	       	success: function(datos){
	       		var data = jQuery.parseJSON(datos);
	           	$('#modal-nuevo-user').modal('toggle');
                $('<tr id="user"'+data.id+' data-name="'+data.first_name+'" class="rows"><td><a href="javascript:void(0)" name="'+data.id+'"" id="btn-detalle"><img src="images/'+data.image+'" class="img-responsive voc_list_preview_img" alt="" title="" ></a></td><td>'+data.first_name+'</td><td>'+data.last_name+'</td><td>'+data.email+'</td><td><input type=\'button\' class =\'btn btn-warning\' value=\'Actualizar\' id=\'btn-actualizar\' name=\''+data.id+'\'/>   <input type=\'button\' class =\'btn btn-danger\' value=\'Eliminar\' id=\'btn-borrar\' name=\''+data.id+'\'/></td>   <tr>').appendTo('#lista');
                $('#txtInputFirstName').val('');
            	$('#txtInputLastName').val('');
            	$('#txtInputEmail1').val('');
            	$('#txtInputPhone').val('');
            	$('#txtInputCompany').val('');
            	$('#image').val('');
      	
        	} ,
        	error: function(data){
        		$('#div-err').html('Por favor adjunte una imagen!');
        		$('#diverr').show();
	        } 
    	});
 

     });
     $('#formupdate').submit(function(e){

		e.preventDefault();
     	var fd = new FormData();
    	var file_data = $('#imageUp')[0].files;
    	for(var i = 0;i<file_data.length;i++){
        	fd.append("image", file_data[i]);
    	}
    	var other_data = $('#formupdate').serializeArray();
    	$.each(other_data,function(key,input){
        	fd.append(input.name,input.value);
    	});
    	
    	fd.append('id', id_act);

    	$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});

    	$.ajax({
	       	url: 'actualizar',
	       	data: fd,
	       	contentType: false,
	       	processData: false,
	       	type: 'POST',
	       	success: function(datos){
	       		console.log(datos);
      	
        	} ,
        	error: function(data){
        		console.log('Ocurrio un error');
    		}
    	});

     });

    $("#btn-modal-new").click(function(){
    	$('#diverr').hide();
    	
    });

    $("#close-up").click(function(){
    		        $('#txtInputFirstName').val('');
	            	$('#txtInputLastName').val('');
	            	$('#txtInputEmail').val('');
	            	$('#txtInputPhone').val('');
	            	$('#txtInputCompany').val('');
	            	$('#image').val('');
    });
    $("#close-down").click(function(){
    		        $('#txtInputFirstName').val('');
	            	$('#txtInputLastName').val('');
	            	$('#txtInputEmail').val('');
	            	$('#txtInputPhone').val('');
	            	$('#txtInputCompany').val('');
	            	$('#image').val('');
    });
    $("#close-up-update").click(function(){
    		        $('#txtUpFirstName').val('');
	            	$('#txtUpLastName').val('');
	            	$('#txtUpEmail').val('');
	            	$('#txtInputPhone1').val('');
	            	$('#txtUpCompany').val('');
	            	$('#imageUp').val('');
    });
    $("#close-down-update").click(function(){
    		        $('#txtUpFirstName').val('');
	            	$('#txtUpLastName').val('');
	            	$('#txtUpEmail').val('');
	            	$('#txtInputPhone1').val('');
	            	$('#txtUpCompany').val('');
	            	$('#imageUp').val('');
    });
    var delay = (function(){
  		var timer = 0;
  		return function(callback, ms){
    	clearTimeout (timer);
    	timer = setTimeout(callback, ms);
  	};
	})();

    $('#search-box').keyup(function () {
    	var busqueda = $(this).val();
  		delay(function(){
      		
  			$.ajax({
				type : "GET",
				url : "buscar",
				data : { nombre : busqueda },
				dataType : 'json',
	        	success: function(data){
	        		$('#id_tbody').html(data.content);
	        	
	        	} ,
	        	error: function(data){

	        		console.log('error');
	        	} 

  			});

    	}, 1000 );
	});

	$('#imageUp').change(function(){
		var fd = new FormData();
    	var file_data = $('#imageUp')[0].files;
    	for(var i = 0;i<file_data.length;i++){
        	fd.append("image", file_data[i]);
    	}
    	var other_data = $('#formupload').serializeArray();
    	$.each(other_data,function(key,input){
        	fd.append(input.name,input.value);
    	});
    	$.ajaxSetup({
    		headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
		});
    	$.ajax({
	       	url: 'subir_temp',
	       	data: fd,
	       	contentType: false,
	       	processData: false,
	       	type: 'POST',
	       	success: function(datos){
	       		$('#imgUp').attr('src','images/tmp/tmp');
        	
        	} ,
        	error: function(data){
        		

        	} 
   		});

	});



});