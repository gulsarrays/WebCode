@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! <br><br>
                    
                    <table id="example1" class="table table-bordered table-hover stuff_table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                        </thead>
                        @foreach ($data as $key => $post)
                        <tr>
                            <td>{{ $post['id'] }}</td>
                            <td>{{ $post['title'] }}</td>
                            <td>{{ $post['body'] }}</td>
                            <td>{{ $post['created_at'] }}</td>
                            <td>{{ $post['updated_at'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
