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
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>

                <div class="title_right">
                    <form action="{{ url('admin/center') }}" method="post">
                        {{ csrf_field() }}
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" value="{{ Session::get('centerKeyword') }}" placeholder="Search for...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </form>
                    </span>
                        </div>
                    </div>
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
                    <strong>{{ $name }} is successfully accepted!</strong>
                </div>
            @endif
            @if($status === 'ignored')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully remove from the list!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Review Centers</h2>
                            <div class="pull-right">
                                <a href="{{ url('admin/center/add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($centers))
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Contact</th>
                                        <th>Limit</th>
                                        <th>Current<br/>Students</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($centers as $center)
                                    <?php
                                        $muncity = \App\Muncity::where('muncityCode',$center->muncityCode)->first()->desc;
                                        $province = \App\Province::where('provCode',$center->provCode)->first()->desc;
                                        $user = \App\User::find($center->user_id);
                                    ?>

                                    <tr>

                                        <td><a href="{{ url('admin/center/'.$center->id) }}" class="title-info text-success">{{ str_pad($center->id, 4, '0', STR_PAD_LEFT) }}</a></td>
                                        <td>
                                            <font class="text-success"><strong>{{ $center->desc }}</strong></font><br />
                                            <font class="text-info">Owner: {{ $center->owner }}</font>

                                        </td>
                                        <td>{{ $muncity }}<br />
                                            <small>{{ $province }}</small></td>
                                        <td>
                                            <font class="text-success">{{ $user->contact }}</font><br />
                                            <font class="text-warning">{{ $user->email }}</font>
                                        </td>
                                        <td>{{ $center->limit }}</td>
                                        <?php
                                            $no_reviewee = \App\User::where('center_id',$center->id)
                                                ->where('level','reviewee')
                                                ->count();
                                            $expired = date('M d, Y',strtotime($center->date_expired));
                                        ?>

                                        <td>{{ $no_reviewee }}</td>
                                        <td>
                                            @if($center->status==='inactive')
                                                <a class="btn btn-success btn-sm" href="#acceptModal" data-month="{{ $center->no_month }}" data-id="{{ $user->id }}" data-toggle="modal">
                                                    <i class="fa fa-money"></i> Pay</a>
                                                <a class="btn btn-danger btn-sm" href="#ignoreModal" data-id="{{ $user->id }}" data-toggle="modal">
                                                    <i class="fa fa-trash"></i> Remove</a>
                                            @else
                                                <strong class="text-success">Registered</strong><br />
                                                <font class="text-danger">Expired on {{ $expired }}</font>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr />
                            <div class="text-center">
                                {{ $centers->links() }}
                            </div>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No review center found!</strong>
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
            var no_month = $(this).data('month');
            var txt = $('#acceptModal').find('#currentID');
            var valid = $('#acceptModal').find('select[name="no_month"]');

            txt.val(id);
            valid.val(no_month);
            console.log(no_month);
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
    <form action="{{ url('admin/center/accept') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID" name="currentID" />
        <div class="form-group">
            <label>No. of Months</label>
            <select name="no_month" class="form-control" required>
                <option value="">Subscription validity...</option>
                <option value="1">1 Month</option>
                <option value="3">3 Months</option>
                <option value="6">6 Months</option>
                <option value="12">1 Year</option>
            </select>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input class="form-control" type="text" name="amount" required placeholder="0.00" />
        </div>
        @endsection

        @section('modal2')
            <form action="{{ url('admin/center/ignore') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" id="currentID2" name="currentID" />
                <p class="text-danger">Are you sure you want to ignore this student?</p>
@endsection