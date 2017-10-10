@extends('layouts.default')
@section('content')
<div class="text-center"><h2 class="blueTitle">Inventory</h2></div>
<table>
    <tr>
        <th>Dimension</th>
        <th>Weight</th>
        <th>Model Number</th>
        <th>Brand Name</th>
        <th>Hard drive size</th>
        <th>Price</th>
        <th>Processor Type</th>
        <th>Ram Size</th>
        <th>CPU Cores</th>
        <th>Battery Info</th>
        <th>OS</th>
        <th>Camera</th>
        <th>Touch Screen</th>
        <th>Electronic Type</th>
    </tr>
	@if (! empty($items))
    @foreach ($items as $item)
    <tr>
        <td>
		@if ($item->dimension ) 
		{{$item->dimension}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->weight ) 
		{{$item->weight}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->modelNumber ) 
		{{$item->modelNumber}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->brandName ) 
		{{$item->brandName}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->hdSize ) 
		{{$item->hdSize}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->price ) 
		{{$item->price}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->processorType ) 
		{{$item->processorType}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->ramSize ) 
		{{$item->ramSize}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->cpuCores ) 
		{{$item->cpuCores}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->batteryInfo ) 
		{{$item->batteryInfo}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->os ) 
		{{$item->os}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->camera ) 
		{{$item->camera}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->touchScreen ) 
		{{$item->touchScreen}}
		@else
		N/A
		@endif
		</td>
        <td>
		@if ( $item->name ) 
		{{$item->name}}
		@else
		N/A
		@endif
		</td>
    </tr>
    @endforeach
	@endif
    
</table>
@stop