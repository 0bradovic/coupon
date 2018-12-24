@extends('adminlte::page')

@section('title', 'Coupon')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome {{ Auth::user()->name }}</p>
@stop