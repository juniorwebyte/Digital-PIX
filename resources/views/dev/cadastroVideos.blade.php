@extends('layouts.admin')

@section('content')
    <div class="container">
        @foreach ($videos as $video)
            <p>
                {{ $video->title . ' | ' . $video->link }}
                <a href="{{ route('dev.excluirVideo', $video->id) }}">Excluir</a>
            </p>
            
        @endforeach

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('dev.salvarVideo') }}" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Titulo">
                    <input type="text" name="link" placeholder="Link">
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
