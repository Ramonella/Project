$(document).ready(function () {
    var id_act;

	$('#lista').on('click', ".btn.btn-danger", function(){
		var id_contact = $(this).attr("name");
	
        var $confirm = $("#modalConfirmYesNo");
    	$confirm.modal('show');
    	$("#lblTitleConfirmYesNo").html("Confirmación");
    	$("#lblMsgConfirmYesNo").html("¿Confirma que desea eliminar el contacto?, este proceso es irreversible");
    	$("#btnYesConfirmYesNo").off('click').click(function () {
        	$confirm.modal("hide");
        	$.ajax({
	        	type : "GET", 
	        	url : "delete", 
	        	data : { id : id_contact },
	        	success : function(data){
                    console.log(data);
	        		$('#user'+id_contact).remove();
	        		
	        	},
	        	error : function(data){
	        		console.log("error");
	        	}
        	});
    	});
    	$("#btnNoConfirmYesNo").off('click').click(function () {
        	$confirm.modal("hide");
    	});


    });
    $('#lista').on('click', ".btn.btn-warning", function(){
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

     function is_User(email){
        var result = 0;
        $.ajax({
            url : 'isUser',
            type : 'GET',
            data : {email : email},
            async : false,
            success : function(data){
                console.log(data);
                result = data;
            }, 
            error : function(data){
                console.log("Error");
            }
        });
        return result;
     }
     $("#formup").submit(function(e){
     	e.preventDefault();
     	var fd = new FormData();
    	var file_data = $('input[type="file"]')[0].files;
    	for(var i = 0;i<file_data.length;i++){
        	fd.append("image", file_data[i]);
    	}
    	var other_data = $('#formup').serializeArray();
    	$.each(other_data,function(key,input){
    		if(input.name == 'slt'){
    			fd.append(input.name+'-code', $('#sel1').find(":selected").data("code"));
    			fd.append(input.name+'-countryname', $('#sel1').find(":selected").data("countryname"));
    			fd.append(input.name+'-latlng', $('#sel1').find(":selected").data("latlng"));
    		} else {
    			fd.append(input.name,input.value);
    		}
        	
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
	       		if(!datos.resp){
                    var data = jQuery.parseJSON(datos);
                    $('#modal-nuevo-user').modal('toggle');
                    var isUser = is_User(data.email);
                    var btnChat = '';
                    console.log(isUser);
                    if(isUser == 1){
                        btnChat = '<a href="#" class="btn btn-primary btn-invite"><span class="glyphicon glyphicon-plus"></span> Invite</a>';
                    } else{
                        btnChat = '<a href="javascript:void(0)" class="btn btn-info btn-chat" name="{{$user->id}}-{{$user->first_name}}" data-auth = "{{ Auth::user()->id }}" data-email="{{$user->email}}"><span class="glyphicon glyphicon-envelope"></span> Chat!</a>';
                    }

                    $('<tr id="user'+data.id+'" data-name="'+data.first_name+'" class="rows"><td style="padding:15px 0px 15px 0px;"><a href="javascript:void(0)" name="'+data.id+'"" id="btn-detalle"><img src="images/'+data.image+'" class="img-responsive voc_list_preview_img" alt="" title="" ></a></td><td>'+data.first_name+'</td><td>'+data.last_name+'</td><td>'+data.email+'</td><td><a href="javascript:void(0)" class="country" name="'+data.id+' id="country" data-latlng="'+data.latlng+'">'+data.country_name+'</a></td><td>'+btnChat+'</td><td><input type=\'button\' class =\'btn btn-warning\' value=\'Actualizar\' id=\'btn-actualizar\' name=\''+data.id+'\'/> </td><td>  <input type=\'button\' class =\'btn btn-danger\' value=\'Eliminar\' id=\'btn-borrar\' name=\''+data.id+'\'/></td>   <tr>').appendTo('#lista');
                    $('#txtInputFirstName').val('');
                    $('#txtInputLastName').val('');
                    $('#txtInputEmail1').val('');
                    $('#txtInputPhone').val('');
                    $('#txtInputCompany').val('');
                    $('#image').val('');
                } else {

                    $('#div-err').html(datos.resp);
                    $('#diverr').show();
                }
	       		
      	
        	} ,
        	error: function(data){
        		console.log('error');
                
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
	       		var data = jQuery.parseJSON(datos);
				$('#user'+id_act).replaceWith('<tr id="user'+id_act+'" data-name="'+data.first_name+'" class="rows"><td style="padding:15px 0px 15px 0px;"><a href="javascript:void(0)" name="'+data.id+'"" id="btn-detalle"><img src="images/'+data.image+'" class="img-responsive voc_list_preview_img" alt="" title="" ></a></td><td>'+data.first_name+'</td><td>'+data.last_name+'</td><td>'+data.email+'</td><td><input type=\'button\' class =\'btn btn-warning\' value=\'Actualizar\' id=\'btn-actualizar\' name=\''+id_act+'\'/>   <input type=\'button\' class =\'btn btn-danger\' value=\'Eliminar\' id=\'btn-borrar\' name=\''+id_act+'\'/></td>   <tr>');
                alert("Usuario actualizado!");
                $('#modal-up-user').modal('toggle');
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
	$('#btn-buscar').click(function(){
		var busqueda = $('#search-box').val();
		console.log(busqueda);
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
        		console.log('Ocurrio un error');	

        	} 
   		});

	});

    var map;
    var lat = 15.5;
    var long = -90.25;
	google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
   		var mapCanvas = document.getElementById('map');
   		var mapOptions = {
      		center: new google.maps.LatLng(15.5, -90.25),
      		zoom: 6,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
   		}
   		map = new google.maps.Map(mapCanvas, mapOptions)
	}
	$('#contact').on('shown.bs.modal', function () {
    	google.maps.event.trigger(map, "resize");
    	var panPoint = new google.maps.LatLng(lat, long);
        map.panTo(panPoint)

        var marker = new google.maps.Marker({
    		position: {lat: parseInt(lat), lng: parseInt(long)},
    		map: map,
    		title: 'Hello World!'
  		});
	});
    $('#lista').on('click', ".country", function(){
    	latlng = $(this).data('latlng');
    	var array = latlng.split(",");
    	
        lat = array[0];
        long = array[1];

    	$('#contact').modal('toggle');

    });

    var socket = io.connect('http://127.0.0.1:3000');

    $('#lista').on('click', '.btn.btn-info.btn-chat', function(e){
        e.preventDefault();
        var name = $(this).attr('name');

        var array = name.split('-');

        var auth = parseInt($(this).data('auth'));

        var email = $(this).data('email');

        var receiver = 0;

        var room = 'room';
        $.ajax({
            url: 'getUserId',
            data: { email : email },
            async : false,
            type: 'GET',
            success: function(data){
                
                receiver = parseInt(data);
                console.log(receiver);
            } ,
            error: function(data){
                console.log("Error");
            } 
        });

         if(auth > receiver){
            room += String(receiver)+'_'+String(auth);
        } else{
            room += String(auth)+'_'+String(receiver);
        }
        var html = '<li class="dropdown" style="display :inline-flex;">'
                  +'<a href="javascript:void(0)" data-toggle="dropdown" class="a_chat"><span class="glyphicon glyphicon-user"></span>'+array[1]+' </a> <button type="button" class="btn btn-default bnt_close_chat"><span class="glyphicon glyphicon-remove"></span> </button>'
                  +'<div class="dropdown-menu" role="menu" style="width : 350px; height: 450px; background-color:white; border-color: #8e44ad">'
                  +'<div style="background-color: steelblue; padding-top: 30px;  padding: 0 15px;  margin: 0 10px;" >'+ array[1] +' </div>'
                  + '<div>'
                  + '<ul style="overflow: auto; height : 320px" id="'+room+'" class="messages_list">'
                  + '</ul>'
                  + '</div>'
                  + '<div class="portlet-footer" >'
                  + '             <form class="conversation-chat">'
                  + '<input type="hidden" name="room" value="'+room+'">'
                  + '                 <div>'
                  + '                   <textarea class="form-control txtchat" placeholder="Enter message..." name="message"></textarea>'
                  + '                </div>'
                  + '                <div>'
                  + '                    <input type="submit" class="btn btn-default pull-right" value="Send">'
                  
                  + '                 </div>'
                  + '              </form>'
                  + '</div>'
                  + '</div>'
                  + '</li>';

        
        if($("#" + room).length == 0) {
            //it doesn't exist
            $("#chat").append(html);


            //Retrieve all chat
    
            $.ajax({
                url : 'getMessages',
                data : { room : room },
                type : 'GET',
                success : function(data){
                    var obj = jQuery.parseJSON(data);

                    $.each(obj, function(index, value){
                        console.log(index, value.message );
                        $("#"+room).append('<li data-time="'+index+'" data-user="'+value.user+'" data-message="'+value.message+'">'+ index + ' <b>' +value.user + ' says: </b>'+value.message+'</li>');
                    });
                }, 
                error : function(data){

                }

            });


        }
       


       $('#'+room).dropdown('toggle');
       socket.emit('room', room);
    

    });
    

    socket.on('message', function(data) {
        console.log(data.message, data.room);
        var auth = parseInt($(this).data('auth'));
         $("#"+data.room).append('<li data-time="'+data.time+'" data-user="'+data.user+'" data-message="'+data.message+'">'+ data.time + ' ' +data.user + ' says: '+data.message+'</li>');
        
         
         if(auth ==data.user){

         }else{

            $("#"+data.room).parent().parent().parent().css('background-color', 'lightcoral');
         }
    });

    $('#chat').on('click', '.a_chat', function(){
        //console.log('hola');
        $(this).parent().css('background-color', 'transparent');
    });

    $('#chat').on('submit', '.conversation-chat', function(e){
                e.preventDefault();
                var room = $(this).find('input[name="room"]').val();
                var message = $(this).find('textarea[name="message"]').val();
                var user_name = $('#user_name').val();
                var dt = new Date();
                var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                socket.emit('send.message', {
                    room : room,
                    message : message,
                    user : user_name,
                    time : time
                });
                $(this).find('textarea[name="message"]').val('');
    });



    $("#send_messages").click(function(){
        console.log("Sent messages!");
        var jsonObj = {};

        $(".messages_list").each(function(){
            var room = $(this).attr('id'); 
            var roomJson = {};
            roomJson[room] = {};
            
            $(this).find('li').each(function(){
                //console.log($(this).data('time'), ' ', room);
                var time = $(this).data('time');
                var user = $(this).data('user');
                var message = $(this).data('message');
                var messageJson = {};
                var timestamp = {};
                messageJson["message"] = message;
                messageJson["user"] = user;
                timestamp[time] = messageJson;
                $.extend(roomJson[room], timestamp);          
                
            });
            $.extend(jsonObj, roomJson);
              
        });
        //Here it sends the json!
        var json = JSON.stringify(jsonObj);
        //console.log(json);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        $.ajax({
            url : 'setMessages',
            type : 'POST',
            data :  {datos : json},
            
            success : function(data){

                console.log(data);
            }, 
            error : function(data){

            }
        });
    });
    //Events that fire the storage of chats
    $('#get_messages').click(function(){

    });

    //Close 
    $('#chat').on('click', '.btn.btn-default.bnt_close_chat', function(){
        console.log("Sent messages!");
        var jsonObj = {};

        $(".messages_list").each(function(){
            var room = $(this).attr('id'); 
            var roomJson = {};
            roomJson[room] = {};
            
            $(this).find('li').each(function(){
                //console.log($(this).data('time'), ' ', room);
                var time = $(this).data('time');
                var user = $(this).data('user');
                var message = $(this).data('message');
                var messageJson = {};
                var timestamp = {};
                messageJson["message"] = message;
                messageJson["user"] = user;
                timestamp[time] = messageJson;
                $.extend(roomJson[room], timestamp);          
                
            });
            $.extend(jsonObj, roomJson);
              
        });
        //Here it sends the json!
        var json = JSON.stringify(jsonObj);
        //console.log(json);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 
        $.ajax({
            url : 'setMessages',
            type : 'POST',
            data :  {datos : json},
            
            success : function(data){

                console.log(data);
            }, 
            error : function(data){

            }
        });
        $(this).parent().remove();
    });
});