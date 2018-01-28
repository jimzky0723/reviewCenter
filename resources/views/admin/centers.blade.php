@extends('panel')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

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
                                        <td></td>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Limit</th>
                                        <th>Instructors</th>
                                        <th>Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($centers as $center)
                                    <?php
                                        $muncity = \App\Muncity::where('muncityCode',$center->muncityCode)->first()->desc;
                                        $province = \App\Province::where('provCode',$center->provCode)->first()->desc;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <a href="#" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </strong>
                                        </td>
                                        <td>{{ $center->code }}</td>
                                        <td>{{ $center->desc }}</td>
                                        <td>{{ $muncity }}, {{ $province }}</td>
                                        <td>{{ $center->limit }} Max Reviewers</td>
                                        <td></td>
                                        <td></td>
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

@endsection