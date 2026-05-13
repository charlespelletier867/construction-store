@extends('admin.layouts.admin_layout')

@section('pageTitle', $pluralLabel)

@section('content')
    @include('admin._partials.datatable', [
        'columns' => $columns,
        'routePrefix' => $routePrefix,
        'pluralLabel' => $pluralLabel,
    ])
@endsection
