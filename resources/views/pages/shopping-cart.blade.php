@extends('layouts.default')
@section('content')
    <div class="container">
        @if (!empty($eSList))
            <h3>Here are the items in your Cart</h3>
            <br>
            <hr>
            @foreach ($eSList as $eS)
                @if ( $eS ->get()->image && $eS->get()->image !== null )
                    <img src="{{$eS->get()->image}}" class="img-responsive" width="10%" height="auto">
                    <br/>
                @endif
                @if ( $eS->get()->brandName )
                    {{$eS->get()->brandName}}
                @endif
                @if ( $eS->get()->ElectronicType_name )
                    {{$eS->get()->ElectronicType_name}}
                    <br/>
                @endif
                @if ( $eS->get()->displaySize )
                    {{$eS->get()->displaySize}} inch display
                    <br/>
                @endif
                @if ( $eS->get()->modelNumber )
                    Model {{$eS->get()->modelNumber}}
                    <br/>
                @endif
                @if ( $eS->get()->price )
                    Price: ${{$eS->get()->price}}
                    <br/>
                @endif
                <a href="/remove-from-cart?eSId={{$eS->get()->id}}" class="btn btn-info" role="button"> Remove </a>
                <hr>
            @endforeach
        @else
            <h3>You have no items in your cart</h3>
        @endif
        <a href="/" class="btn btn-info" role="button"> Continue Shopping </a>
    </div>
@stop
