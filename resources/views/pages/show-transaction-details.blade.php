@extends('layouts.default')
@section('content')

    <form method="post" action="/return" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="text-center"><h2 class="blueTitle">Transaction Detail</h2></div>
        <input type="hidden" name="item_id" value="{{$tr->item_id}}"/>
        <input type="hidden" name="serialNumber" value="{{$tr->serialNumber}}"/>
        <input type="hidden" name="ElectronicSpec_id" value="{{$tr->ElectronicSpec_id}}"/>
        @if( $eS )

            @if($eS->ElectronicType_name === "Desktop")
                <div class="text-center">
                    <h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
                    <h3>Purchase date : {{$tr->timestamp}}</h3>


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
                            <b>Serial Number</b>: {{$tr->serialNumber}}</br>
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
        <div class="text-center">
            <button type="submit" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Return Purchase"
                    onClick="return confirm('Are you sure you want to return your item ? Click OK to continue the return process.');">
                <i class="glyphicon glyphicon-trash"></i>
                Return Item
            </button>
            </button>
        </div>
        <br/>
        <br/>
    </form>
@stop