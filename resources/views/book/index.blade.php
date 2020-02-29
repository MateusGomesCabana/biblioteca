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
                    <form class="form-inline"  method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="put">
                        <div class="form-group" style="float: right;">
                            <p><a href="" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a></p>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Livro">
                        </div>
                        <div class="form-group" style="width: 200px; max-width: 200px;">
                            <select name="category[]" class="form-control selectpicker" multiple="" data-live-search="true" title="Categorias">
                                <?php 
                                if(!empty($categories)){
                                    foreach($categories as $category){ ?>
                                    <option value="<?= $category->id ?>" <?= in_array($category->id, $selected_cat) ? "selected" : NULL ; ?>><?= $category->name ?></option>
                                <?php }
                            } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                    </form>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- for each -->
                                <tr>
                                    <th scope="row" class="text-center"></th>
                                    <td></td>
                                    <td class="text-justify"></td>
                                    <td width="155" class="text-center">
                                        <a href="" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
                                </tr>
                            <!-- for each -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection