@extends('layouts.app')

@section('content')
<script type="text/javascript"  src = "js/crud_contact.js"></script>

<script src='http://maps.googleapis.com/maps/api/js'></script>

<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>


<style type="text/css">

#map{
  height: 300px;
  width: 600px;  
}

</style>
<input type="hidden" id="user_name" value="{{ Auth::user()->name }}">

<div class="container-fluid scrollable" style="padding-top : 60px; padding-bottom: 30px">

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
    
<input type="button" id="send_messages" value="Send messages!">
<input type="button" id="get_messages" value="Get messages!">




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
                        <th>Invite or chat</th> 
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody id="id_tbody">
                        @include('table', ['usuarios' => $usuarios])
                    </tbody>
                      
                     
                    </table>
                    @endif

                    
                </div>
            </div>
        </div>
    </div>



</div>

<nav class="navbar navbar-default navbar-fixed-bottom" style="background-color: transparent;
   background: transparent;
   border-color: transparent; padding-right:25px">
    <ul class="nav navbar-nav navbar-right" id="chat">

        
    </ul>
</nav>




@include('modalnewuser');                  
  

@include('modalupuser');


@include('modalveruser');


@include('modalsmapconfirm')




@endsection


