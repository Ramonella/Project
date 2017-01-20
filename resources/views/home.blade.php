@extends('layouts.app')

@section('content')
<script type="text/javascript"  src = "js/crud_contact.js"></script>



<div class="container">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="input-group" id="adv-search">
                <input type="text" class="form-control" placeholder="Search for contacts" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form">
                                  <div class="form-group">
                                    <label for="filter">Filter by</label>
                                    <select class="form-control">
                                        <option value="0" selected>All Snippets</option>
                                        <option value="1">Featured</option>
                                        <option value="2">Most popular</option>
                                        <option value="3">Top rated</option>
                                        <option value="4">Most commented</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="contain">Author</label>
                                    <input class="form-control" type="text" />
                                  </div>
                                  <div class="form-group">
                                    <label for="contain">Contains the words</label>
                                    <input class="form-control" type="text" />
                                  </div>
                                  <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                </form>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
<div>
    <br>
    <center><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal-nuevo-user" id="btn-modal-new">Add new contact</button></center>
    <br>
</div>
    



<input type="hidden" name="" value="{{Auth::user()->id}}" id="auth_id">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">List of your contacts</div>
                
                <div class="panel-body">
                    @if(Auth::check())
                    <table class="table table-hover table-striped" id="lista">
                    <thead>
                      <tr>
                        <th>Image</th>
                        
                        <th>First Name</th>
                        <th>Last Name</th> 
                        <th>Email Address</th> 
                        <th>Operaciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $user)
                        <tr id="user{{$user->id}}" data-name="{{$user->nombre}}" class="rows">
                            <td style="padding:15px 0px 15px 0px;"> 
                                <!--<a href="xy" title="">-->
                                <a href="javascript:void(0)" name='{{$user->id}}' id="btn-detalle">
                                <img src="images/{{$user->image}}" class="img-responsive voc_list_preview_img" alt="" title="" ></a>
                            </td>
                            <!--<td> <input type='button' class ='btn btn-info' value='+' id='btn-detalle' name='{{$user->id}}'/> </td> -->
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td> 
                            <td>{{$user->email}}</td> 

              
                            <td class="operaciones">
                                        <input type='button' class ='btn btn-warning' value='Actualizar' id='btn-actualizar' name='{{$user->id}}'/>   
                                        <input type='button' class ='btn btn-danger' value='Eliminar' id='btn-borrar' name='{{$user->id}}'/></td> 
                                        
                       
                        </tr>
                    @endforeach
                    </tbody>
                      
                     
                    </table>
                    @endif


                    <div id="modal-nuevo-user" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" id='close-up' >&times;</button>
                            <h4 class="modal-title">Añadir nuevo usuario</h4>
                          </div>
                          <div class="modal-body">
                                <form id="formup" enctype="multipart/form-data" method="POST">
                                        
                                      <div class="form-group">
                                        <label for="txtInputFirstName">First Name</label>
                                        <input type="text" class="form-control" id="txtInputFirstName" name="txtInputFirstName" placeholder="First Name">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputLastName">Last Name</label>
                                        <input type="text" class="form-control" id="txtInputLastName" name="txtInputLastName" placeholder="Last Name">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="txtInputEmail1" name="txtInputEmail" placeholder="Email">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputPhone">Phone</label>
                                        <input type="text" class="form-control" id="txtInputPhone" name="txtInputPhone" placeholder="Phone">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputCompany">Company</label>
                                        <input type="text" class="form-control" id="txtInputCompany" name="txtInputCompany" placeholder="Company">
                                      </div>
                                      
                                   
                                      <div class="form-group">
                                        <input type="file" name="image" id = "image" multiple>
                                      </div>

                                      <div class="form-group">
                                        <div class="alert alert-danger" id="diverr">
                                            <strong id="strerr">Error!</strong> <div id="div-err"></div>
                                        </div>     

                                      </div>


                                      <button type="submit" class="btn btn-default" id="btn-ok">OK</button>
                                      </form>
                                     </div>       
                                                  
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id='close-down'>Close</button>
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
