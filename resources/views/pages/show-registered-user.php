@extends('layouts.default')
@section('content')

<div class="text-center"><h2 class="blueTitle">Registered Users</h2></div>

<form method="post" action="inventory">
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
        
        
        
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </table>
</form>
@stop
