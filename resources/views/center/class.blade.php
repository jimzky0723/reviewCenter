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
                    <form method="POST" action="{{ url('center/class/search') }}">
                        {{ csrf_field() }}
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">

                                <input type="text" class="form-control" value="{{ Session::get('searchClass') }}" name="keyword"  placeholder="Enter keyword...">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                            </div>
                        </div>
                    </form>
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
                            <h2>Classes</h2>
                            <div class="pull-right">

                                <form method="post" action="{{ url('center/class/search') }}">
                                    {{ csrf_field() }}
                                    <a href="{{ url('center/class/create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New</a>
                                    <input type="hidden" name="keyword" value="" />
                                    @if(Session::get('searchClass'))
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> View All</button>
                                    @endif
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($record))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Class</th>
                                        <th>Instructor</th>
                                        <th>Reviewee</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($record as $row)
                                    <tr>
                                        <?php
                                            $id = str_pad($row->id,4,"0",STR_PAD_LEFT);
                                            $name = \App\User::find($row->instructor_id);
                                            $fullname = 'No instructor';
                                            if($name){
                                                $fullname= "$name->fname $name->lname";
                                            }

                                            $count_class = \App\Reviewee::where('class_id',$row->id)
                                                ->count();
                                        ?>
                                        <td>
                                            <i class="fa fa-pencil"></i>
                                            <a href="{{ url('center/class/'.$row->id) }}">{{ $id }}
                                            </a>
                                        </td>
                                        <td>{{ $row->code }}</td>
                                        <td>{{ $fullname }}</td>
                                        <td>
                                            <a href="{{ url('center/class/enroll/'.$row->id) }}">
                                            <i class="fa fa-group"></i>
                                            {{ $count_class }}</td>
                                            </a>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr />
                                <div class="text-center">

                                </div>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No class found!</strong>
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