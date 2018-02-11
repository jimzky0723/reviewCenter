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

            @if($status === 'accepted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully accepted to your center!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a href="{{ url('center/class') }}">{{ $className }}</a> >
                                Enroll Reviewee</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Current Reviewees</a>
                                    </li>
                                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">List of Reviewees</a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                        @if(count($current))
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID #</th>
                                                    <th>Name</th>
                                                    <th>Address / Contact</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($current as $rows)
                                                    <tr>
                                                        <?php
                                                        $row = \App\User::find($rows->user_id);
                                                        $str1 = str_pad($row->center_id, 3, '0', STR_PAD_LEFT);
                                                        $str2 = str_pad($row->id, 4, '0', STR_PAD_LEFT);
                                                        $age = \App\Http\Controllers\Parameter::getAge($row->dob);
                                                        $muncity = \App\Muncity::where('muncityCode',$row->muncity_id)->first()->desc;
                                                        $province = \App\Province::where('provCode',$row->province_id)->first()->desc;
                                                        ?>
                                                        <td>
                                                            <i class="fa fa-pencil"></i>
                                                            <a href="{{ url('center/reviewee/'.$row->id) }}">{{ $str1 }}-{{ $str2 }}</a></td>
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
                                                            <button onclick="remove($(this))" data-id="{{ $row->id }}" class="btn btn-warning btn-sm"><i class="fa fa-times"></i> Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr />
                                        @else
                                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <strong><i class="fa fa-info-circle"></i> No reviewee found!</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                        @if(count($record))
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ID #</th>
                                                    <th>Name</th>
                                                    <th>Address / Contact</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($record as $row)
                                                    <?php
                                                    $str1 = str_pad($row->center_id, 3, '0', STR_PAD_LEFT);
                                                    $str2 = str_pad($row->id, 4, '0', STR_PAD_LEFT);
                                                    $age = \App\Http\Controllers\Parameter::getAge($row->dob);
                                                    $muncity = \App\Muncity::where('muncityCode',$row->muncity_id)->first()->desc;
                                                    $province = \App\Province::where('provCode',$row->province_id)->first()->desc;

                                                    $valid = \App\Reviewee::where('user_id',$row->id)
                                                            ->where('class_id',$classID)
                                                            ->first();
                                                    ?>
                                                    @If(!$valid)
                                                    <tr>

                                                        <td>
                                                            <i class="fa fa-pencil"></i>
                                                            <a href="{{ url('center/reviewee/'.$row->id) }}">{{ $str1 }}-{{ $str2 }}</a></td>
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
                                                            <button onclick="enroll($(this))" data-id="{{ $row->id }}" class="btn btn-success btn-sm"><i class="fa fa-user"></i> Enroll</button>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr />
                                        @else
                                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                </button>
                                                <strong><i class="fa fa-info-circle"></i> No reviewee found!</strong>
                                            </div>
                                        @endif
                                    </div>
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
@include('script.enroll')
    <script>
        $('a[href="#acceptModal"]').on('click',function(){
            var id = $(this).data('id');
            var txt = $('#acceptModal').find('#currentID');
            txt.val(id);
        });
    </script>
@endsection

@section('modal')
    <form action="{{ url('center/reviewee/accept') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID" name="currentID" />
        <p class="text-success">Are you sure you want to accept this reviewee?</p>
@endsection