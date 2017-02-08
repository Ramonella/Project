@foreach($usuarios as $user)

                        <tr id="user{{$user->id}}" data-name="{{$user->nombre}}" class="rows">
                            <td class = "col_image" style="padding:15px 0px 15px 0px;"> 
                                <a href="javascript:void(0)" name='{{$user->id}}' id="btn-detalle">
                                
                                <img src="images/{{$user->image}}" class="img-responsive voc_list_preview_img" alt="" title="" ></a>
                            </td>

                            <td class="col_firstname">{{$user->first_name}}</td>
                            <td class="col_lastname">{{$user->last_name}}</td> 
                            <td class="col_email">{{$user->email}}</td> 
                            <td class="col_country">
                                
                                <a href="javascript:void(0)" class="country" name="{{$user->id}}" id="country" data-latlng="{{$user->latlng}}">{{$user->country_name}}</a>
                                
                            </td>
                            
                            <td class="col_chat">
                                @if(App\User::where('email' , $user->email)->get()->isEmpty())
                                     <a href="#" class="btn btn-primary btn-invite"><span class="glyphicon glyphicon-plus"></span> Invite</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-info btn-chat" name="{{$user->id}}-{{$user->first_name}}" data-auth = "{{ Auth::user()->id }}" data-email="{{$user->email}}"><span class="glyphicon glyphicon-envelope"></span> Chat!</a>
                                @endif

                                
                            </td>
              
                            <td class="col_update">
                                <input type='button' class ='btn btn-warning' value='Update' id='btn-actualizar' name='{{$user->id}}'/> 
                            </td>
                            <td class="col_delete">
                                <input type='button' class ='btn btn-danger' value='Delete' id='btn-borrar' name='{{$user->id}}'/>
                            
                            </td>
                                        
                       
                        </tr>
@endforeach