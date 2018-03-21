@extends('layouts.master')
@section('body')

<div class="col-lg-6">
  {{ Form::open(array('url'=>$todo_submit_action,'files'=>true)) }}
  
  {{ Form::label('file','File',array('id'=>'','class'=>'')) }}
  {{ Form::file('file','',array('id'=>'','class'=>'form-control')) }}
  {{ Form::hidden('todo_action', $todo_action) }}
  <br/>
  <!-- submit buttons -->
  {{ Form::submit('Save') }}
  
  <!-- reset buttons -->
  {{ Form::reset('Reset') }}
  
  {{ Form::close() }}
</div>

@stop