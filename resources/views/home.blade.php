@extends('layouts.app')

@section('content')
<script type="text/javascript"  src = "js/crud_contact.js"></script>

<script src='http://maps.googleapis.com/maps/api/js'></script>

<style type="text/css">

#map{
  height: 300px;
  width: 600px;  
}

</style>


<div class="container">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="input-group" id="adv-search">
                <input type="text" class="form-control" id="search-box" placeholder="Search for contacts" />
                <div class="input-group-btn">
                    <div class="btn-group" role="group">

                        <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true" id="btn-buscar"></span></button>
                    </div>
                </div>
            </div>
            <span id="display"></span>
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
                        <th>Country</th> 
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody id="id_tbody">
                        @include('table', ['usuarios' => $usuarios])
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
                                        <label for="sel1">Select country (select one):</label>
                                          <select class="form-control" id="sel1" name="slt">
                                            @foreach($countries as $country)
                                                                                             
                                                  
                                              <option data-code ="{{$country['numericCode']}}" data-latlng="{{implode(',', $country['latlng'])}}"  data-countryname = {{$country['name']}}>
                                              {{$country['name']}}
                                              </option>
                                            @endforeach
                                          </select>
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
                            <button type="button" class="close" data-dismiss="modal" id="close-up-update">&times;</button>
                            <h4 class="modal-title">Actualizar usuario</h4>
                          </div>
                          <div class="modal-body">
                                      <form id="formupdate" enctype="multipart/form-data" method="POST">
                                      <div class="form-group">
                                        <label for="txtUpFirstName">First Name</label>
                                        <input type="text" class="form-control" id="txtUpFirstName" name = "txtUpFirstName">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpLastName">Last Name</label>
                                        <input type="text" class="form-control" id="txtUpLastName" name = "txtUpLastName">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpEmail">Email address</label>
                                        <input type="email" class="form-control" id="txtUpEmail" name = "txtUpEmail">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtInputPhone1">Phone</label>
                                        <input type="text" class="form-control" id="txtInputPhone1" name = "txtUpPhone">
                                      </div>
                                      <div class="form-group">
                                        <label for="txtUpCompany">Company</label>
                                        <input type="text" class="form-control" id="txtUpCompany" name = "txtUpCompany">
                                      </div>
                                      <div class="form-group">
                                        <img src="" class="img-responsive voc_list_preview_img" alt="" title="" id="imgUp">
                                      </div>
                                      <div class="form-group">
                                        <input type="file" name="image" id = "imageUp" multiple>
                                      </div>

                                      <div class="form-group">
                                        <div class="alert alert-danger" id="diverr">
                                            <strong id="strerr">Error!</strong> <div id="div-err"></div>
                                        </div>     

                                      </div>

                                      <button type="submit" class="btn btn-default" id="btn-act">OK</button>
                                    </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="close-down-update">Close</button>
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
                                              <label for="txtGetCompany">Company: </label></td>
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


<div id="modalConfirmYesNo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" 
                class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="lblTitleConfirmYesNo" class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p id="lblMsgConfirmYesNo"></p>
            </div>
            <div class="modal-footer">
                <button id="btnYesConfirmYesNo" 
                type="button" class="btn btn-primary">Yes</button>
                <button id="btnNoConfirmYesNo" 
                type="button" class="btn btn-default">No</button>
            </div>
        </div>
    </div>
</div>

      <div class="modal fade" id="contact" role="dialog" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="back" >  
                    <div class="modal-header">
                    <h4>Mapa<h4>
                </div>
                <div class="modal-body">    
                    <div id="map"></div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Close</a>
                </div>      
            </div>
</div>



@endsection


