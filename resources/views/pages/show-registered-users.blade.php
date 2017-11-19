@extends('layouts.default')
@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/inventory.js') }}"></script>
    <div class="text-center"><h2 class="blueTitle">Registered Users</h2></div>
    <form method="post" action="show-registered-users">
        <table>
            <tr>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <tr>
                <td colspan="17">

                </td>
            </tr>
            @if (! empty($user))
                @foreach ($user as $u)
                    @if($u->admin == 0)
                    <tr bgcolor="#cce6ff">

                        <td>
                            @if ($u->firstName )
                                {{$u->firstName}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ( $u->lastName )
                                {{$u->lastName}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ( $u->email )
                                {{$u->email}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ( $u->phone )
                                {{$u->phone}}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if ( $u->physicalAddress )
                                {{$u->physicalAddress}}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr #cce6ff>
                        <td colspan="17">

                        </td>
                    </tr>
                    @endif
                @endforeach
            @endif
        </table>
    </form>
@stop
