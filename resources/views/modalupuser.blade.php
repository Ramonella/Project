
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