@extends('layouts.default')
@section('content')

@if( $eS )

@if($eS->ElectronicType_name === "Desktop")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<p>
  Dimension: {{$eS->dimension}} cm<br>
  Weight: {{$eS->weight}} kg<br>
  RAM size: {{$eS->ramSize}} GB<br>
  Number of CPU cores: {{$eS->cpuCores}}<br>
  Hard Drive Size: {{$eS->hdSize}} GB<br>
  Price: ${{$eS->price}}<br>
</p>

@endif

@if($eS->ElectronicType_name === "Monitor")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<p>
  Dimension: {{$eS->dimension}} in<br>
  Weight: {{$eS->weight}} kg<br>
  RAM size: {{$eS->ramSize}} GB<br>
  Price: ${{$eS->price}}<br>
</p>
@endif

@if($eS->ElectronicType_name === "Laptop")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<!-- Show more details here -->
@endif

@if($eS->ElectronicType_name === "Tablet")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<!-- Show more details here -->
@endif

@endif


@if($previousESId > 0)
<a href="/details?id={{$previousESId}}" class="btn btn-info" role="button"> &laquo; Previous Result </a>
@endif

@if($nextESId > 0)
<a href="/details?id={{$nextESId}}" class="btn btn-info" role="button"> Next Result &raquo; </a>
@endif

<br/>
<br/>
<a href="/?{{$queryStringBack}}" class="btn btn-info" role="button"> Back to Filtering Result </a>

@stop
