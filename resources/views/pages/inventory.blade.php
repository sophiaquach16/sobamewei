@extends('layouts.default')
@section('content')
<script type="text/javascript" src="{{ URL::asset('js/inventory.js') }}"></script>
<div class="text-center"><h2 class="blueTitle">Inventory</h2></div>

<form method="post" action="inventory">
    <table>
        <tr>
            <th>Select</th>
            <th>Select</th>
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
            <th>Display Size</th>
            <th>Electronic Type</th>
            <th>Product Image</th>
        </tr>
        <tr>
            <td colspan="17">

            </td>
        </tr>
        @if (! empty($electronicSpecifications))
        @foreach ($electronicSpecifications as $eS)
        <tr bgcolor="#cce6ff">
            <td>
                <input type="radio" name="modifyRadioSelection" value="{{$eS->id}}">
            </td>
            <td>

            </td>
            <td>
                @if ($eS->dimension )
                {{$eS->dimension}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->weight )
                {{$eS->weight}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->modelNumber )
                {{$eS->modelNumber}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->brandName )
                {{$eS->brandName}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->hdSize )
                {{$eS->hdSize}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->price )
                {{$eS->price}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->processorType )
                {{$eS->processorType}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->ramSize )
                {{$eS->ramSize}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->cpuCores )
                {{$eS->cpuCores}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->batteryInfo )
                {{$eS->batteryInfo}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->os )
                {{$eS->os}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( !is_null($eS->camera) )
                @if ($eS->camera === "1")
                Yes
                @else
                No
                @endif
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( !is_null($eS->touchScreen) )
                @if ($eS->camera === "1")
                Yes
                @else
                No
                @endif
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->displaySize )
                {{$eS->displaySize}} {{$eS->ElectronicType_displaySizeUnit}}
                @else
                N/A
                @endif
            </td>
            <td>
                @if ( $eS->ElectronicType_name )
                {{$eS->ElectronicType_name}}
                @else
                N/A
                @endif
            </td>
            <td>
              @if ( $eS->image && $eS->image !== null )
                  <img src="{{$eS->image}}" width="50%" height="auto">
                @else
                  N/A
              @endif
            </td>

        </tr>
        @if ($eS->electronicItems)
        @foreach ($eS->electronicItems as $eI)

        <tr>
            <td>

            </td>
            <td>
                <input type="checkbox" name="deleteCheckboxSelections[]" value="{{$eI->id}}">
            </td>
            <td colspan="16">
                @if ( $eI->serialNumber )
                <b>Serial Number:</b> {{$eI->serialNumber}}
                @endif
            </td>
        </tr>
        @endforeach
        @endif
        <tr #cce6ff>
            <td colspan="17">

            </td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td>
                <button type="submit" id="modifyButton" name="submitButton" value="modify">Modify</button>
            </td>
            <td><button type="submit" id="deleteButton" name="submitButton" value="delete">Delete</button></td>
            <td colspan="17"></td>
        </tr>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </table>
</form>
@stop
