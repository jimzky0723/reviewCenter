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
            @if($status === 'updated')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Successfully updated!</strong>
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
                            <?php
                                if($type=='add')
                                {
                                    $link = url('admin/announcement/store');
                                }else{
                                    $link = url('admin/announcement/update');
                                }
                            ?>
                            <form class="form-horizontal form-label-left form-submit" novalidate action="{{ $link }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="currentID" value="@if($record){{ $record->id }}@endif" />
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Header / Title <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input autocomplete="off" type="text" name="title" value="@if($record){{ $record->title }}@endif" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Content <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea required="required" name="contents" class="ckeditor" style="display:none;">@if($record){{ $record->content }}@endif</textarea>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('admin/announcement') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
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
    @include('script.select2')
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