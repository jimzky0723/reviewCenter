@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $data = session('data');

    if(!$data){
        $data['provCode'] = $user->province_id;
        $data['muncityCode'] = $user->muncity_id;
        $data['barangayCode'] = $user->barangay_id;
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
            @elseif($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $user->fname }} {{ $user->lname }} updated successfully!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update Reviewee</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left form-submit" novalidate action="{{ url('center/reviewee/'.$user->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="currentID" value="{{ $user->id }}" />

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fname">First Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" value="{{ $user->fname }}" name="fname" required="required" class="fname form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name / Initial <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" value="{{ $user->mname }}" name="mname" required="required" class="mname form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="lname" value="{{ $user->lname }}" required="required" class="lname form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Suffix
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="suffix" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Suffix...</option>
                                            <option {{ ($user->suffix=='Sr.') ? 'selected':'' }}>Sr.</option>
                                            <option {{ ($user->suffix=='Jr.') ? 'selected':'' }}>Jr.</option>
                                            <option {{ ($user->suffix=='I') ? 'selected':'' }}>I</option>
                                            <option {{ ($user->suffix=='II') ? 'selected':'' }}>II</option>
                                            <option {{ ($user->suffix=='III') ? 'selected':'' }}>III</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div id="gender" class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-default {{ ($user->sex=='Male') ? 'active':'' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="sex" value="Male" {{ ($user->sex=='Male') ? 'checked':'' }} /> &nbsp; Male &nbsp;
                                            </label>
                                            <label class="btn btn-default {{ ($user->sex=='Female') ? 'active':'' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                <input type="radio" name="sex" value="Female" {{ ($user->sex=='Female') ? 'checked':'' }} > Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ date('m/d/Y',strtotime($user->dob)) }}" name="dob" id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Contact <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" value="{{ $user->contact }}" name="contact" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" name="email" value="{{ $user->email }}" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input autocomplete="off" id="username" data-id="{{ $user->id }}" value="{{ $user->username }}" class="form-control col-md-7 col-xs-12" name="username" required="required" type="text">
                                        <span class="text-danger username-block hide"><strong>Username already taken!</strong></span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="password" class="form-control col-md-7 col-xs-12" placeholder="Password Unchanged..." name="password" type="password">
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
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        @if(URL::previous() === url('class/center/enroll/{id}'))
                                            <a href="{{ URL::previous() }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        @else
                                            <a href="{{ url('center/reviewee') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        @endif
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Delete</button>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Update</button>
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
@include('modal.addProfile')

@section('modal')
    <form action="{{ url('center/reviewee/'.$user->id) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE">
        <p class="text-danger">Are you sure you want to delete this record?</p>
@endsection

@section('js')
        @include('script.location')
        @include('script.date')
        @include('script.profile')

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