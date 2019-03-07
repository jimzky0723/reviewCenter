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
        .countdown {
            border: 1px solid #ccc;
            width: 100px;
            padding: 5px;
            text-align: center;
            position: fixed;
            bottom: 10px;
            right: -10px;
            z-index: 9999;
            background: #fff;
        }
    </style>

    <div class="right_col" role="main">
        <div class="countdown">
            <span class="timer timer-up">
                {{ (Session::get('quiz_timer_'.$quiz_id)) ? Session::get('quiz_timer_'.$quiz_id) : $quiz->minute.':00' }}
            </span>
        </div>
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                Quiz-{{ str_pad($quiz->code,4,0,STR_PAD_LEFT) }}
                            </h2>
                            <div class="pull-right">
                                Time Left:
                                <span class="timer timer-up">
                                    {{ (Session::get('quiz_timer_'.$quiz_id)) ? Session::get('quiz_timer_'.$quiz_id) : $quiz->minute.':00' }}
                                </span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <form action="{{ url('reviewee/quiz/take/'.$quiz->id) }}" method="POST" id="quiz_form">
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

<div class="modal fade" tabindex="-1" role="dialog" id="endQuizModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Time's Up</h3>
            </div>
            <div class="modal-body">
                <p class="text-success">
                    Opps! Time is Up. All answers will be recorded.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="submitForm()" class="btn btn-primary btn-sm btn-block"><i class="fa fa-send"></i> Continue</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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

        $.ajax({
            url: "{{ url('reviewee/quiz/store/answer/') }}",
            type: "POST",
            data: {
                question_id: question_id,
                answer_id: answer_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data){

            }
        });
        $(this).parent().parent().siblings('.answer').removeClass('hide');
        $(this).parent().parent().siblings('.answer').html('Answer : '+ans);
        $(this).parent().parent().toggle();
    });
    <?php
        $timer = Session::get('quiz_timer_'.$quiz_id);
        if($timer){
            echo "var timer2='$timer';";
        }else{
            echo "var timer2='$quiz->minute:01';";
        }
    ?>

    var interval = setInterval(function() {


        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('.timer').html(minutes + ':' + seconds);
        timer2 = minutes + ':' + seconds;
        if(minutes<1 && seconds<=10) $('.timer').removeClass('timer-up').addClass('timer-down');
        if(minutes<1 && seconds<=0){
            clearInterval(interval);
            $('#endQuizModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }else if(minutes<0){
            clearInterval(interval);
            $.ajax({
                url: "{{ url('reviewee/quiz/store/time/') }}",
                type: "POST",
                data: {
                    timer: '0:00',
                    quiz_id: "{{ $quiz_id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){
                }
            });
            $('.timer').html('0:00').removeClass('timer-up').addClass('timer-down');
            $('#endQuizModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }else{
            $.ajax({
                url: "{{ url('reviewee/quiz/store/time/') }}",
                type: "POST",
                data: {
                    timer: timer2,
                    quiz_id: "{{ $quiz_id }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){

                }
            });
        }
    }, 1000);

    function submitForm()
    {
        $('#quiz_form').submit();
    }
</script>
@endsection