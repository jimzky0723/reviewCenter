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
                    <form method="POST" action="{{ url('center/instructor/search') }}">
                        {{ csrf_field() }}
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">

                            <input type="text" class="form-control" value="{{ \Illuminate\Support\Facades\Session::get('searchInstructor') }}" name="keyword"  placeholder="Enter keyword...">
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
                            <h2>Instructors</h2>
                            <div class="pull-right">

                                <form method="post" action="{{ url('center/instructor/search') }}">
                                    {{ csrf_field() }}
                                    <a href="{{ url('center/instructor/add') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New</a>
                                    <input type="hidden" name="keyword" value="" />
                                    @if(Session::get('searchInstructor'))
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
                                        <th>Name</th>
                                        <th>Address / Contact</th>
                                        <th>Class</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($record as $row)
                                    <tr>
                                        <?php
                                            $str1 = str_pad($row->center_id, 3, '0', STR_PAD_LEFT);
                                            $str2 = str_pad($row->id, 4, '0', STR_PAD_LEFT);
                                            $age = \App\Http\Controllers\Parameter::getAge($row->dob);
                                            $muncity = \App\Muncity::where('muncityCode',$row->muncity_id)->first()->desc;
                                            $province = \App\Province::where('provCode',$row->province_id)->first()->desc;
                                            $classes = \App\Classes::where('instructor_id',$row->id)->get();
                                        ?>
                                        <td>
                                            <i class="fa fa-pencil"></i>
                                            <a href="{{ url('center/instructor/'.$row->id) }}">{{ $str1 }}-{{ $str2 }}</a></td>
                                        <td>
                                            {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }} {{ $row->suffix }}
                                            <br />
                                            <small class="text-danger">{{ $row->sex }} | {{ $age }} y/o</small>
                                        </td>
                                        <td>
                                            {{ $muncity }}, {{ $province }}
                                            <br />
                                            <small class="text-danger">{{ $row->contact }} / {{ $row->email }}</small>
                                        </td>
                                        <td>
                                            <ul style="margin-left: -25px;">
                                                @foreach($classes as $row)
                                                <li>{{ $row->code }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr />
                            <div class="text-center">
                                {{ $record->links() }}
                            </div>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No instructors found!</strong>
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