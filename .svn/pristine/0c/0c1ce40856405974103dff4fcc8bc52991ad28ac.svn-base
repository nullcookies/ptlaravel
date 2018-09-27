
The password for the below order is {{ $password }}
<table>
<?php $counter = 1;?>
@foreach($email->deliveryorder->products as $product)
<tr>
	<td>{{ $counter++ }}.{{ $product->product->name }}</td>
	<td>{{ $product->quantity or 0 }}</td>
	<td>{{ $product->product->retail_price }}</td>
	<td>{{ $product->quantity * $product->product->retail_price }}</td>
</tr>
@endforeach
</table>