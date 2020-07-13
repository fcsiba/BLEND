<!-- resources/views/notes/edit.blade.php -->

@extends('site.course.course_enroll')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <edit-note :note="{{ $note }}"></edit-note>
            </div>
        </div>
    </div>
@endsection