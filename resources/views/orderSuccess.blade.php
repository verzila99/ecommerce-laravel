@extends('layouts.default')
@section('scripts')
<script defer src="{{ asset('/js/app.js')}}"></script>
@endsection
@section('title','Ecommerce shop')
@section('content')
<section class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center order-success">
    <h1 class="noitems-title">{{__('Order is processed!')}}</h1>
    <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6">
        {{__('Our operator will contact you in the near future.')}}
    </h2>
    <a href="/" class="button is-warning mt-6">{{__('Home')}}</a>
</section>
@endsection
