@extends('layouts.frontend.noteindex')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create new note</div>
                    <div class="panel-body">
                        <form action="{{ route('notes.rating', [$course->course_slug, $note->slug]) }}" method="POST" class="form" role="form">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="title" value="{{ $note->title }}" required autofocus readonly>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <textarea readonly class="form-control" name="body" rows="15" required>{{ $note->body }}</textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="rating">
                                            <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $note->rating }}" data-size="xs">
                                            <br/>
                                            <button class="btn btn-success">Submit Review</button>
                            </div>
                        </form>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $("#input-id").rating();
</script>
@endsection