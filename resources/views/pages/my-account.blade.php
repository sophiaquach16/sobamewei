@extends('layouts.default')
@section('content')
    <div class="pageContainer container-fluid">

        <div class="container">

            <div class="col-sm-2"></div>

            <form method="post" id="purchase-history-form" class="form-horizontal col-sm-8  text-center purchase-history-form" action="my-account" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-success btn-block">Delete Account</button>
                <div id="formLoad">
                    <div class="row">
                        <div class="items text-center"><span class="blueTitle">Purchase History</span></div>
                    </div>
                </div>
            </form>

                    <table class="table  table-striped">
                        <tr>
                        <th>ElectronicSpecification Id</th>
                        <th>Serial Number</th>
                        <th>Date and Time of Purchase</th>
                        <th>Request for a return</th>
                        </tr>
                        @if (! empty($transactions))
                        @foreach ($transactions as $tr)
                            <form method="post" action="/show-transaction-details">
                                {{ csrf_field() }}
                                <tr bgcolor="#cce6ff">
                                    <td>
                                        <input type="hidden" name="item_id" value="{{$tr->item_id}}"/>
                                        <input type="hidden" name="customer_id" value="{{$tr->customer_id}}"/>
                                        <input type="hidden" name="ElectronicSpec_id" value="{{$tr->ElectronicSpec_id}}"/>
                                    @if ($tr->ElectronicSpec_id )
                                        {{$tr->ElectronicSpec_id}}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        <input type="hidden" name="serialNumber" value="{{$tr->serialNumber}}"/>
                                        @if ( $tr->serialNumber )
                                        {{$tr->serialNumber}}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        <input type="hidden" name="timestamp" value="{{$tr->timestamp}}"/>
                                    @if ( $tr->timestamp )
                                        {{$tr->timestamp}}
                                        @else
                                        N/A
                                    @endif
                                    </td>
                                    <td class="col-md-3">
                                        <button type="submit" id ="{{ $tr->item_id}}_{{ $tr->ElectronicSpec_id}}" name ="{{ $tr->item_id}}_{{ $tr->ElectronicSpec_id}}" class="btn btn-success btn-md">Get Purchase Details</button>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                        @endif
                    </table>
                </div>
        </div>
    </div>
@stop
