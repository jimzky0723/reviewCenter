@extends('panel')
@section('content')
    <?php
        $status = session('status');
    ?>
    <style>
        ul.widget_profile_box li:first-child {
            width: 48%;
            float: left;
        }
        ul.widget_profile_box li a,ul.widget_profile_box li a:hover {
            border:none;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">

            <div class="clearfix"></div>
            @if($status === 'not_open')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Lesson is not yet open. Please check the date first!</strong>
                </div>
            @elseif($status === 'denied')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Access denied!</strong>
                </div>
            @elseif($status === 'finish')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>You already took this lesson!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>My Subjects</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @foreach($class as $c)
                            <?php
                                $classes = \App\Classes::find($c->class_id);
                                $class_name = $classes->code;
                                $count_reviewee = \App\Reviewee::where('class_id',$c->class_id)->count();
                                $count_lesson = \App\Lesson::where('class_id',$c->class_id)->count();
                                $count_quiz = \App\Quiz::leftJoin('lesson','lesson.id','=','quiz.lesson_id')
                                    ->where('lesson.class_id',$c->class_id)
                                    ->count();
                                $finalGrade = \App\Grade::leftJoin('quiz','quiz.id','=','grade.quiz_id')
                                    ->leftJoin('lesson','lesson.id','=','quiz.lesson_id')
                                    ->leftJoin('classes','classes.id','=','lesson.class_id')
                                    ->where('classes.id',$c->class_id)
                                    ->sum('grade.percentage');
                                if($finalGrade>0)
                                {
                                    $finalGrade = number_format($finalGrade / $count_quiz,1);
                                }

                                $start = date('M d, Y',strtotime($classes->date_open));
                                $end = date('M d, Y',strtotime($classes->date_close));
                                $daterange = "$start - $end";

                                $date_now = date('Y-m-d');
                                $class_panel = ($date_now <= $classes->date_close) ? '': 'bg-danger';
                                $link = ($date_now > $classes->date_close) ? '#': url('reviewee/class/'.$c->class_id);
                                if($classes->date_open==='0000-00-00' && $classes->date_close==='0000-00-00')
                                {
                                    $daterange = 'Always available';
                                    $class_panel = '';
                                    $link = url('reviewee/class/'.$c->class_id);
                                }
                            ?>
                            <div class="col-md-4 col-xs-12 widget widget_tally_box">
                                <div class="x_panel">
                                    <div class="x_content {{ $class_panel }}">

                                        <div class="flex">
                                            <ul class="list-inline widget_profile_box">

                                                <li>
                                                    <a href="{{ $link }}">
                                                    <img src="{{ url('public/panel/images/class.png') }}" alt="..." class="img-circle profile_img">
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>

                                        <h3 class="name">{{ $class_name }}</h3>

                                        <div class="flex">
                                            <ul class="list-inline count2">
                                                <li>
                                                    <h3>{{ $count_reviewee }}</h3>
                                                    <span>Reviewee</span>
                                                </li>
                                                <li>
                                                    <h3>{{ $count_lesson }}</h3>
                                                    <span>Lessons</span>
                                                </li>
                                                <li>
                                                    <h3>{{ $count_quiz }}</h3>
                                                    <span>Quizzes</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-center text-info">
                                            @if($date_now <= $classes->date_close)
                                                Date Available: {{ $daterange }}
                                            @else
                                                @if($classes->date_close==='0000-00-00')
                                                    Always Open <br />
                                                @endif
                                                Your Grade: {{ $finalGrade }}
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
@endsection

@section('js')

@endsection