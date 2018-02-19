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
            @if($status === 'deleted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully deleted!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a class="btn btn-default btn-sm" href="{{ url('instructor/lesson/'.$class_id) }}">
                                    <i class="fa fa-arrow-left"></i>
                                    Back</a> My Quizzes
                            </h2>
                            <div class="pull-right">
                                <a href="{{ url('instructor/quiz/'.$lesson_id.'/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($data))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Quiz Code</th>
                                        <th>Total Item</th>
                                        <th>Time Limit</th>
                                        <th>Questions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $row)
                                    <?php
                                        $code = str_pad($row->code,4,0,STR_PAD_LEFT);
                                        $count_item = \App\Question::where('quiz_id',$row->id)->count();
                                        $min = str_pad($row->minute,2,0,STR_PAD_LEFT);
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="{{ url('instructor/quiz/show/'.$row->id) }}">
                                                <i class="fa fa-arrow-right"></i>
                                                Quiz-{{ $code }}</td>
                                            </a>
                                        <td>{{ $count_item }}</td>
                                        <td>
                                            {{ $row->minute }} minute{{ ($row->minute>1) ? 's':'' }}
                                        </td>
                                        <td>
                                            <a href="{{ url('instructor/question/'.$row->id) }}" class="btn btn-xs btn-success">
                                                <i class="fa fa-pencil"></i> View Questions
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr />
                                <div class="text-center">
                                    {{ $data->links() }}
                                </div>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No quiz found!</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection