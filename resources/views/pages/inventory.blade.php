@extends('layouts.default')
@section('content')
<div class="text-center"><h2 class="blueTitle">Inventory</h2></div>
<table>
    <tr>
        <th>Dimension</th>
        <th>Weight</th>
        <th>Model Number</th>
        <th>Brand Name</th>
        <th>Hard drive size</th>
        <th>Price</th>
        <th>Processor Type</th>
        <th>Ram Size</th>
        <th>CPU Cores</th>
        <th>Battery Info</th>
        <th>OS</th>
        <th>Camera</th>
        <th>Touch Screen</th>
        <th>Electronic Type</th>
    </tr>
    {{#each items}}
    <tr>
        <td>{{#if dimension}}{{dimension}}{{else}}N/A{{/if}}</td>
        <td>{{#if weight}}{{weight}}{{else}}N/A{{/if}}</td>
        <td>{{#if modelNumber}}{{modelNumber}}{{else}}N/A{{/if}}</td>
        <td>{{#if brandName}}{{brandName}}{{else}}N/A{{/if}}</td>
        <td>{{#if hdSize}}{{hdSize}}{{else}}N/A{{/if}}</td>
        <td>{{#if price}}{{price}}{{else}}N/A{{/if}}</td>
        <td>{{#if processorType}}{{processorType}}{{else}}N/A{{/if}}</td>
        <td>{{#if ramSize}}{{ramSize}}{{else}}N/A{{/if}}</td>
        <td>{{#if cpuCores}}{{cpuCores}}{{else}}N/A{{/if}}</td>
        <td>{{#if batteryInfo}}{{batteryInfo}}{{else}}N/A{{/if}}</td>
        <td>{{#if os}}{{os}}{{else}}N/A{{/if}}</td>
        <td>{{#if camera}}{{camera}}{{else}}N/A{{/if}}</td>
        <td>{{#if touchScreen}}{{touchScreen}}{{else}}N/A{{/if}}</td>
        <td>{{#if ElectronicType_name}}{{ElectronicType_name}}{{else}}N/A{{/if}}</td>
    </tr>
    {{/each}}
    
</table>
@stop