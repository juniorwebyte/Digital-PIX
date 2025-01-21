@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')

@stop

@section('content')
<form action="" method="post">
    {{ csrf_field() }}

    <input type="text" name="title">

    <textarea name="body" id="" cols="30" rows="10"></textarea>

    <button type="submit">SALVAR</button>
</form>
@stop