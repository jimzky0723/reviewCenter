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
                            <h2>Announcement</h2>
                            <div class="pull-right">
                                <a href="{{ url('instructor/announcement/add') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($record))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($record as $row)

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
                                    <strong><i class="fa fa-info-circle"></i> No announcement found!</strong>
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