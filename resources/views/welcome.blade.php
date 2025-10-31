@extends('frontend.layouts.master')

@section('title', 'Home Page')

@section('content')
@include('frontend.component.categories')
@include('frontend.component.product_cart')
@endsection