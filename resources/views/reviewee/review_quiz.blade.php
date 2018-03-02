@extends('panel')
@section('content')
    <?php
    $status = session('status');
    ?>
    <style>
        .profile_details:nth-child(3n) {
            clear: none;
        }
        .choices {
            cursor: pointer;
            font-size: 1.3em;
        }

        .question {
            font-weight: bold;
            font-size:1.3em;
            cursor: pointer;
        }

    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Quiz-{{ str_pad($quiz->code,4,0,STR_PAD_LEFT) }} : Review Quiz
                            </h2>
                            <div class="pull-right">

                            </div>
                            <div class="clearfix"></div>
                        </div>

                            <div class="x_content">
                                <div class="col-sm-12">
                                    <?php
                                        $c=1;
                                        $x = 0;
                                    ?>
                                    @foreach($questions as $key => $value)
                                    @if($key === '_token' || $key==='total_item')
                                        <?php continue; ?>
                                    @endif
                                    <?php
                                        $question_id = trim($key,'question_');
                                        $question = \App\Question::find($question_id)->question;
                                        $ans = \App\Answers::find($value);
                                        $your_answer = $ans->choice;
                                        $correct_answer = \App\Answers::where('question_id',$question_id)
                                                ->where('value',1)
                                                ->first()
                                                ->choice;
                                        $check = $ans->value;
                                        $class = ($check==1) ? 'text-success':'text-danger';
                                        $icon = ($check==1) ? 'fa fa-check':'fa fa-times';
                                        if($check==1)
                                        {
                                            $x++;
                                        }
                                    ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-body">
                                                <span class="question">
                                                    {{ $c++ }}. {{ $question }}
                                                </span>
                                                <div class="choices">
                                                    <hr />
                                                    <span class="{{$class}}">Your Answer: {{ $your_answer }} <i class="{{ $icon }}"></i> </span><br />
                                                    <span class="text-success">Correct Answer: {{ $correct_answer }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr />
                                    <div class="pull-left">
                                        <h3>Score: {{ $x }} out of {{ $c-1 }}</h3>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('reviewee/quiz/'.$lesson_id) }}" class="btn btn-success">
                                            <i class="fa fa-send"></i> Continue
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

    </script>
@endsection