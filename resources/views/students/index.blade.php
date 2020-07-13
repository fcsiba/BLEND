@extends('layouts.backend.index')
@section('content')
<style>
  .course-title{
    margin-bottom: 0.8rem;
    margin-top: 20px;
    font-size: 23px;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    color: #03045e;
}
  .course-container{
    text-align: center;
    background-color: #caf0f8;
    border: 1px #caf0f8 solid;
    border-radius: 5px;
    padding: inherit;
    
  }

  .container-fix{
    display: inline-block;
    vertical-align:middle;
  }

  .instructor-change{
    color: #00b4d8;

  }
  .all-headings{
    margin-top: 22px;
    margin-bottom: 11px;
    font-size: 32px;
    font-weight: bold;
    font-family: helvetica;
    text-decoration: underline;
    text-transform: none;
  }
  
</style>

<!-- content start -->
    <div class="container-fluid p-0 home-content">

<div class="page-header">
  <h1 class="page-title all-headings">Dashboard</h1>
</div>
<div class="page-content container-fluid">
    <div class="row">
    <div class="col-md-4">
          <!-- Card -->
          <div class="card card-block p-30 bg-red-600">
            <div class="card-watermark darker font-size-80 m-15"><i class="fa fa-chalkboard" aria-hidden="true"></i></div>
            <div class="counter counter-md counter-inverse text-left">
              <div class="counter-number-group">
              <span class="counter-number">{{ $count_enrolled->count() > 0 ? $count_enrolled[0]->count_enrolled : 0 }}</span>
              <span class="counter-number-related text-capitalize">Courses Enrolled</span>
              </div>
              <div class="counter-label text-capitalize">This Semester</div>
            </div>
          </div>
   <!-- End Card -->
        </div>

        <div class="col-md-4">
          <!-- Card -->
          <div class="card card-block p-30 bg-blue-600">
            <div class="card-watermark darker font-size-80 m-15"><i class="fa fa-chalkboard" aria-hidden="true"></i></div>
            <div class="counter counter-md counter-inverse text-left">
              <div class="counter-number-group">
                <span class="counter-number">{{round($gpa,2)}}</span>
                <span class="counter-number-related text-capitalize">GPA</span>
              </div>
              <div class="counter-label text-capitalize">This Semester</div>
            </div>
          </div>
          <!-- End Card -->
        </div>

        <div class="col-md-4">
          <!-- Card -->
          <div class="card card-block p-30 bg-green-600">
            <div class="card-watermark darker font-size-60 m-15"><i class="fa fa-chalkboard" aria-hidden="true"></i></div>
            <div class="counter counter-md counter-inverse text-left">
              <div class="counter-number-group">
                <span class="counter-number">{{round($cgpa,2)}}</span>
                <span class="counter-number-related text-capitalize">CGPA</span>
              </div>
              <div class="counter-label text-capitalize">overall</div>
            </div>
          </div>
          <!-- End Card -->
        </div>
    </div>
    <div class="subpage-slide-Courses">
            <div class="container">
                <h1 class="all-headings">My Courses</h1>
                <br>
                @foreach($courses as $course)
                  @if (!$course -> isCompleted)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 container-fix">
                        <div class="course-block mx-auto course-container" id="container-bg">
                        <a href="{{ route('course.learn', $course->course_slug) }}" class="c-view">
                            <main>
                                <div class="col-md-12"><h2 class="course-title">{{ $course->course_title }}</h2></div>
                                
                                <div class="instructor-clist">
                                    <div class="col-md-12">
                                        <i class="fa fa-chalkboard-teacher instructor-change"></i>&nbsp;
                                        <span> <b>{{ $course->first_name.' '.$course->last_name }}</b></span>
                                    </div>
                                </div>
                            </main>
                        </a>    
                        </div>
                    </div>
                  @endif
                @endforeach
            </div>
    </div>

<!-- Footer -->

</div>
</div>
@endsection
