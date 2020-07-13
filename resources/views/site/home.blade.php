@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="homepage-slide-blue">
            <h1>Institute of Business Administration</h1>
            <span class="title-sub-header">Leaders and Ideas for Tomorrow</span>
            <form method="GET" action="{{ route('course.list') }}">
            </form>
        </div>
        <!-- banner end -->

        <?php 
            $tabs = array('latestTab' => 'Latest Courses',
                          'freeTab' => 'Free Courses',
                          'discountTab' => 'Discount Courses',
                        );
        ?>
        
    

       
           <!-- instructor block start -->
           <article class="instructor-block" >
            <div class="container" style="align: center;">
                <div class="row">
                    <div class="col-12 text-center seperator-head mt-3">
                        <h3>IBA Notice Board</h3>
                    </div>
                </div>
                <div class="row mt-4 mb-5">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="instructor-box mx-auto text-center">
                        <a href="{{ route('instructor.view', 'angela-yu') }}">
                            <main>
                                <img src='backend/assets/images/course_detail_thumb.jpg'>
                                <div class="col-md-12">
                                <h6 class="instructor-title">Revised Admission Policy</h6>
                                        <p style="text-align: justify;">In the wake of COVID-19 constraints, the IBA Karachi has decided to overhaul the admission process for its undergraduate programs.</p>
                                </div>
                            </main>
                        </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="instructor-box mx-auto text-center">
                        <a href="{{ route('instructor.view', 'angela-yu') }}">
                            <main>
                                <img src='backend/assets/images/ibanews1.jpg'>
                                <div class="col-md-12">
                                <h6 class="instructor-title">Admissions 2020</h6>
                                        <p style="text-align: justify;"> We have made changes in our policies to cater to the developments for our prospective students. Click here to further discover about policy changes.</p>
                                </div>
                            </main>
                        </a>
                        </div>
                    </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="instructor-box mx-auto text-center">
                        <a href="{{ route('instructor.view', 'angela-yu') }}">
                            <main>
                                <img src='backend/assets/images/ibanews2.jpg'>
                                <div class="col-md-12">
                                <h6 class="instructor-title">IBA Financial Assistance</h6>
                                        <p style="text-align: justify;">The IBA offers financial assistance to deserving students in the form of various Financial Assistances mechanisms. </p>
                                </div>
                            </main>
                        </a>
                        </div>
                    </div>

                </div>
            </div>
        </article>
        <!-- instructor block end -->
        <!-- dummy block start -->
        <article class="learn-block">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <h3 class="dblock-heading">A Collaborative Learning Space</h3>
                        <p class="dblock-text">{!! Sitehelpers::get_option('pageHome', 'learn_block_text') !!}</p>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 vertical-align">
                        <img class="img-fluid mt-5 mx-auto" src="{{ asset('frontend/img/landing.png') }}">
                    </div>
                </div>
            </div>
        </article>
        <!-- dummy block end -->

     

    </div>
    <!-- content end -->
@endsection