@extends('layouts.frontend.noteindex')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit your note</div>
                    <div class="panel-body">
                        <form action="{{ route('notes.edit', [$course->course_slug, $note->slug]) }}" method="POST" class="form" role="form">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="title" value="{{ $note->title }}"  required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <textarea class="form-control" name="body" rows="15" placeholder="...and here goes your note body" required>{{ $note->body }}</textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-primary pull-right" name="action" value="delete">Delete</button>
                            <button class="btn btn-primary pull-right" name="action" value="save">Save</button>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection