@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <ol class="breadcrumb panel-heading">
                    <li class="active">Livros</li>
                </ol>
                <div class="panel-body">
              
                    <form class="form-inline"      method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="{{route('loan.index')}}" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Alugar</a></p>
                        </div>
                        
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Nome</th>
                                <th>Data da locação</th>
                                <th>Data da devolução</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <th scope="row" class="text-center">{{ $book->id }}</th>
                                    <td>{{ $book->title }}</td>
                                    <td class="text-justify">{{ $book->description }}</td>
                                    <td class="text-justify">{{ $book->description }}</td>
                                    <td width="155" class="text-center">
                                        <a href="{{route('book.edit', $book->id)}}" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-pencil">Renovar</i></a>
                                        <a href="{{route('book.delete', $book->id)}}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash">Devolver</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection