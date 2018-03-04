@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $data = session('data');

    if(!$data){
        $data['owner'] = $center->owner;
        $data['desc'] = $center->desc;
        $data['num'] = $center->limit;
        $data['username'] = $center->username;
        $data['contact'] = $center->contact;
        $data['email'] = $center->email;
        $data['provCode'] = $center->provCode;
        $data['muncityCode'] = $center->muncityCode;
        $data['barangayCode'] = $center->barangayCode;
        $data['status'] = $center->status;
    }
    ?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">

            </div>
            <div class="clearfix"></div>
            @if($status==='duplicateUsername')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Username already taken!</strong>
                </div>
            @elseif($status === 'duplicateEntry')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Duplicate entry of review center.</strong>
                </div>
            @elseif($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $center->desc }} successfully updated!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update : {{ $center->desc }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left" novalidate action="{{ url('admin/center/update') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="currentID" value="{{ $center->id }}" />
                                <input type="hidden" name="userID" value="{{ $center->user_id }}" />
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">Status <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="status" class="form-control" required>
                                            <option {{ ($data['status']==='active') ? 'selected': '' }} value="active">Active</option>
                                            <option {{ ($data['status']==='inactive') ? 'selected': '' }} value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name of Review Center <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input autocomplete="off" type="text" id="name" name="name" value="{{ $data['desc'] }}" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="max">Reviewers Needed <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" id="num" value="{{ ($data['num']) ? $data['num']: 1 }}" name="num" min="1" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="code">Name of Owner <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input autocomplete="off" id="owner" class="form-control col-md-7 col-xs-12" value="{{ $data['owner'] }}" name="owner" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact">Contact <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="contact" value="{{ $data['contact'] }}" class="form-control col-md-7 col-xs-12" name="contact" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" value="{{ $data['email'] }}" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <hr />
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="province">Province <span class="required">*</span>
                                    </label>
                                    <?php $provinces = \App\Province::orderBy('desc','asc')->get(); ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="province" id="province" required="required" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Province...</option>
                                            <?php

                                            ?>
                                            @foreach($provinces as $p)
                                                <option {{ ($data['provCode']==$p->provCode) ? 'selected': ''  }} value="{{ $p->provCode }}">{{ $p->desc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="muncity">Municipality / City <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="muncity" id="muncity" required="required" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Municipality / City...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="barangay">Barangay <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="barangay" id="barangay" required="required" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Barangay...</option>
                                        </select>
                                    </div>
                                </div>
                                <hr />

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input autocomplete="off" id="username" value="{{ $data['username'] }}" class="form-control col-md-7 col-xs-12" name="username" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="password" placeholder="Password Unchanged..." class="form-control col-md-7 col-xs-12" name="password" type="password">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('admin/center') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Delete</button>
                                        <button id="send" type="submit" class="btn btn-success"><i class="fa fa-send"></i> Update</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <form action="{{ url('admin/center/delete') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="currentID" value="{{ $center->id }}" />
        <p class="text-danger">Are you sure you want to delete this record?</p>
@endsection

@section('js')
    @include('script.location')
    <script src="{{ asset('public/panel') }}/vendors/validator/validator.js"></script>
    <script>
        // initialize the validator function
        validator.message.date = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select[required]', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required').on('keyup blur', 'input', function() {
            validator.checkField.apply($(this).siblings().last()[0]);
        });

        $('form').submit(function(e) {
            e.preventDefault();
            var submit = true;

            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();

            return false;
        });
    </script>
@endsection