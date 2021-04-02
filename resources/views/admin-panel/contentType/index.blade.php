@extends('layouts.app') 

@section('content')
<div class="container">

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="pull-left"><i class="fa fa-cogs" aria-hidden="true"></i> Content Type</h4>
                    <div class="pull-right form-actions">
                        @if(GroupPermission::usercan('create','content'))
                            <a href="/contentType/create" class="btn btn-primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> New
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    Filters:
                    <a href="/contentType?for=helpline">Helpline</a> |
                    <a href="/contentType?for=hotline">Hotline</a> |
                    <a href="/contentType">All</a>
                </div>
            </div>
        </div>
    
        <div class="panel-body">

            <!-- will be used to show any messages -->
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            {{--  <th>ID</th>   --}}
                            <th>Is for</th>                                                        
                            <th>Name</th>
                            <th>English Name</th>
                            {{--  <th>English Description</th>  --}}
                            <th>Greek Name</th>
                            {{--  <th>Greek Description</th>  --}}
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contentType) 
                        @foreach ($contentType as $key=>$item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                {{--  <td>{{$item->id}}</td>  --}}
                                <td>{{$item->is_for}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->display_name_en}}</td>
                                {{--  <td>{{$item->description_en}}</td>  --}}
                                <td>{{$item->display_name_gr}}</td>
                                {{--  <td>{{$item->description_gr}}</td>  --}}
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->diffForHumans() }}</td>
                                <td style='white-space: nowrap'>
                                    {{--  To delete an item, a form needs to be created --}}
                                    <form method="POST" action="/contentType/{{$item->id}}">
                                        {{--  Other actions are included in the form for styling purposes  --}}
                                        <a href="{{route('contentType.show', $item->id)}}" class="btn btn-default">
                                            <i class="fa fa-eye" aria-hidden="true"></i> Show
                                        </a>
                                        <a href="{{route('contentType.edit', $item->id)}}" class="btn btn-default">
                                            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                        </a>
                                        {{--  Delete button  --}}
                                        @if(GroupPermission::usercan('delete','content'))                                                                                
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-default delete-user">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                            </button>
                                        @endif
                                    </form>                                    
                                </td>
                            </tr>
                        @endforeach 
                        @else
                            <p> There are not any entries saved yet. Click New to create one.</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div> <!-- /.panel-body -->
    </div> <!-- /.panel panel-default -->
</div>

@endsection


@section('scripts')
<script>
 $('.delete-user').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure you want to delete this item?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });
</script>
@endsection
