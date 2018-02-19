@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $name = session('name');
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
                    <strong>{{ $name }} successfully updated!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Add New Quiz</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left form-submit" novalidate action="{{ url('instructor/quiz/update/'.$data->id) }}" method="post">
                                {{ csrf_field() }}

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Quiz Code <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input disabled="disabled" type="text" value="Quiz-{{ str_pad($data->code,4,0,STR_PAD_LEFT) }}" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Time Limit <span class="required">*</span>
                                    </label>

                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <input type="text" class="form-control" name="minute" min="0" value="{{ $data->minute }}" placeholder="Enter Minute(s)">
                                        <span class="form-control-feedback right" aria-hidden="true">min</span>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('instructor/quiz/'.$lesson_id) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
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
    <form action="{{ url('instructor/quiz/destroy') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="quiz_id" value="{{ $data->id }}" />
        <p class="text-danger">Are you sure you want to delete this record?</p>
@endsection
@section('js')
    @include('script.date')
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