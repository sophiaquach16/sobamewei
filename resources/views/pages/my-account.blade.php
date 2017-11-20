@extends('layouts.default')
@section('content')
    <div class="pageContainer container-fluid">

        <div class="container">

            <div class="col-sm-2"></div>

            <form method="post" id="purchase-history-form" class="form-horizontal col-sm-8  text-center purchase-history-form" action="/my-account" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-success btn-block">Delete Account</button>
                <div id="formLoad">
                    {{--<div class="row">--}}
                    {{--<div class="items text-center"><span class="blueTitle"></span></div>--}}

                    {{--</div>--}}

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="purchase-history">Purchase History</label>
                    </div>
                    <table>
                        <tr>
                            {{--<th>Brand Name</th>--}}
                            {{--<th>Display Size</th>--}}
                            {{--<th>Model Number</th>--}}
                            {{--<th>Price</th>--}}
                            <th>ElectronicSpec_id</th>
                            <th>serialNumber</th>
                            <th>TimeStamp</th>
                            <th> </th>
                        </tr>
                        <tr>
                            <td colspan="17">

                            </td>
                        </tr>
                        @if (! empty($transactions))
                            @foreach ($transactions as $tr)

                                <tr bgcolor="#cce6ff">

                                    <td>
                                        @if ($tr->ElectronicSpec_id )
                                            {{$tr->ElectronicSpec_id}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $tr->serialNumber )
                                            {{$tr->serialNumber}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $tr->timeStamp )
                                            {{$tr->timeStamp}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td><th> <button type="submit" class="btn btn-info btn-block">Return</button></th></td>

                                </tr>
                                <tr #cce6ff>
                                    <td colspan="17">

                                    </td>
                                </tr>

                            @endforeach
                        @endif
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop
