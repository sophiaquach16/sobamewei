@extends('layouts.default')
@section('content')

@if( $eS )
<h2>{{$eS->brandName}} {{$eS->ElectronicType_name}} - Model {{$eS->modelNumber}}</h2>
<!-- Add detailed description here -->
@endif

@stop
