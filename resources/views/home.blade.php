@extends('layouts.app')

@section('content')

<script type="text/javascript"  src = "js/crud_contact.js"></script>
<div class="container">
<input type="hidden" name="" value="{{Auth::user()->id}}" id="auth_id">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                
                <div class="panel-body">
                    @if(Auth::check())
                    <table class="table table-hover table-striped" id="lista">
                    <thead>
                      <tr>
                        <th>+</th>
                        <th>First Name</th>
                        <th>Last Name</th> 
                        <th>Email Address</th> 
                        <th>Operaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $user)
                        <tr id="user{{$user->id}}" data-name="{{$user->nombre}}" class="rows">
                            <td> <input type='button' class ='btn btn-info' value='+' id='btn-detalle' name='{{$user->id}}'/> </td>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td> 
                            <td>{{$user->email}}</td> 
                            <td class="operaciones">
                                        <input type='button' class ='btn btn-warning' value='Actualizar' id='btn-actualizar' name='{{$user->id}}'/>   
                                        <input type='button' class ='btn btn-danger' value='Eliminar' id='btn-borrar' name='{{$user->id}}'/></td> 
                                        
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                      
                     
                    </table>
                    @endif
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal-nuevo-user">Add new contact</button>

                    <div id="modal-nuevo-user" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Añadir nuevo usuario</h4>
                          </div>
                          <div class="modal-body">
                                      <form id="form_add">
                                      <div class="form-group">
                                        <label for="txtInputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="txtInputFirstName" placeholder="First Name">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputLastName">Last Name</label>
                                        <input type="text" class="form-control" id="txtInputLastName" placeholder="Last Name">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="txtInputEmail1" placeholder="Email">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputPhone">Phone</label>
                                        <input type="text" class="form-control" id="txtInputPhone" placeholder="Phone">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputCompany">Company</label>
                                        <input type="text" class="form-control" id="txtInputCompany" placeholder="Company">
                                      </div>
                                      
                                      <div class="form-group">
                                        <div id="div-image">     

                                      </div>
                                        <form  enctype="multipart/form-data" class="upload-images-form">
                                            <input type="file" name="image[]" multiple>
                                            <input type="button" class="btn btn-default" id='btn-carga' value="Upload"/>
                                        </form>
                                        
                                      </div>

                                      <button type="submit" class="btn btn-default" id="btn-ok">OK</button>
                                    </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                      </div>



                      <div id="modal-up-user" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Actualizar usuario</h4>
                          </div>
                          <div class="modal-body">
                                      <form>
                                      <div class="form-group">
                                        <label for="txtUpFirstName">First Name</label>
                                        <input type="text" class="form-control" id="txtUpFirstName" >
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpLastName">Last Name</label>
                                        <input type="text" class="form-control" id="txtUpLastName" >
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpEmail">Email address</label>
                                        <input type="email" class="form-control" id="txtUpEmail">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputPhone1">Phone</label>
                                        <input type="text" class="form-control" id="txtInputPhone1" placeholder="Phone">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpCompany">Company</label>
                                        <input type="text" class="form-control" id="txtUpCompany">
                                      </div>
                                      

                                      <button type="submit" class="btn btn-default" id="btn-act">OK</button>
                                    </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                      </div>


                        <div id="modal-ver-user" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Detalle usuario</h4>
                              </div>
                              <div class="modal-body">
                                          <form>
                                          <table class="table table-hover table-striped">
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetFirstName">First Name: </label></td>
                                              <td><span class="badge" id="txtGetFirstName"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetLastName">Last Name: </label></td>
                                              <td><span class="badge" id="txtGetLastName"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetEmail">Email: </label></td>
                                              <td><span class="badge" id="txtGetEmail"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetPhone">Phone: </label></td>
                                              <td><span class="badge" id="txtGetPhone"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetCompany">Last Name: </label></td>
                                              <td><span class="badge" id="txtGetCompany"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetCreated">Created at: </label></td>
                                              <td><span class="badge" id="txtGetCreated"></span>
                                              </td>
                                            </div>
                                            </tr>
                                            <tr>
                                            <div class="form-group">
                                              <td> 
                                              <label for="txtGetUpdated">Created at: </label></td>
                                              <td><span class="badge" id="txtGetUpdated"></span>
                                              </td>
                                            </div>
                                            <tr>
                                          </table>
                                          
                                          
                               

                                          
                                        </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div> 

                          </div>
                        </div> 

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
