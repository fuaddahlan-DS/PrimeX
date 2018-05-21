 <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New Member</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal adminex-form" method="get">

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-xs-6 col-sm-5 col-sm-5 control-label">Member ID</label>
                                    <div class="col-xs-6 col-sm-7">
                                        <label class="control-label">{{ (!empty($MemberID) ? $MemberID : '') }}</label>
                                    </div>
                                </div>

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="Enter Name">
                                    </div>
                                </div> 

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Email</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" type="email" placeholder="Enter Email">
                                    </div>
                                </div> 

                                <div class="form-group p-l-1 p-r-1">
                                    <label class="col-sm-5 col-sm-5 control-label">Phone Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="Enter Phone Number">
                                    </div>
                                </div> 

                                <div class="col-sm-12 col-xs-12 text-center"> 
                                    <label class="col-sm-12 col-sm-12 control-label">Car Number: AAA1234</label>
                                </div>  

                            </div> 

                            <div class="col-md-6 col-sm-6 col-xs-12 ">

                                <div class="p-xs-l-1 p-xs-r-1">

                                    <div class="form-group p-l-1 p-r-1">
                                        <label for="exampleInputEmail1">Car Number</label>
                                        <input class="form-control" placeholder="Enter Number Plate">
                                    </div> 

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Car Manufacturer</label>
                                        <select class="form-control m-bot15">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label>Vehicle Type</label>
                                    </div>

                                    <div class="col-md-6  m-xs-b-0 form-group p-l-1 p-r-1 p-xs-b-0">  
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                                Default
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                                Saloon 
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 form-group p-l-1 p-r-1">    
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                                MPV / SUV 
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                                Large / Luxury 
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group p-l-1 p-r-1 p-b-0">
                                        <label for="exampleInputEmail1">Car Color</label>
                                        <select class="form-control m-bot15">
                                            <option>Option 1</option>
                                            <option>Option 2</option>
                                            <option>Option 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="addcar" type="button" class="btn btn-blue" >Add Car</button>
                                    </div>
                                </div> 

                            </div> 

                        </div>

                        <hr>


                        <div class="form-group"> 
                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                <button type="button" class="btn btn-red-primex btn-block" >Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div> 
        </div>
    </div>