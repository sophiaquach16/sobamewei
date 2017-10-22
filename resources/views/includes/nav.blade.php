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

                  <li><a href="/registration">Register<span class="sr-only">(current)</span></a></li>
				@if( !Auth::check() )
                    <li><a href="/login">Log In<span class="sr-only">(current)</span></a></li>
				@else
                    <li><a href="add-items">Add Items</a></li>
                    <li><a href="inventory">Inventory</a></li>
                    <li><a href="/logout">Log Out</a></li>
                </ul>
				@endif
            </div>
        </div>
    </nav>
