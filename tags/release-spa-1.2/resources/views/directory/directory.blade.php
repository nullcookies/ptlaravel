@extends("common.default")

<style type="text/css" media="screen">
    .select2-container--classic,.select2-selection--single{
        border:2px solid #1ABC9C;
        border-radius:0px !important;
    }
</style>
@section("content")
<div class="container">
    <div class="custom-container">
        <div class="col-sm-12">
			{{--
            <div class="row" style="margin-top:1.5em;">
                <img class="img-responsive"
				src="{{ asset('images/leather.png')}}"
				alt="Your Jumbotran Photo goes here">
            </div>
			--}}
            <div class="row">
            <div data-spy="scroll" class="static-tab side-static-nav" style="display: block;">
                <div class="text-center tab-arrow">
                   <span class="fa fa-sort"></span>
                </div>
                <ul class="nav nav-pills nav-stacked">
                   <li role="presentation" class="floor-navigation"><a href="#A-D">A-D</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#E-H">E-H</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#I-L">I-L</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#M-P">M-P</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#Q-T">Q-T</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#U-X">U-X</a></li>
                   <li role="presentation" class="floor-navigation active"><a href="#Y-Z">Y-Z</a></li>
                </ul>
            </div>

                <div class="margin-top"></div>
                <div class="col-md-10 pull-left">
                    <h1>Directory</h1>
                </div>
                <div class="col-md-2 pull-right">
                    <a href="#" id="registration-section" class="btn btn-default custom-button-directory margin-top" data-toggle="modal" data-target="#directoryModel" >Register</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
              @if (Session::has('success'))
                  <div class="alert alert-success" style="margin-top:10px;">
                     {!! Session::get('success') !!}
                  </div>
              @endif
            </div>
            <?php $old_o = "";
$counter = 0;?>
            @if (isset($directories) && !empty($directories))
               @foreach ($directories as $key => $value)
                    @foreach ($value as $column => $row)
                        <div class="row">
                            <div class="col-md-12" id="{!! $key !!}">
                                <dl>
                                    <dt>
                                        @if ($counter == 0)
                                            <h2>{!! $row['occupation_name'] !!}</h2>
                                            <?php $old_o = $row['occupation_name'];?>
                                        @endif

                                        @if ($old_o == $row['occupation_name'])
                                        @elseif ($old_o != $row['occupation_name'])
                                            <h2>{!! $row['occupation_name'] !!}</h2>
                                            <?php $old_o = $row['occupation_name'];?>
                                        @endif
                                    </dt>
                                    <dd>
                                        {!! $row['company'] !!}
                                        <br>
                                        {!! $row['custom_address'] !!}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <?php $counter = 1;?>
                    @endforeach
                    <?php $counter = 0;?>
                @endforeach
            @endif
            <hr>
        </div>
    </div>
</div>
<!-- Modal -->
{!! Form::open(array('method'=>'POST','url'=>'directory','class'=>'form-horizontal')) !!}
<div class="modal fade" id="directoryModel" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       @if ($errors->any())
            <div class="modal-content">
       @else
            <div class="modal-content">
       @endif
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title" id="myModalLabel">
                    Directory Registration
                </h2>
                <h5 class="modal-title">
                    Welcome to OpenSupermall.com!<br>
                    For registration please fill information below.
                </h5>
             </div>
             <div class="modal-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                   @foreach ($errors->all() as $error)
                   {!! $error !!}<br/>
                   @endforeach
                </div>
                @endif
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Name:</label>
                    <div class="col-md-8">
                        {!! Form::text("company", Input::old('company'), array('class'=>'form-control border-color')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label style="padding-top:0" class="col-md-4 control-label">Company Registration No:</label>
                    <div class="col-md-8">
                        {!! Form::text("business_reg_no", Input::old('business_reg_no'), array('class'=>'form-control border-color')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Contact No:</label>
                    <div class="col-md-8">
                        {!! Form::text("phone", Input::old('phone'), array('class'=>'form-control border-color')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Address:</label>
                    <div class="col-md-8">
                        {!! Form::textarea("address", Input::old('address'), array('class'=>'form-control border-color', 'rows'=>4)) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Company Email:</label>
                    <div class="col-md-8">
                        {!! Form::text("email", Input::old('email'), array('class'=>'form-control border-color')) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Occupation:</label>
                    <div class="col-md-8">
                        {!! Form::select("occupation_id", array(''=>'Select Here')+$professional, null,array("class"=>'form-control border-color select2')) !!}
                    </div>
                </div>
             </div>
             <div class="modal-footer">
                <div class="col-md-2 pull-right" id="register">
                    {!! Form::submit("Register", array("class"=>'btn btn-default custom-button-directory')) !!}
                </div>
             </div>
          </div>
       </div>
    </div>
</div>
{!! Form::close() !!}


@stop
@section('script')
@parent
<script type="text/javascript">
    $('body').on("click touchstart", "#registerButton", function(e){
       $(".directory, .registration").toggle();
    });

   $(document).ready(function() {
    var error = {!! !empty($errors->any()) ? 1 : 0 !!}
        if(error){
            $("#directoryModel").modal('show');
        }

    $(".select2").select2({
      placeholder: "Select Here",
      width:'100%',
      theme: "classic",
    });

   });
</script>
@stop
