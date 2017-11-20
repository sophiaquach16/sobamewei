@extends('layouts.default')
@section('content')
<div class="pageContainer container-fluid">

    <div class="container">

        <div class="col-sm-2"></div>

        <form method="post" id="purchase-history-form" class="form-horizontal col-sm-8  text-center purchase-history-form" action="/my-account" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-success btn-block">Delete Account</button>
            <div id="formLoad">
                <div class="row">
                    <div class="items text-center"><span class="blueTitle">Purchase History</span></div>
                </div>
                <table>
                    <tr>
                        {{--<th>Display Size</th>--}}
                        {{--<th>Model Number</th>--}}
                        {{--<th>Price</th>--}}
                        <th>Electronic Item Type</th>
                        <th>Serial Number</th>
                        <th>Purchase Date</th>
                        <th>Brand Name</th>
                        <th>Price</th>
                    </tr>
                    <tr >
                        <td colspan="17">
                        </td>
                    </tr>
                    @if (! empty($transactions))
                        @foreach ($transactions as $tr)

                                <tr bgcolor="#cce6ff">

                                    {{--<td>--}}
                                        {{--@switch($tr->ElectronicType_id)--}}
                                            {{--@case('1')--}}
                                            {{--Desktop--}}
                                            {{--@break--}}

                                            {{--@case('2')--}}
                                            {{--Laptop--}}
                                            {{--@break--}}

                                            {{--@case('3')--}}
                                            {{--Monitor--}}
                                            {{--@break--}}

                                            {{--@case('4')--}}
                                            {{--Tablet--}}
                                            {{--@break--}}

                                            {{--@default--}}
                                            {{--N/A--}}
                                        {{--@endswitch--}}
                                    {{--</td>--}}
                                    <td>
                                        @if ( $tr->serialNumber )
                                            {{$tr->serialNumber}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $tr->timestamp )
                                            {{$tr->timestamp}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $tr->modelNumber )
                                            {{$tr->modelNumber}}
                                            @else
                                                N/A
                                        @endif
                                    </td>
                                    {{--<td>--}}
                                        {{--@if ( $tr->price )--}}
                                            {{--${{$tr->price}}--}}
                                        {{--@else--}}
                                            {{--N/A--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    <td>
                                        <th> <button type="submit" class="btn btn-info btn-block">Return</button></th>
                                    </td>

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
