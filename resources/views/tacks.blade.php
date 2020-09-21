@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-sm-offset-2 col-sm-8">
    <div class="panel panel-default">
      <div class="panel-heading">
        New Task
      </div>
      <div class="panel-body">
        @include('common.errors')
        <form action="{{url('tack')}}" method="post" class="form-horizontal">
          @csrf
          <div class="form-group">
            <label for="task-name" class="col-sm-3 control-label">Task</label>
            <div class="col-sm-6">
              <input type="text" name="name" id="task-name" class="form-control" value="{{old('tack')}}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-default">
                <i class="fa fa-btn fa-plus"></i>Insert Task
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Now Task-->
    @if (count($tacks) > 0)
    <div class="panel panel-default">
      <div class="panel-heading">
        Now Task
      </div>
      <div class="panel-body">
        <table class="table table-striped task-table">
          <thead>
            <tr>
              <th>Task</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tacks as $tack)
            <tr>
              <td class="table-text">
                <div class="">
                  {{$tack->name}}
                </div>
              </td>
              <!--delete-->
              <td>
                <form action="{{url('tack/' . $tack->id)}}" method="post">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>DELETE
                  </button>
                </form>
              </td>
              <td></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
