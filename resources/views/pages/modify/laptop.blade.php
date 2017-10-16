@extends('layouts.modify')
@section('content')
<div class="row">
    <div class="items text-center"><span class="blueTitle">MODIFY LAPTOP</span></div>
</div>

<input type="hidden" name="ElectronicType_id" value=2>

<div class="form-group">
    <label class="control-label col-sm-2" for="dimension">Dimension <br/> </label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="dimension" placeholder="Enter dimensions size (width x height x depth) ex: (32x12x5) " name="dimension" value="{{$eSToModify->dimension}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="displaySize">Display Size</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="displaySize" placeholder="Enter display size (widthxheight)" name="displaySize" value="{{$eSToModify->displaySize}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="cpu">Number of CPU cores</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="cpuCores" placeholder="Enter number of cpu cores" name="cpuCores" value="{{$eSToModify->cpuCores}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="processorType">Processor Type</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="processorType" placeholder="Enter processor type" name="processorType" value="{{$eSToModify->processorType}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="hardDriveSize">Hard drive size</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="hdSize" placeholder="Enter hard drive size" name="hdSize" value="{{$eSToModify->hdSize}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="batteryInformation">Battery Information</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="batteryInfo" placeholder="Enter battery information" name="batteryInfo" value="{{$eSToModify->batteryInfo}}">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="ramSize">Ram Size</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="ramSize" placeholder="Enter RAM size" name="ramSize" value="{{$eSToModify->ramSize}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="weight">Weight</label>
    <div class="col-sm-10">
        <input type="number" min=0 class="form-control" id="weight" placeholder="Enter weight" name="weight" value="{{$eSToModify->weight}}">
    </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-2" for="brandName">Brand Name</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="brandName" placeholder="Enter brand name" name="brandName" value="{{$eSToModify->brandName}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="modelNumber">Model Number</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="modelNumber" placeholder="Enter model number" name="modelNumber" value="{{$eSToModify->modelNumber}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="modelNumber">Built-in Operating system</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="os" placeholder="Enter built-in operating system" name="os" value="{{$eSToModify->os}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="price">Camera</label>
    <div class="col-sm-10">
        <input type="radio" name="camera" value="0" checked>No &nbsp; &nbsp; &nbsp;
        <input type="radio" name="camera" value="1" >Yes
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="price">Touch Screen</label>
    <div class="col-sm-10">
        <input type="radio" name="touchScreen" value="0" checked>No &nbsp; &nbsp; &nbsp;
        <input type="radio" name="touchScreen" value="1" >Yes
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="price">Price</label>
    <div class="col-sm-10">
        <input type="number" min=0 class="form-control" id="price" placeholder="Enter price" name="price" value="{{$eSToModify->price}}">
    </div>
</div>

<button type="submit" class="btn btn-success btn-block">Submit</button>
</br>
@stop