@extends('panel')
@section('content')
    <?php
    $status = session('status');
    ?>
    <style>
        .profile_details:nth-child(3n) {
            clear: none;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
             <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a class="btn btn-default btn-sm" href="{{ url('reviewee/class') }}">
                                    <i class="fa fa-arrow-left"></i>
                                    Back</a> My Lessons
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-sm-12">
                                @if($status === 'finish')
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong>You end 1 lesson!</strong>
                                    </div>
                                @endif
                                @foreach($lessons as $lesson)
                                <?php
                                    $current_date = date('Y-m-d');
                                ?>
                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                    <div class="well profile_view">
                                        <div class="col-sm-12">
                                            <h4 class="brief"><i>{{ $lesson->title }}</i></h4>
                                            <div class="left col-xs-12">
                                                <p><strong>Date Available: </strong> {{ date('M d, Y',strtotime($lesson->date_open)) }} </p>
                                                <p><strong>Downloadable File: </strong>
                                                    @if($lesson->file && $current_date>=$lesson->date_open)
                                                        <a href="{{ url('view/file/'.$lesson->file) }}" target="_blank" class="text-danger">View File</a>
                                                    @elseif($lesson->file && $current_date<$lesson->date_open)
                                                        <span class="text-danger">Lesson not open</span>
                                                    @else
                                                        <span class="text-danger">No downloadable File</span>
                                                    @endif
                                                </p>
                                                <br />
                                            </div>
                                        </div>
                                        <div class="col-xs-12 bottom text-center">
                                            <div class="col-xs-12 col-sm-6 emphasis">
                                                <p class="ratings">
                                                    <a>0.0</a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                    <a href="#"><span class="fa fa-star-o"></span></a>
                                                </p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 emphasis">
                                                @if($current_date>=$lesson->date_open)
                                                <button type="button" class="btn btn-success btn-xs">No Grade</button>
                                                <?php
                                                    $user = Session::get('access');
                                                    $check_reviewee_lesson = \App\RevieweeLesson::where('user_id',$user->id)
                                                        ->where('lesson_id',$lesson->id)
                                                        ->first();
                                                    $count_quiz = \App\Quiz::where('lesson_id',$lesson->id)->first();
                                                ?>
                                                    @if($check_reviewee_lesson)
                                                        @if($count_quiz)
                                                        <a href="{{ url('reviewee/quiz/'.$lesson->id) }}" class="btn btn-warning btn-xs">
                                                            <i class="fa fa-puzzle-piece"> </i> Take Quiz
                                                        </a>
                                                        @else
                                                        <a href="#" class="btn btn-warning btn-xs">
                                                            <i class="fa fa-puzzle-piece"> </i> No Quiz
                                                        </a>
                                                        @endif
                                                    @else
                                                        <a href="{{ url('reviewee/lesson/'.$lesson->id) }}" class="btn btn-primary btn-xs">
                                                            <i class="fa fa-book"> </i> View Lesson
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection