@extends('layouts.modify')
@section('content')
<div class="row">
    <div class="items text-center"><span class="blueTitle">MODIFY DESKTOP COMPUTER</span></div>
</div>

<input type="hidden" name="ElectronicType_id" value=1>

<div class="form-group">
    <label class="control-label col-sm-2" for="brandName">Brand</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="brandName" placeholder="Enter brand" name="brandName" value="{{$eSToModify->brandName}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="dimensions">Dimensions(cm)</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="dimensions" placeholder="Enter dimensions size (width x height x depth)" name="dimension" value="{{$eSToModify->dimension}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="weight">Weight</label>
    <div class="col-sm-10">
        <input type="number" min=0 class="form-control" id="weight" placeholder="Enter weight" name="weight" value="{{$eSToModify->weight}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="processorType">Processor</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="processorType" placeholder="Enter processor type" name="processorType" value="{{$eSToModify->processorType}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="ram">RAM</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="ramSize" placeholder="Enter RAM size" name="ramSize" value="{{$eSToModify->ramSize}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="cpuCores">Number of CPU cores</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="cpuCores" placeholder="Enter the numbers of CPU cores" name="cpuCores" value="{{$eSToModify->cpuCores}}">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="hdSize">Hard Drive</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="hdSize" placeholder="Enter hard drive size" name="hdSize" value="{{$eSToModify->hdSize}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="model">Model</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="modelNumber" placeholder="Enter model" name="modelNumber" value="{{$eSToModify->modelNumber}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="price">Price</label>
    <div class="col-sm-10">
        <input type="number" min=0 class="form-control" id="price" placeholder="Enter price" name="price" value="{{$eSToModify->price}}">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2" for="image">Upload product image</label>
    <div class="col-sm-10">
        <input type="file" name="image">
    </div>
</div>

<button type="submit" id="desktop-button" class="btn btn-success btn-block">Submit</button>
</br>
@stop