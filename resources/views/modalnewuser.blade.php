
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