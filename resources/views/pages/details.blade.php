@extends('layouts.default')
@section('content')

@if( $eS )

@if($eS->ElectronicType_name === "Desktop")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<div class="attributes">Dimension:</div>
<div class="values">{{$eS->dimension}} cm</div>
<br>
<div class="attributes">Weight:</div>
<div class="values">{{$eS->weight}} kg</div>
<br>
<div class="attributes">Number of CPU cores:</div>
<div class="values">{{$eS->cpuCores}}</div>
<br>
<div class="attributes">Hard Drive Size:</div>
<div class="values">{{$eS->hdSize}} GB</div>
<br>
<div class="attributes">Price:</div>
<div class="values">${{$eS->price}}</div>
<br>
@endif

@if($eS->ElectronicType_name === "Monitor")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<div class="attributes">Dimension:</div>
<div class="values">{{$eS->dimension}} cm</div>
<br>
<div class="attributes">Weight:</div>
<div class="values">{{$eS->weight}} kg</div>
<br>
<div class="attributes">RAM size:</div>
<div class="values">{{$eS->ramSize}} GB</div>
<br>
<div class="attributes">Price:</div>
<div class="values">${{$eS->price}}</div>
<br>
@endif

@if($eS->ElectronicType_name === "Laptop")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<div class="attributes">Dimension:</div>
<div class="values">{{$eS->dimension}} cm</div>
<br>
<div class="attributes">Display Size:</div>
<div class="values">{{$eS->displaySize}} cm</div>
<br>
<div class="attributes">Weight:</div>
<div class="values">{{$eS->weight}} kg</div>
<br>
<div class="attributes">RAM size:</div>
<div class="values">{{$eS->ramSize}} GB</div>
<br>
<div class="attributes">Number of CPU cores:</div>
<div class="values">{{$eS->cpuCores}}</div>
<br>
<div class="attributes">Hard Drive Size:</div>
<div class="values">{{$eS->hdSize}} GB</div>
<br>
<div class="attributes">Battery information:</div>
<div class="values">{{$eS->batteryInfo}}</div>
<br>
<div class="attributes">Processor Type:</div>
<div class="values">{{$eS->processorType}}</div>
<br>
<div class="attributes">Built-in Operation System:</div>
<div class="values">{{$eS->os}}</div>
<br>
<div class="attributes">Camera:</div>
<div class="values">
  @if(($eS->camera) === "1")
    yes
  @elseif(($eS->camera) === "0")
    no
  @endif
</div>
<br>
<div class="attributes">Touchscreen:</div>
<div class="values">
  @if(($eS->touchScreen) === "1")
    Yes
  @elseif(($eS->touchScreen) === "0")
    No
  @endif
</div>
<br>
<div class="attributes">Price:</div>
<div class="values">${{$eS->price}}</div>
<br>
@endif

@if($eS->ElectronicType_name === "Tablet")
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<div class="attributes">Dimension:</div>
<div class="values">{{$eS->dimension}} cm</div>
<br>
<div class="attributes">Display Size:</div>
<div class="values">{{$eS->displaySize}} in</div>
<br>
<div class="attributes">Weight:</div>
<div class="values">{{$eS->weight}} kg</div>
<br>
<div class="attributes">RAM size:</div>
<div class="values">{{$eS->ramSize}} GB</div>
<br>
<div class="attributes">Number of CPU cores:</div>
<div class="values">{{$eS->cpuCores}}</div>
<br>
<div class="attributes">Hard Drive Size:</div>
<div class="values">{{$eS->hdSize}} GB</div>
<br>
<div class="attributes">Battery information:</div>
<div class="values">{{$eS->batteryInfo}}</div>
<br>
<div class="attributes">Processor Type:</div>
<div class="values">{{$eS->processorType}}</div>
<br>
<div class="attributes">Built-in Operation System:</div>
<div class="values">{{$eS->os}}</div>
<br>
<div class="attributes">Camera:</div>
<div class="values">
  @if(($eS->camera) === "1")
    yes
  @elseif(($eS->camera) === "0")
    no
  @endif
</div>
<br>
<div class="attributes">Price:</div>
<div class="values">${{$eS->price}}</div>
<br>
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
