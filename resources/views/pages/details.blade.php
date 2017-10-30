@extends('layouts.default')
@section('content')

@if( $eS )

@if($eS->ElectronicType_name === "Desktop")
<div class="text-center">
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
    <!--Insert image here!-->
    </div>
    <div class="col-md-4"> <br><br>
  Dimension: {{$eS->dimension}} cm<br>
  Weight: {{$eS->weight}} kg<br>
  RAM size: {{$eS->ramSize}} GB<br>
  Number of CPU cores: {{$eS->cpuCores}}<br>
  Hard Drive Size: {{$eS->hdSize}} GB<br>
  Price: ${{$eS->price}}<br>
    </div>
  </div>
</div>

@endif

@if($eS->ElectronicType_name === "Monitor")
<div class="text-center">
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <!--Insert image here!-->
    </div>
    <div class="col-md-4"> <br><br>
  Dimension: {{$eS->dimension}} in<br>
  Weight: {{$eS->weight}} kg<br>
  RAM size: {{$eS->ramSize}} GB<br>
  Price: ${{$eS->price}}<br>
    </div>
  </div>
</div>
@endif

@if($eS->ElectronicType_name === "Laptop")
<div class="text-center">
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <!--Insert image here!-->
      </div>
      <div class="col-md-4"> <br><br>
        Dimension: {{$eS->dimension}} cm <br>
        Display Size: {{$eS->displaySize}} in<br>
        Weight: {{$eS->weight}} kg<br>
        RAM size: {{$eS->ramSize}} GB<br>
        Number of CPU cores: {{$eS->cpuCores}}<br>
        Hard drive size: {{$eS->hdSize}}<br>
        Battery information: {{$eS->batteryInfo}}<br>
        Processor Type: {{$eS->processorType}} <br>
        Built-in Operation System: {{$eS->os}} <br>
        Camera:
        @if(($eS->camera) === "1")
          yes
        @elseif(($eS->camera) === "0")
          no
        @endif<br>
        Touchscreen:
        @if(($eS->touchScreen) === "1")
          yes
        @elseif(($eS->touchScreen) === "0")
          no
        @endif<br>
        Price: ${{$eS->price}}<br>
      </div>
    </div>
  </div>
@endif

@if($eS->ElectronicType_name === "Tablet")
<div class="text-center">
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <!-- Add image here! -->
    </div>
    <div class="col-md-4"><br><br>
      Dimension: {{$eS->dimension}} cm<br>
      Display Size: {{$eS->displaySize}} in<br>
      Weight: {{$eS->weight}} kg<br>
      Processor: {{$eS->processorType}}<br>
      RAM Size: {{$eS->ramSize}} GB<br>
      CPU Cores: {{$eS->cpuCores}}<br>
      Hard drive size: {{$eS->hdSize}}<br>
      Battery Information: {{$eS->batteryInfo}}<br>
      Operating System: {{$eS->os}}<br>
      Camera:
      @if(($eS->camera) === "1")
        yes
      @elseif(($eS->camera) === "0")
        no
      @endif<br>
      Price: ${{$eS->price}}
    </div>
  </div>
</div>
@endif
<br><br><br><br>
@endif

<div class="container">
  <div class="text-center">
@if($previousESId > 0)
<a href="/details?id={{$previousESId}}" class="btn btn-info" role="button"> &laquo; Previous Result </a>
@endif

@if($nextESId > 0)
<a href="/details?id={{$nextESId}}" class="btn btn-info" role="button"> Next Result &raquo; </a>
@endif

<br/>
<br/>
<a href="/?{{$queryStringBack}}" class="btn btn-info" role="button"> Back to Filtering Result </a>
  </div>
</div>
@stop
