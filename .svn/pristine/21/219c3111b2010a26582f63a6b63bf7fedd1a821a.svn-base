<div class='form-modal'>
    <div class="modal fade" id='loginModal'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="close" data-dismiss="modal" type="button"><span>&times;</span></button>

                    <div class="col-md-12 modal-inside">
                        <form  id="loginForm" action="{{ URL::to('LoginUser') }}" method="post"
                              data-bv-message="This value is not valid"
                              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                            <div class="row">
                            <div class="login-content">
                                <h3 style='font-weight: 900'>Log In</h3>
                                <h5>For enquiry please fill in the information below</h5><br>
                                <div id="error-msg" style="text-align: center" class="text-danger"></div>
                                <div class="form-group">
                                    <label class='col-md-4' style='padding-left: 0px'>Username:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <input class="form-control input-sm" name="username"
											placeholder="Type your Username" type="text"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Username is required" >

                                    </div>
                                </div>
                                <div class="height-gap"></div>
                                <div class="form-group">
                                    <label class='col-md-4'  style='padding-left: 0px'>Password:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <input type='password' name="password"
											class="form-control input-sm"  placeholder="Type your Password"
											data-bv-trigger="keyup" required
											data-bv-notempty-message="Password is required">
                                     </div>
                                    <div class="col-md-8 col-sm-offset-4" style='padding-left: 0px'>
                                        <a href="#" style='color:#fff; text-decoration: underline' data-toggle="modal" data-target="#forgotModal">Forgot your password or username?</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="m-footer">
                                <div class="col-md-6" style='text-align: left; padding-left: 0px'>
                                    <h5>
                                        <a style="color:#fff;" href="{{ route('oauth.login', ['facebook']) }}" id="facebooklogin"> <u>Sign in with</u> &nbsp;<span>
                                                <img alt="" src="{{asset('images/fb.png')}}" style='width:40px; height:40px;'>
                                            </span>
                                        </a>
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <button class='btn signInBtn'>Sign In</button>
                                </div>
                            </div>
                        </div>
                            </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class='form-modal'>
    <div class="modal fade" id='forgotModal'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button class="close" data-dismiss="modal" type="button"><span>&times;</span></button>

                    <div class="col-md-12 modal-inside">
                        <form  id="forgotForm"
                               data-bv-message="This value is not valid"
                               data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                               data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                               data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
                        <div class="row">
                            <div class="login-content">
                                <h3 style='font-weight: 900'>My Account ID</h3>

                                <h5>Reset your password here</h5><br>

                                <div class="form-group">
                                    <label class='col-md-4' style='padding-left: 0px'>Username:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <input class="form-control input-sm" name="username" placeholder="Type your username" type="text"
                                               data-bv-trigger="keyup" required data-bv-notempty-message="Username is required">

                                    </div>
                                </div>
                                <div class="height-gap"></div>
                                <div class="form-group">
                                    <label class='col-md-4'  style='padding-left: 0px'>Password:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <input type="password" class="form-control input-sm"
											name="password" placeholder="Type your password" required
											data-bv-notempty-message="The password is required and cannot be empty"
											data-bv-identical="true" data-bv-identical-field="confirmPassword"
											data-bv-identical-message="The password and its confirm are not the same"
											data-bv-different="true" data-bv-different-field="username"
											data-bv-different-message="The password cannot be the same as username"/>

                                    </div>
                                </div>
                                <div class="height-gap"></div>
                                <div class="form-group">
                                    <label class='col-md-4'  style='padding-left: 0px'>Reconfirm:</label>
                                    <div class="col-md-8" style='padding-left: 0px'>
                                        <input type="password" class="form-control input-sm"
											name="confirmPassword" placeholder="Confirm Password" required
											data-bv-notempty-message="The confirm password is required and cannot be empty"
											data-bv-identical="true" data-bv-identical-field="password"
											data-bv-identical-message="The password and its confirm are not the same"
											data-bv-different="true" data-bv-different-field="username"
											data-bv-different-message="The password cannot be the same as username"/>
                                    </div>
                                </div>
                                <div class="height-gap"></div>
                                <div class="form-group">
                                    <label class='col-md-4'  style='padding-left: 0px'>Type:</label>
                                    <div class="col-md-5"  style='padding-left: 0px'>
                                        <select name="type" class="select picker form-control"
                                                data-bv-notempty data-bv-notempty-message="The type is required"
                                                data-style="signInSelect" style='color:#666'>
                                            <option value="">Select Your Option</option>
                                            <option value="Buyer">Buyer</option>
                                            <option value="Dealer">Dealer</option>
                                            <option value="Merchant">Merchant</option>
                                            <option value="Social Media Marketer">Social Media Marketer</option>
                                        </select>

                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style='text-align: left; padding-left: 0px'>
                                Forget your username ?
                            </div>
                            <div class="col-md-6" style='text-align: right; padding-left: 0px'>
                                <button class='btn signInBtn'>Send</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class='col-md-4' style='padding-left: 0px'>Username:</label>
                                <div class="col-md-8" style='padding-left: 0px'>
                                    <input class="form-control input-sm" name="username" placeholder="Type your username" type="text"
                                           data-bv-trigger="keyup" required data-bv-notempty-message="Username is required">
                                </div>
                            </div>
                            <div class="height-gap"></div>
                            <div class="form-group">
                                <label class='col-md-4'  style='padding-left: 0px'>Contact Number:</label>
                                <div class="col-md-8" style='padding-left: 0px'>
                                    <input class="form-control input-sm numeric" name="contact-number"  placeholder="Contact Number" type="text"
                                           data-bv-trigger="keyup" required data-bv-notempty-message="Contact Number is required">
                                    </div>
                                <div class="col-md-8 col-sm-offset-4" style='padding-left: 0px'><p>Our operation will contact you with a short while</p>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class='col-md-4'  style='padding-left: 0px'>Type:</label>
                                <div class="col-md-5"  style='padding-left: 0px'>
                                    <select name="type" class="selectpicker form-control"
                                            data-bv-notempty data-bv-notempty-message="The type is required"
                                            data-style="signInSelect" style='color:#666'>
                                        <option value="">Select Your Option</option>
                                        <option value="Buyer">Buyer</option>
                                        <option value="Dealer">Dealer</option>
                                        <option value="Merchant">Merchant</option>
                                        <option value="Social Media Marketer">Social Media Marketer</option>
                                    </select>

                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="m-footer">
                                <div class="col-md-6" style='text-align: left; padding-left: 0px'>
                                </div>

                                <div class="col-md-6">
                                    <button class='btn signInBtn'>Skip</button> &nbsp;
                                    <button class='btn signInBtn'>Send</button>
                                </div>
                            </div>
                        </div>
                            </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class='form-modal'>
    <div class="modal fade" id='editModel'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background:#fff !important;" id="editbody">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class='form-modal'>
    <div class="modal fade" id='AlertModel'>
        <div class="modal-dialog">
            <div class="modal-content" style="background:#fff !important;">
                <div class="modal-header">
                    <h4 class="modal-title"><strong>Alert!</strong></h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="yes-del" data-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-primary" id="no-del" data-dismiss="modal">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div class='form-modal'>
    <div class="modal fade" id='MessageModel'>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="background:#fff !important;" id="Messagebody">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
