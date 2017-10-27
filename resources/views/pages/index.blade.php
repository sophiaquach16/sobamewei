@extends('layouts.default')
@section('content')

<div class="text-center"><span class="logo">ConUShop Catalog</span></div>

<div class="row affix-row">
    <div class="col-md-2 affix-sidebar">
        <div class="sidebar-nav">
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="visible-xs navbar-brand">Sidebar menu</span>
                </div>
                <div class="navbar-collapse collapse sidebar-navbar-collapse">
                    <ul class="nav navbar-nav" id="sidenav01">
                        <li class="active">
                            <a href="#" data-toggle="collapse" data-target="#toggleDemo0" data-parent="#sidenav01" class="collapsed">
                                <h4>
                                    Control Panel
                                    <br>
                                    <small>IOSDSV <span class="caret"></span></small>
                                </h4>
                            </a>
                            <div class="collapse" id="toggleDemo0" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">ProfileSubMenu1</a></li>
                                    <li><a href="#">ProfileSubMenu2</a></li>
                                    <li><a href="#">ProfileSubMenu3</a></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01" class="collapsed">
                                <span class="glyphicon glyphicon-cloud"></span> Submenu 1 <span class="caret pull-right"></span>
                            </a>
                            <div class="collapse" id="toggleDemo" style="height: 0px;">
                                <ul class="nav nav-list">
                                    <li><a href="#">Submenu1.1</a></li>
                                    <li><a href="#">Submenu1.2</a></li>
                                    <li><a href="#">Submenu1.3</a></li>
                                </ul>
                            </div>
                        </li>

                        <li><a href="/?1=desktop"><span class="glyphicon glyphicon-lock"></span> Desktop Computers</a></li>
                        <li><a href="/?1=laptop"><span class="glyphicon glyphicon-lock"></span> Laptops</a></li>
                        <li><a href="/?1=monitor"><span class="glyphicon glyphicon-lock"></span> Monitors</a></li>
                        <li><a href="/?1=tablet"><span class="glyphicon glyphicon-lock"></span> Tablets</a></li>
                        <li><a href="/?1=priceAscending"><span class="glyphicon glyphicon-lock"></span> Sort Ascending Price</a></li>
                        <li><a href="/?1=priceDescending"><span class="glyphicon glyphicon-lock"></span> Sort Descending Price</a></li>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>

    <div class="col-md-10">

        <div class="page-header">
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

</div>


<!--
<div class="container-fluid">
    <div class="container" id="desktops">
        <h2>Desktop Computers</h2>
    </div>
    <div class="container" id="laptops">
        <h2>Laptops</h2>
    </div>
    <div class="container" id="monitors">
        <h2>Monitors</h2>
    </div>
    <div class="container" id="tablets">
        <h2>Tablets</h2>
    </div>
</div>
!-->
<p></p>
@stop
