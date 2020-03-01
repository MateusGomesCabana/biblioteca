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
                    @if(Session::has('jsAlert'))
                        <li class="active">Renovação efetuada com sucesso </li>
                    @endif
                    @if(Session::has('jsdAlert'))
                        <li class="active">Existem Livros a serem renovados </li>
                    @endif
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Nome</th>
                                <th>Imagem</th>
                                <th>Descrição</th>
                                <th>Data aluguel</th>
                                <th>Data devolução</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($query as $item)
                            <tr>
                                <th scope="row" class="text-center">{{ $item->id }}</th>
                                <td>{{ $item->title }}</td>
                                <td><img src="/images/product/{{ $item->image }}"  width="10%" /></td>
                                <td class="text-justify">{{ $item->description }}</td>
                                <td class="text-justify">{{ $item->date_start }}</td>
                                <td class="text-justify">{{ $item->date_end }}</td>
                                <td width="155" class="text-center">
                                    <a href="{{route('loan.update', $item->id)}}" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-pencil"></i>Renovar</a>
                                    <a href="{{route('loan.delete', $item->id)}}" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i>Devolver</a>
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