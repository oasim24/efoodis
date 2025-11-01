@extends('frontend.layouts.master')

@section('title', 'Home Page')

@section('content')
@include('frontend.component.categories')

<div class="container-xxl">


@if(!empty($hots) && $hots->count() > 0)
   @include('frontend.component.headline', [
    'title' => 'Hot Products',
    'link_title' => 'View More',
    'link' => '#'
])
   
    @include('frontend.component.product_cart', ['products' => $hots])
@endif
@if(!empty($tops) && $tops->count() > 0)
    @include('frontend.component.headline', [
        'title' => 'Top Selling Products',
        'link_title' => 'View More',
        'link' => '#'
    ])
    
    @include('frontend.component.product_cart', ['products' => $tops])
@endif
@if(!empty($featurs) && $featurs->count() > 0)
 @include('frontend.component.headline', [
        'title' => 'Features Products',
        'link_title' => 'View More',
        'link' => '#'
    ])

@include('frontend.component.product_cart', ['products' => $featurs])
@endif
@if(!empty($all) && $all->count() > 0)
 @include('frontend.component.headline', [
        'title' => 'All Products',
        'link_title' => 'View More',
        'link' => '#'
    ])
@include('frontend.component.product_cart', ['products' => $all])
@endif
</div>
@endsection