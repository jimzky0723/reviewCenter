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
                    <form method="post" action="{{ url('center/reviewee/search') }}">
                    {{ csrf_field() }}
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{ Session::get('searchReviewee') }}" class="form-control" placeholder="Enter keyword...">
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

            @if($status === 'accepted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully accepted to your center!</strong>
                </div>
            @endif
            @if($status === 'ignored')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully ignored to your center!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Students</h2>
                            <div class="pull-right">
                                <form method="post" action="{{ url('center/reviewee/search') }}">
                                <a href="{{ url('center/reviewee/create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> Add New</a>
                                @if(Session::get('searchReviewee'))
                                    <input type="hidden" value="" name="keyword" />
                                    {{ csrf_field() }}
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
                                        <th># of Subjects</th>
                                        <th>Status</th>
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
                                                <?php
                                                    $count_subj = \App\Reviewee::where('user_id',$row->id)
                                                        ->count();
                                                ?>
                                                <a href="#" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-book"></i> {{ $count_subj }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($row->status==='pending')
                                                    <a class="btn btn-success btn-sm" href="#acceptModal" data-id="{{ $row->id }}" data-toggle="modal">
                                                        <i class="fa fa-money"></i> Pay</a>
                                                    <a class="btn btn-danger btn-sm" href="#ignoreModal" data-id="{{ $row->id }}" data-toggle="modal">
                                                        <i class="fa fa-trash"></i> Ignore</a>
                                                @else
                                                    <strong class="text-success">Registered</strong>
                                                @endif
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
                                    <strong><i class="fa fa-info-circle"></i> No reviewee found!</strong>
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
    <script>
        $('a[href="#acceptModal"]').on('click',function(){
            var id = $(this).data('id');
            var txt = $('#acceptModal').find('#currentID');
            txt.val(id);
        });
    </script>

    <script>
        $('a[href="#ignoreModal"]').on('click',function(){
            var id = $(this).data('id');
            console.log(id);
            var txt = $('#ignoreModal').find('#currentID2');
            txt.val(id);
        });
    </script>
@endsection

@section('modal')
    <form action="{{ url('center/reviewee/accept') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID" name="currentID" />
        <div class="form-group">
            <label>Amount</label>
            <input class="form-control" type="text" required name="amount" placeholder="0.00" />
        </div>
@endsection

@section('modal2')
    <form action="{{ url('center/reviewee/ignore') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID2" name="currentID" />
        <p class="text-danger">Are you sure you want to ignore this student?</p>
@endsection