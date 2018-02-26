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
                            <h2>My Subjects</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($data))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Subject Code</th>
                                        <th>Students</th>
                                        <th>Lessons</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $row)
                                    <?php
                                        $id = str_pad($row->id,4,"0",STR_PAD_LEFT);
                                        $countReviewee = \App\Reviewee::where('class_id',$row->id)
                                            ->count();
                                        $countLesson = \App\Lesson::where('class_id',$row->id)
                                            ->count();
                                    ?>
                                    <tr>
                                        <td class="text-warning">
                                            <i class="fa fa-arrow-right"></i>
                                            {{ $id }}
                                        </td>
                                        <td class="text-primary">
                                            {{ $row->code }}
                                        </td>
                                        <td>
                                            <a href="{{ url('instructor/reviewee/'.$row->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-users"></i>
                                                {{ $countReviewee }}
                                                Student{{ ($countReviewee>1) ? 's':'' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('instructor/lesson/'.$row->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa fa-book"></i>
                                                {{ $countLesson }}
                                                Lesson{{ ($countLesson>1) ? 's':'' }}
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
                                    <strong><i class="fa fa-info-circle"></i> No subject found!</strong>
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