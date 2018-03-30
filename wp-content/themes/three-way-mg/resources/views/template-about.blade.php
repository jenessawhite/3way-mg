{{--
  Template Name: About Us
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.content-page-about')
  @endwhile
@endsection
