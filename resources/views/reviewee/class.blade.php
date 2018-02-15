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
                            <h2>My Classes</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @foreach($class as $c)
                            <?php
                                $class_name = \App\Classes::find($c->class_id)->code;
                                $count_reviewee = \App\Reviewee::where('class_id',$c->class_id)->count();
                                $count_lesson = \App\Lesson::where('class_id',$c->class_id)->count();
                                $count_quiz = \App\Quiz::leftJoin('lesson','lesson.id','=','quiz.lesson_id')
                                    ->where('lesson.class_id',$c->class_id)
                                    ->count();
                            ?>
                            <div class="col-md-4 col-xs-12 widget widget_tally_box">
                                <div class="x_panel">
                                    <div class="x_content">

                                        <div class="flex">
                                            <ul class="list-inline widget_profile_box">

                                                <li>
                                                    <a href="{{ url('reviewee/class/'.$c->class_id) }}">
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