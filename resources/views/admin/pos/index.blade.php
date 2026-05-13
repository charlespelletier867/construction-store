@extends('admin.layouts.admin_layout')

@section('pageTitle', __('admin.pos.title'))

@section('content')
@php
    $__posProps = [
        'customers' => $customers,
        'warehouses' => $warehouses,
        'branchId' => $branchId,
        'searchUrl' => route('admin.pos.search_products'),
        'checkoutUrl' => route('admin.pos.checkout'),
    ];
@endphp
<div
    data-vue-island="POSApp"
    data-props='@json($__posProps)'
></div>
@endsection
