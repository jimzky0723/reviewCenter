@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $name = session('name');
    ?>
    <style>
        .title-info {
            text-decoration: dotted;
            font-weight: bold;
        }
        .table tr td {
            vertical-align: middle !important;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>
            </div>

            <div class="clearfix"></div>
            @if($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>1 question successfully added!</strong>
                </div>
            @elseif($status === 'bulkSaved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Questions in bulk successfully added!</strong>
                </div>
            @elseif($status === 'updated')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Successfully updated!</strong>
                </div>
            @elseif($status === 'deleted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Successfully deleted!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a class="btn btn-default btn-sm" href="{{ url('instructor/quiz/'.$lesson_id) }}">
                                    <i class="fa fa-arrow-left"></i>
                                    {{ $quiz_name }}</a> Questions
                            </h2>
                            <div class="pull-right">
                                <a href="#addQuestion" data-toggle="modal" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                                <a href="#addBulkQuestion" data-toggle="modal" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Add Bulk</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($data))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Choice 1</th>
                                        <th>Choice 2</th>
                                        <th>Choice 3</th>
                                        <th>Choice 4</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c=0;?>
                                    @foreach($data as $row)
                                    <?php
                                        $c++;
                                        $choices = \App\Answers::where('question_id',$row->id)
                                            ->inRandomOrder()
                                            ->get();
                                        $class = 'text-success text-strong';
                                    ?>
                                    <tr>
                                        <td>{{ $c }}</td>
                                        <td>
                                            <a href="#updateQuestion" data-toggle="modal" data-id="{{ $row->id }}">
                                            {!! nl2br($row->question) !!}</a></td>
                                        @foreach($choices as $choice)
                                            <td class="{{ ($choice->value==1) ? $class: '' }}">{{ $choice->choice }}</td>
                                        @endforeach
                                        <td>
                                            <button data-target="#deleteQuestion" data-toggle="modal" data-id="{{ $row->id }}" class="btn-deleteQuestion btn btn-danger btn-sm">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No questions found!</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('modal.addQuestion')
@section('js')
<script>
    $('a[href="#updateQuestion"]').on('click',function(){
        var id = $(this).data('id');
        var url = "{{ url('instructor/question/') }}/"+id+"/show";
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data){
                var question = data.question.question;
                var answer = data.choices[0].choice;
                var choice2 = data.choices[1].choice;
                var choice3 = data.choices[2].choice;
                var choice4 = data.choices[3].choice;

                $('#question_id').val(id);
                $('#question').val(question);
                $('#answer').val(answer);
                $('#choice2').val(choice2);
                $('#choice3').val(choice3);
                $('#choice4').val(choice4);
            }
        });
    });

    $('.btn-deleteQuestion').on('click',function(){
        var id = $(this).data('id');
        $('#deleteQuestionID').val(id);
    });
</script>
@endsection