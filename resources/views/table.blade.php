@foreach($usuarios as $user)
                        <tr id="user{{$user->id}}" data-name="{{$user->nombre}}" class="rows">
                            <td style="padding:15px 0px 15px 0px;"> 
                                
                                <a href="javascript:void(0)" name='{{$user->id}}' id="btn-detalle">
                                <img src="images/{{$user->image}}" class="img-responsive voc_list_preview_img" alt="" title="" ></a>
                            </td>

                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td> 
                            <td>{{$user->email}}</td> 
                            <td>
                                
                                <a href="javascript:void(0)" class="country" name="{{$user->id}}" id="country" data-latlng="{{$user->latlng}}">{{$user->country_name}}</a>
                                
                            </td>
              
                            <td class="operaciones">
                                <input type='button' class ='btn btn-warning' value='Actualizar' id='btn-actualizar' name='{{$user->id}}'/> 
                                <input type='button' class ='btn btn-danger' value='Eliminar' id='btn-borrar' name='{{$user->id}}'/>
                            </td> 
                            
                                        
                       
                        </tr>
@endforeach