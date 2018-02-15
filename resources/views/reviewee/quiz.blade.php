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
                                <a class="btn btn-default btn-sm" href="{{ url('reviewee/class/'.$class_id) }}">
                                    <i class="fa fa-arrow-left"></i>
                                    Back</a> My Lessons
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-sm-12">
                                @if($status === 'done_quiz')
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong>Done with the Quiz!</strong>
                                    </div>
                                @endif
                                @foreach($data as $row)
                                    <?php
                                    $current_date = date('Y-m-d');
                                    ?>
                                    <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                        <div class="well profile_view">
                                            <div class="col-sm-12">
                                                <h4 class="brief"><i>Quiz-{{ str_pad($row->code,4,0,STR_PAD_LEFT) }}</i></h4>
                                                <div class="left col-xs-12">
                                                    <p><strong>Date Available: </strong> {{ date('M d, Y',strtotime($row->date_open)) }} </p>
                                                    <?php
                                                        $count_item = \App\Question::where('quiz_id',$row->id)->count();
                                                    ?>
                                                    <p><strong>No of Item: {{ $count_item }}</strong></p>
                                                    <br />
                                                </div>
                                            </div>
                                            <div class="col-xs-12 bottom text-right">
                                            <?php
                                                $valid_quiz = \App\RevieweeQuiz::where('user_id',$user->id)
                                                    ->where('quiz_id',$row->id)
                                                    ->first();
                                            ?>
                                            @if(!$valid_quiz)
                                                @if($current_date >= $row->date_open)
                                                <a href="{{ url('reviewee/quiz/take/'.$row->id) }}" class="btn btn-success btn-sm">
                                                    <i class="fa fa-puzzle-piece"> </i> Start Quiz
                                                </a>
                                                @else
                                                <a href="#" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-puzzle-piece"> </i> Not Available
                                                </a>
                                                @endif
                                            @else
                                                <a href="#" class="btn btn-info btn-sm">
                                                    <?php
                                                        $grade = \App\Grade::where('quiz_id',$row->id)
                                                            ->where('student_id',$user->id)
                                                            ->orderBy('id','desc')
                                                            ->first()
                                                            ->percentage;
                                                    ?>
                                                    Grade: {{ $grade }}
                                                </a>
                                            @endif
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