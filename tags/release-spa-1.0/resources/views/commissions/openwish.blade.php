@extends("common.default")

@section("content")

<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')

    <h2>OpenWish Commission</h2>
    <form action="/admin/commission/saveopenwish" method="POST">
        <div class="row" style="margin: 20px 20px 20px;">
            <div class="col-xs-4" style="padding: 20px; border: 1px solid #aaa; ">
                <div class="row">
                    <div class="col-xs-6" style="text-align: center;">
                        <label class="control-label margin-top">OpenWish Commission</label>
                    </div>
                    <div class="col-xs-6" style="margin-top: 10px;">
                        <input type="text" required
							style="width:100px; float:right"
							name="ow_commission"
							class="form-control col-xs-12"
							value="{{$ow_commision}}" placeholder="20.00 %">
                    </div>
                </div>
                <div id="confirm" style="float: right;">
                    <input type="submit" class="btn btn-green btn-lg" value="Update">
                </div>
            </div>
        </div>
    </form>
	<br><br>


</div>
<meta name="_token" content="{!! csrf_token() !!}"/>
<script type="text/javascript">
$(document).ready(function () {
	//
});
</script>
@stop
