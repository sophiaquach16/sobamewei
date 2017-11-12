/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2017-11-12
 * Time: 3:00 PM
 */
@extends('layouts.default')
@section('content')
<div class="pageContainer container-fluid">

    <div class="container">

        <div class="col-sm-2"></div>

        <form id="purchase-history-form" class="form-horizontal col-sm-8  text-center purchase-history-form" action="/add-items" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-success btn-block">Delete Account</button>
            <div id="formLoad">
                <div class="row">
                    <div class="items text-center"><span class="blueTitle"></span></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="purchase-history">Purchase History</label>
                    <div class="col-sm-10">
                        <input type="number" min=0 class="form-control" id="weight" placeholder="Enter weight" name="weight">
                    </div>
                </div>

        </form>
    </div>

    </br>
        <div class="col-sm-2"></div>
    </div>
</div>
@stop
