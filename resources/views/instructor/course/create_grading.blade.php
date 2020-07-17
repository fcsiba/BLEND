@extends('layouts.backend.index')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('instructor.course.list') }}">Courses</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <h1 class="page-title">Add Course</h1>
</div>

<div class="page-content">

    <div class="panel">
        <div class="panel-body">


            @include('instructor/course/tabs')


            <form method="POST" action="{{ route('instructor.course.grading.save') }}" id="courseForm">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <div class="row">

                    <div class="panel">
                        <div class="panel-body">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Student ERP</th>
                                        <th>Student Name</th>
                                        <th>Quiz</th>
                                        <th>Assignments</th>
                                        <th>Presentation</th>
                                        <th>Project</th>
                                        <th>Midterm Exam</th>
                                        <th>Final Exam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td><input readonly type='text' name="userID[]" style="width:40%;" value={{$user->users_id}}></td>
                                        <td><input readonly type='text' name="userName[]" style="width:80%;" value="{{$user->user_name}} {{$user->user2_name}}"></td>
                                        <td><input type='text' name="quiz[]" style="width:40%;" value={{$user->quiz2}}></td>
                                        <td><input type='text' name="assignment[]" style="width:40%;" value={{$user->assignment}}></td>
                                        <td><input type='text' name="presentation[]" style="width:40%;" value={{$user->presentation}}></td>
                                        <td><input type='text' name="project[]" style="width:40%;" value={{$user->project}}></td>
                                        <td><input type='text' name="midterm[]" style="width:40%;" value={{$user->midterm}}></td>
                                        <td><input type='text' name="finals[]" style="width:40%;" value={{$user->finals}}></td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default btn-outline">Reset</button>
                        </div>
                    </div>

            </form>
        </div>
    </div>


    <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea',
            menubar: false,
            statusbar: false,
            content_style: "#tinymce p{color:#76838f;}"
        });

        $(".tagsinput").tagsinput();

        $("#courseForm").validate({
            rules: {
                course_title: {
                    required: true
                },
                category_id: {
                    required: true
                },
                instruction_level_id: {
                    required: true
                }
            },
            messages: {
                course_title: {
                    required: 'The course title field is required.'
                },
                category_id: {
                    required: 'The category field is required.'
                },
                instruction_level_id: {
                    required: 'The instruction level field is required.'
                }
            }
        });

        $('.course-id-empty').click(function() {
            toastr.error("Fill course info to proceed");
        });
    });
</script>
@endsection