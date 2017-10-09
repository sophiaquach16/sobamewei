@extends('layouts.default')
@section('content')
<script type="text/javascript" src="/javascript/add-items.js"></script>
<script type="text/javascript" src="/javascript/validation.js"></script>
<div class="pageContainer container-fluid">

    <!--Dropdown Menu for electronic items-->
    
    <div class="row text-center">
        <label for="itemSelect">Select the electronic type: </label><br/>
        <select id="itemSelect">
            <option value="empty">-- Please select --</option>
            <option value="desktop">Desktop Computer</option>
            <option value="laptop">Laptop</option>
            <option value="monitor">Monitor</option>
            <option value="tablet">Tablet</option>
            <option value="tv">Television</option>
        </select>
    </div>

    <!-- The form will be loaded here, please see the the file add-items.js in the public/javascript folder to see the html -->
    <div id="formLoad">
    </div>
</div>
@stop