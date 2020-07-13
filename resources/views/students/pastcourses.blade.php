@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Courses</li>
  </ol>
  <h1 class="page-title">Courses</h1>
</div>

<div class="page-content">

<div class="panel">
        <div class="panel-heading">
          
          <div class="panel-actions">
          <form method="GET" action="{{ route('instructor.course.list') }}">
              <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
                  <a href="{{ route('instructor.course.list') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
                </span>
              </div>
          </form>
          </div>
        </div>
        
        <div class="panel-body">
          <table class="table table-hover table-striped w-full">
            <thead>
              <tr>
                <th>Sl.no</th>
                <th>Title</th>
                <th>Credits</th>
                <th>Grade</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($courses as $course)
              <tr>
                
                <td>{{ $course->id }}</td>
                <td><a href="{{ route('course.learn', $course->course_slug) }}">{{ $course->course_title }}</a></td>
                <td>{{ $course->Credits }}</td>
                <td>{{ $course->grade }}</td>
                <td>
                  @if($course->isCompleted)
                  <span class="badge badge-success">Completed</span>
                  @else
                  <span class="badge badge-danger">Incomplete</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          
          
        </div>
      </div>
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 

    });
</script>
@endsection