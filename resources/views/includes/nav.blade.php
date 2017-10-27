    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">ConUShop</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">


				@if( !Auth::check() )
                    <li><a href="/login">Log In<span class="sr-only">(current)</span></a></li>
                    <li><a href="/registration">Register<span class="sr-only">(current)</span></a></li>
				@else
                    <li><a href="add-items">Add Items</a></li>
                    <li><a href="inventory">Inventory</a></li>
                    <li><a href="/logout">Log Out</a></li>
                </ul>
				@endif
            </div>
        </div>
    </nav>
    <div class="row affix-row">
        <div class="col-sm-3 col-md-2 affix-sidebar">
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

            <li><a href="#"><span class="glyphicon glyphicon-lock"></span> Desktop Computers</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-lock"></span> Laptops</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-lock"></span> Monitors</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-lock"></span> Tablets</a></li>

          </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    	</div>
    	<div class="col-sm-9 col-md-10 affix-content">
    		<div class="container">

    				<div class="page-header">
