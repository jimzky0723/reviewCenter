@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $data = session('data');
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
                    <strong>1 announcement added!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ $title }}</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form enctype="multipart/form-data" class="form-horizontal form-label-left form-submit" novalidate action="{{ url('instructor/announcement/store') }}" method="post">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea required="required" name="contents" id="descr" class="ckeditor" style="display:none;"></textarea>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('instructor/announcement') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
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

@section('js')
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