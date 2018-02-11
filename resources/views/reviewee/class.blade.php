@extends('panel')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Dashboard</h3>
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
                            <h2>Plain Page</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                <div class="x_panel fixed_height_390">
                                    <div class="x_content">

                                        <div class="flex">
                                            <ul class="list-inline widget_profile_box">
                                                <li>
                                                    <a>
                                                        <i class="fa fa-book"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <img src="{{ url('public/panel/images/user.png') }}" alt="..." class="img-circle profile_img">
                                                </li>
                                                <li>
                                                    <a>
                                                        <i class="fa fa-puzzle-piece"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <h3 class="name">Class Name Here</h3>

                                        <div class="flex">
                                            <ul class="list-inline count2">
                                                <li>
                                                    <h3>123</h3>
                                                    <span>Articles</span>
                                                </li>
                                                <li>
                                                    <h3>1234</h3>
                                                    <span>Followers</span>
                                                </li>
                                                <li>
                                                    <h3>123</h3>
                                                    <span>Following</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <p>
                                            If you've decided to go in development mode and tweak all of this a bit, there are few things you should do.
                                        </p>
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

@endsection