@extends('layouts.default')
@section('content')



<div>
   <nav class="navbar navbar-inverse navbar-default" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

    <nav class="navbar navbar-inverse navbar-default" role="navigation">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
      <div>
            <ul class="nav navbar-nav">
              <li><a href="/?1=desktop">Desktop Computers</a></li>
              <li><a href="/?1=laptop">Laptops</a></li>
              <li><a href="/?1=monitor">Monitors</a></li>
              <li><a href="/?1=tablet">Tablets</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sort By <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="/?1=priceAscending">Price Ascending</a></li>
                  <li><a href="/?1=priceDescending">Price Descending</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              </li>
            </ul>
      </div><!-- /.navbar-collapse -->
    </div>

<div class="col-md-10">

        <div class="page-header">
          <h2>Catalog</h2>
        </div>

        @if (! empty($electronicSpecifications))
        @foreach ($electronicSpecifications as $eS)

        <div class="col-md-2">
            @if ( $eS->brandName )
            {{$eS->brandName}}
            @endif
            @if ( $eS->ElectronicType_name )
            {{$eS->ElectronicType_name}}
            @endif
            <br/>
            @if ( $eS->modelNumber )
            Model {{$eS->modelNumber}}
            @endif
            <br/>
            @if ( $eS->price )
            Price: ${{$eS->price}}
            @endif
        </div>

        @endforeach
        @endif

</div>

@stop
