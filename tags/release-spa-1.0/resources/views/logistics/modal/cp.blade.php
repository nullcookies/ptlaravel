<table>
	<tr>
		<td>{{$message}}consignment <strong>{{$delivery->consignment_number}}</strong></td>
	</tr>
	<tr>
		<td><input type="text" name="skey" class="skey form-control" id="skey">
		</td>
		<input type="hidden" name="oid" class="oid" id="cncpoid" value="{{$delivery->porder_id}}">
		<input type="hidden" name="cn" class="cn" id="cn" value="{{$delivery->consignment_number}}">
		<input type="hidden" name="type" class="type" id="cncptype" value="{{$delivery->type}}">
	</tr>
</table>