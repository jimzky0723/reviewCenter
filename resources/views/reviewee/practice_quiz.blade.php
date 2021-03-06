@extends('panel')
@section('content')
    <?php
    $status = session('status');
    ?>
    <style>
        .profile_details:nth-child(3n) {
            clear: none;
        }
        .choices,.answer {
            color: #ff8a51;
            cursor: pointer;
        }
        .timer {
            font-weight: bold;
            font-size:1.5em
        }
        .timer-up {
            color: #33d810 !important;
        }
        .timer-down {
            color: #f30717 !important;
        }
        .question {
            font-weight: bold;
            font-size:1.3em;
            cursor: pointer;
        }
        .item {
            font-size: 1.2em;
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
                                Quiz-{{ str_pad($quiz->code,4,0,STR_PAD_LEFT) }}
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <form action="{{ url('reviewee/quiz/practice/'.$quiz->id) }}" method="POST" id="quiz_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="total_item" value="{{ count($questions) }}" />
                            <div class="x_content">
                                <div class="col-sm-12">
                                    <?php $c=1; ?>
                                    @foreach($questions as $row)
                                        <?php
                                        $choices = \App\Answers::where('question_id',$row->id)
                                            ->inRandomOrder()
                                            ->get();
                                        $question = Session::get('question_'.$row->id);
                                        ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-body">
                                            <span class="question">
                                                {{ $c++ }}. {!! nl2br($row->question) !!}
                                            </span>
                                                <span class="answer {{ ($question) ? '':'hide' }}">
                                                @if($question)
                                                        Answer : {{ \App\Answers::find($question)->choice }}
                                                    @endif
                                            </span>
                                                <div class="choices">
                                                    <hr />
                                                    @foreach($choices as $ch)
                                                        <label class="item">
                                                            <input type="radio" required {{ ($question==$ch->id) ? 'checked':'' }} data-question="question_{{ $row->id }}" data-answer="{{ $ch->id }}" name="question_{{ $row->id }}" value="{{ $ch->id }}" class="choice">
                                                            {{ $ch->choice }}
                                                        </label>
                                                        <br />
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <hr />
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-send"></i> Submit Quiz
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.question').on('click',function(){
            $(this).siblings('.choices').toggle();
        });

        $('.choice').on('click',function(){
            var ans = $(this).parent().text();
            var question_id = $(this).data('question');
            var answer_id = $(this).data('answer');

            $(this).parent().parent().siblings('.answer').removeClass('hide');
            $(this).parent().parent().siblings('.answer').html('Answer : '+ans);
            $(this).parent().parent().toggle();

        });
    </script>
@endsection