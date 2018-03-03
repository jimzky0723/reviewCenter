@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $data = session('data');
    $mask_id = str_pad($lessonID,4,0,STR_PAD_LEFT);
    ?>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">

            </div>
            <div class="clearfix"></div>
            @if($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Lesson ID {{ $mask_id }} updated successfully!</strong>
                </div>
            @elseif($status === 'filedeleted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>File successfully deleted!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update: {{ $lesson->title }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form enctype="multipart/form-data" class="form-horizontal form-label-left form-submit" novalidate action="{{ url('instructor/lesson/'.$lessonID) }}" method="post">
                                {{ csrf_field() }}

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required="required" type="text" value="{{ $lesson->title }}" name="title" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Open <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="dateOpen" id="dateOpen" value="{{ date('m/d/Y',strtotime($lesson->date_open)) }}" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Upload File <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input placeholder="Replace downloadable file..." type="file" accept="application/pdf" value="" name="file" class="form-control col-md-7 col-xs-12">
                                        @if($lesson->file)
                                        <br />
                                        <br />
                                        <strong>
                                            <a href="{{ url('view/file/'.$lesson->file) }}" target="_blank"><span class="text-primary"> {{ $lesson->file }}</span></a>
                                            <a href="#deleteFileModal" data-toggle="modal"> <span class="text-danger"><i class="fa fa-times"></i> Remove</span></a>
                                        </strong>
                                        @endif
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea required="required" name="contents" id="descr" class="ckeditor" style="display:none;">{{ $lesson->content }}</textarea>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('instructor/lesson/'.$classID) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
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

@section('modal2')
    <form action="{{ url('destroy/file/'.$lessonID) }}" method="GET">
        <p class="text-danger">Are you sure you want to delete this file?<br><br><strong>Note : Make sure you save the update first before removing this file!</strong></p>
@endsection

@section('modal')
    <form action="{{ url('instructor/lesson/'.$lessonID.'/destroy') }}" method="post">
        {{ csrf_field() }}
        <p class="text-danger">Are you sure you want to delete this record?</p>
@endsection

@section('js')
    @include('script.date')
    <script src="{{ asset('public/panel') }}/vendors/validator/validator.js"></script>
    <script src="{{ asset('public/panel') }}/vendors/ckeditor/ckeditor.js"></script>
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