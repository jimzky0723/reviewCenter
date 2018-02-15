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

                <div class="title_right">
                    <form method="post" action="{{ url('instructor/lesson/search/'.$classID) }}">
                        {{ csrf_field() }}
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" name="keyword" value="{{ Session::get('searchLesson') }}" class="form-control" placeholder="Enter keyword...">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="clearfix"></div>

            @if($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully accepted to your center!</strong>
                </div>
            @elseif($status === 'deleted')
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
                                <a class="btn btn-default btn-sm" href="{{ url('instructor/class') }}">
                                    <i class="fa fa-arrow-left"></i>
                                Back</a> My Lessons</h2>
                            <div class="pull-right">
                                <a href="{{ url('instructor/lesson/'.$classID.'/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($data))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Title</th>
                                        <th>Summary</th>
                                        <th>Date Open</th>
                                        <th>Quiz</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $row)
                                    <?php
                                        $id = str_pad($row->id,4,"0",STR_PAD_LEFT);
                                        $summary = \App\Http\Controllers\instructor\LessonCtrl::string_limit_words($row->content,10);
                                        $open = date('M d, Y',strtotime($row->date_open));
                                        $countQuiz = \App\Quiz::where('lesson_id',$row->id)->count();
                                    ?>
                                    <tr>
                                        <td class="text-warning">
                                            <a href="{{ url('instructor/lesson/'.$row->class_id.'/'.$row->id) }}">
                                            <i class="fa fa-book">
                                            {{ $id }}</td>
                                            </a>
                                        <td>{{ $row->title }}</td>
                                        <td>{!!  nl2br($summary)  !!}...</td>
                                        <td>{{ $open }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-warning" href="{{ url('instructor/quiz/'.$row->id) }}">
                                                <i class="fa fa-puzzle-piece"></i>
                                                {{ $countQuiz }}
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
                                    <strong><i class="fa fa-info-circle"></i> No lesson found!</strong>
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

@section('modal')
    <form action="{{ url('center/reviewee/accept') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID" name="currentID" />
        <p class="text-success">Are you sure you want to accept this reviewee?</p>
@endsection