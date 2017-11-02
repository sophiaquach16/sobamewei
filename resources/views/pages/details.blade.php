@extends('layouts.default')
@section('content')

@if( $eS )

@if($eS->ElectronicType_name === "Desktop")
<div class="text-center">
    <h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="row detailContainer">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="col-md-6">
            @if ( $eS->image && $eS->image !== null )
            <img src="{{$eS->image}}" width="500" height="auto" align="right">
            @endif
        </div>
        <div class="col-md-4"> <br><br>
            <b>Dimension</b>: {{$eS->dimension}} cm<br>
            <b>Weight</b>: {{$eS->weight}} kg<br>
            <b>RAM size</b>: {{$eS->ramSize}} GB<br>
            <b>Number of CPU cores</b>: {{$eS->cpuCores}}<br>
            <b>Hard Drive Size</b>: {{$eS->hdSize}} GB<br>
            <b>Price</b>: ${{$eS->price}}<br>
        </div>
    </div>

    <div class="col-md-1"></div>
</div>
@endif

@if($eS->ElectronicType_name === "Monitor")
<div class="text-center">
    <h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="row detailContainer">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="col-md-6">
            @if ( $eS->image && $eS->image !== null )
            <img src="{{$eS->image}}" width="500" height="auto" align="right">
            @endif
        </div>
        <div class="col-md-4"> <br><br>
            <b>Dimension</b>: {{$eS->dimension}} in<br>
            <b>Weight</b>: {{$eS->weight}} kg<br>
            <b>RAM size</b>: {{$eS->ramSize}} GB<br>
            <b>Price</b>: ${{$eS->price}}<br>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>


</div>
@endif

@if($eS->ElectronicType_name === "Laptop")
<div class="text-center">
    <h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="row detailContainer">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="col-md-6">
            @if ( $eS->image && $eS->image !== null )
            <img src="{{$eS->image}}" width="500" height="auto" align="right">
            @endif
        </div>
        <div class="col-md-4"> <br><br>
            <b>Dimension</b>: {{$eS->dimension}} cm <br>
            <b>Display Size</b>: {{$eS->displaySize}} in<br>
            <b>Weight</b>: {{$eS->weight}} kg<br>
            <b>RAM size</b>: {{$eS->ramSize}} GB<br>
            <b>Number of CPU cores</b>: {{$eS->cpuCores}}<br>
            <b>Hard drive size</b>: {{$eS->hdSize}}<br>
            <b>Battery information</b>: {{$eS->batteryInfo}}<br>
            <b>Processor Type</b>: {{$eS->processorType}} <br>
            <b>Built-in Operation System</b>: {{$eS->os}} <br>
            <b>Camera</b>:
            @if(($eS->camera) === "1")
            Yes
            @elseif(($eS->camera) === "0")
            No
            @endif<br>
            <b>Touchscreen</b>:
            @if(($eS->touchScreen) === "1")
            Yes
            @elseif(($eS->touchScreen) === "0")
            No
            @endif<br>
            <b>Price</b>: ${{$eS->price}}<br>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@endif

@if($eS->ElectronicType_name === "Tablet")
<div class="text-center">
    <h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="row detailContainer">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <div class="col-md-6">
            @if ( $eS->image && $eS->image !== null )
            <img src="{{$eS->image}}" width="500" height="auto" align="right">
            @endif
        </div>
        <div class="col-md-4"><br><br>
            <b>Dimension</b>: {{$eS->dimension}} cm<br>
            <b>Display Size</b>: {{$eS->displaySize}} in<br>
            <b>Weight</b>: {{$eS->weight}} kg<br>
            <b>Processor</b>: {{$eS->processorType}}<br>
            <b>RAM Size</b>: {{$eS->ramSize}} GB<br>
            <b>CPU Cores</b>: {{$eS->cpuCores}}<br>
            <b>Hard drive size</b>: {{$eS->hdSize}}<br>
            <b>Battery Information</b>: {{$eS->batteryInfo}}<br>
            <b>Operating System</b>: {{$eS->os}}<br>
            <b>Camera</b>:
            @if(($eS->camera) === "1")
            Yes
            @elseif(($eS->camera) === "0")
            No
            @endif<br>
            <b>Price</b>: ${{$eS->price}}
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@endif
<br><br><br><br>
@endif

<div class="row">
    <div class="text-center">
        <a href="/add-to-cart?eSId={{$eS->id}}" class="btn btn-success btn-lg" role="button"> Add To Cart </a>
        <br/>
        <br/>
        
        @if(isset($previousESId) && $previousESId > 0)
        <a href="/details?id={{$previousESId}}" class="btn btn-info" role="button"> &laquo; Previous Result </a>
        @endif

        @if(isset($nextESId) && $nextESId > 0)
        <a href="/details?id={{$nextESId}}" class="btn btn-info" role="button"> Next Result &raquo; </a>
        @endif

        <br/>
        <br/>
        @if(isset($queryStringBack))
        <a href="/?{{$queryStringBack}}" class="btn btn-info" role="button"> Back to Filtering Result </a>
        @else
        <a href="/" class="btn btn-info" role="button"> Back to Catalog </a>
        @endif
    </div>
</div>
@stop
