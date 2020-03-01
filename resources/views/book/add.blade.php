@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            	<ol class="breadcrumb panel-heading">
                	<li><a href="{{route('book.index')}}">Livros</a></li>
                	<li class="active">Adicionar</li>
                </ol>
                <div class="panel-body">
                    @if(Session::has('jsAlert'))
                        <li class="active">Erro informações invalidas por favor complete todos os campos </li>
                    @endif
	                <form action="{{ route('book.save') }}" method="POST" enctype="multipart/form-data">
	                	{{ csrf_field() }}
						<div class="form-group">
						  	<label for="name">Nome</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Nome">
						</div>
                        <div class="form-group">
                            <label for="name">Autores</label>
                            <select name="category[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Autores">
                                @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @endforeach()
                            </select>
                            <p class="help-block">Use Crtl para selecionar.</p>
                        </div>
                        <div class="control-group input-images">
                            <button type="button" class="btn btn-info" id="moreimages">Mais...</button>
                            <br />
                            <br />
                            <div class="controls">
                                <input name="images[]" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea class="form-control" rows="3" name="description" id="description"></textarea>
                        </div>
						<br />
						<button type="submit" class="btn btn-primary">Salvar</button>
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection