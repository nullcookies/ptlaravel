<table>
	<tr>
		<td>{{$message}}consignment <strong>{{$delivery->consignment_number}}</strong></td>
	</tr>
	<tr>
		<td><input type="text" name="skeyb" class="skeyb form-control" id="skeyb">
		</td>
		<input type="hidden" name="oid" class="oid" id="cncpoid" value="{{$delivery->porder_id}}">
		<input type="hidden" name="cn" class="cn" id="cn" value="{{$delivery->consignment_number}}">
		<input type="hidden" name="type" class="type" id="cncptype" value="{{$delivery->type}}">
	</tr>
	<tr>
		<td>{{$message_name}}</td>
	</tr>
	<tr>
		<td><input type="text" name="dname" class="dname form-control" id="dname">
		</td>
	</tr>
	<tr>
		<td>{{$message_nric}}</td>
	</tr>
	<tr>
		<td><input type="text" name="nric" class="nric form-control" id="nric">
		</td>
	</tr>	
</table>