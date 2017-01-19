$(document).ready(function () {
		  var id_act;
		  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	      $('#btn-ok').click(function(e){
	      	
			if (testEmail.test($('#txtInputEmail1').val())){
				e.preventDefault();

	            var formData = {
	              first_name : $('#txtInputFirstName').val(),
	              last_name : $('#txtInputLastName').val(),
	              email : $('#txtInputEmail1').val(),
	              phone : $('#txtInputPhone').val(),
	              company : $('#txtInputCompany').val(),
	              user_id :  $('#auth_id').val(),
	              image : 'hola',
	            }

	            $.ajax({
	              type : "GET",
	              url : "add",
	              data : formData, 
	              dataType : 'json',
	              success : function(data){
	                  
	                  
	                  $('#modal-nuevo-user').modal('toggle');
	                  $('<tr id="user"'+data.id+' data-name="'+data.first_name+'" class="rows"><td> <input type=\'button\' class =\'btn btn-info\' value=\'+\' id=\'btn-detalle\' name=\''+data.id+'\'/></td><td>'+data.first_name+'</td><td>'+data.last_name+'</td><td>'+data.email+'</td><td><input type=\'button\' class =\'btn btn-warning\' value=\'Actualizar\' id=\'btn-actualizar\' name=\''+data.id+'\'/>   <input type=\'button\' class =\'btn btn-danger\' value=\'Eliminar\' id=\'btn-borrar\' name=\''+data.id+'\'/></td>   <tr>').appendTo('#lista');

	              },
	              error: function(data){
	              	console.log("error ");
	              }

	            });

	            $('#txtInputFirstName').val('');
	            $('#txtInputLastName').val('');
	            $('#txtInputEmail1').val('');
	            $('#txtInputPhone').val('');
	            $('#txtInputCompany').val('');
        	}
			else{
				alert('Por favor envie una dirección valida de correo');
			}
	      	

            

      });
	   $('#btn-act').click(function(e){
	      	
			if (testEmail.test($('#txtUpEmail').val())){
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








});