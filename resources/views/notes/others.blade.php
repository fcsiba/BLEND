@extends('layouts.frontend.noteindex')
@section('content')
<style>
    .notes-heading{
        
        margin-bottom: 11px;
        font-size: 18px;
        font-weight: bold;
        font-family: helvetica;
        text-decoration: underline;
        text-transform: capitalize;
        color: white;
        padding: 10px 15px;
        background-color: #28328c;
    }
    .heading-not-selected{
        margin-bottom: 11px;
        font-size: 18px;
        font-weight: bold;
        font-family: helvetica;
        text-decoration: none;
        text-transform: capitalize;
        color: #454545;
        padding: 10px 15px;
        
    }

    .heading-no-selected:hover{
        text-decoration: underline;
    }

    .notes-select:hover{
        background-color: #caf0f8;
        color: #00b4d8;
    }
    .notes-title{
        color: #03045e;
        font-size: 17px;
    }
    
    .notes-update{
        float: right;
    }
    
    .cn-button{
        margin-left: 20%;
        padding: 5px 10px;
        border-radius: 14px;
        color: white;
        background-color: #14bef0;
        text-transform: capitalize;
        text-decoration: none;
    }

    .cn-button:hover{
        border: 2px #14bef0 solid;
        background-color: transparent;
        color: #14bef0;
    }
    </style>
   
   <br>
   <a href="{{ route('notes.create', $course->course_slug) }}" class="cn-button">Create Notes</a>
   <br>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <div class="panel-heading">
                <a href="{{ route('notes.index', $course->course_slug) }}" class="heading-not-selected">My notes</a>
                    <a href="{{ route('notes.others', $course->course_slug) }}" class="notes-heading">Class Notes</a></div>
                    </div>
                    <div class="panel-body">
                        @if($notes->isEmpty())
                            <p>
                                No notes found from other students.
                            </p>
                        @else
                        <ul class="list-group">
                            @foreach($notes as $note)
                                <li class="list-group-item">
                                    <a href="{{ route('notes.view', [$course->course_slug, $note->slug]) }}" class="notes-title">
                                        {{ $note->title }}
                                    </a>
                                    <span class="pull-right">{{ $note->updated_at->diffForHumans() }}</span>
                                    <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $note->rating }}" data-size="xs" disabled="">
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
<script type="text/javascript">
    $("#input-id").rating();
</script>
@endsection