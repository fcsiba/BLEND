<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Session;
use DB;
use App\Models\Course;
class NotesController extends Controller
{
    // app/Http/Controllers/NotesController.php



public function __construct()
{
  $this->middleware('auth');
}

/**
 * Display a listing of all notes.
 *
 * @return \Illuminate\Http\Response
 */
public function index($course_slug = '', Request $request)
{

  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  $user_id = \Auth::user()->id;
  $notes = Note::where('user_id', $user_id)
                  ->orderBy('updated_at', 'DESC')
                  ->get();

  return view('notes.index', compact('notes', 'course'));
}

public function otherNotes($course_slug = '', Request $request)
{

  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  $user_id = \Auth::user()->id;
  $notes = Note::where('user_id', '<>', $user_id)
                  ->orderBy('updated_at', 'DESC')
                  ->get();

  return view('notes.others', compact('notes', 'course'));
}

/**
 * Show the form for creating a new note.
 *
 * @return \Illuminate\Http\Response
 */
public function create($course_slug = '', Request $request)
{
  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  return view('notes.create', compact('course'));
}


public function viewNote($course_slug = '', Request $request, Note $note)
{
  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  return view('notes.view', compact('course', 'note'));
}

public function storeRating($course_slug = '', Request $request, Note $note)
{

  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  $user_id = \Auth::user()->id;
  $notes = Note::where('id', $note->id)
                  ->get();

  $rating = new \willvincent\Rateable\Rating;
  $rating->rating = $request->rate;
  $note->ratings()->save($rating);
  


  $totalRatings = DB::table('ratings')
                      ->select(DB::raw('count(*) as count'))
                      ->groupBy('rateable_id')
                      ->having('rateable_id', $note->id)
                      ->get();
  $totalRatings[0]->count = $totalRatings[0]->count + 1;

  $sumRatings = DB::table('ratings')
                    ->select(DB::raw('sum(rating) as sum'))
                    ->groupBy('rateable_id')
                    ->having('rateable_id', $note->id)
                    ->get();
  $sumRatings[0]->sum = $sumRatings[0]->sum + $request->rate;

  $newAvg = $sumRatings[0]->sum / $totalRatings[0]->count;

  DB::table('notes')
      ->where('id', $note->id)
      ->update(['rating'=> $newAvg]);

  return redirect()->route('notes.others', $course_slug);
}
/**
 * Store a newly created note in database.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store($course_slug = '', Request $request)
{

  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  $user_id = \Auth::user()->id;
  $notes = Note::where('user_id', $user_id)
                  ->orderBy('updated_at', 'DESC')
                  ->get();


  $this->validate($request, [
    'title' => 'required',
    'body'  => 'required'
  ]);



  $note = Note::create([
    'user_id' => $request->user()->id,
    'course_id' => $course->id,
    'title'   => $request->title,
    'slug'    => str_slug($request->title) . str_random(10),
    'body'    => $request->body
  ]);

  return redirect()->route('notes.index', [$course_slug]);
}

/**
 * Show the form for editing the specified note.
 *
 * @param  \App\Note  $note
 * @return \Illuminate\Http\Response
 */
public function edit($course_slug = '', Request $request, Note $note)
{
  $course_breadcrumb = Session::get('course_breadcrumb');
  $course = Course::where('course_slug', $course_slug)->first();
  return view('notes.edit', compact('course', 'note'));
}

/**
 * Update the specified note.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Note  $note
 * @return \Illuminate\Http\Response
 */
public function update($course_slug = '', Request $request, Note $note)
{

  switch($request->input('action')){
    case 'save':
      $note->title = $request->title;
      $note->body = $request->body;

      $note->save();
    break;

    case 'delete':
      Note::where('id', $note->id)->delete();
    break;
  }

  $note->title = $request->title;
  $note->body = $request->body;

  $note->save();

  return redirect()->route('notes.index', $course_slug);
}
}
