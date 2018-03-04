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
            @if($status==='duplicateCode')
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Username already taken!</strong>
                </div>
            @elseif($status === 'saved')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>1 Subject added!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Add New Class</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left form-submit" novalidate action="{{ url('center/class') }}" method="post">
                                {{ csrf_field() }}

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject Code <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="code" class="code form-control col-md-7 col-xs-12" required="required">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="desc" style="width: 100%;resize: none;" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Limit <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" min="1" value="1" name="max" class="form-control col-md-7 col-xs-12" required="required">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="instructor">Instructor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="instructor" id="instructor" required="required" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Instructor...</option>

                                            @foreach($instructors as $row)
                                                <?php
                                                    $count = \App\Classes::where('instructor_id',$row->id)->count();
                                                ?>
                                                <option value="{{ $row->id }}">{{ $row->lname}}, {{ $row->fname }} - {{ $count }} Subject{{ ($count<2) ? '':'s' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Range <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="date_range" id="reservation" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Days <span class="required"></span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="days[]" class="form-control select2" multiple="multiple">
                                            <option value="">Select...</option>
                                            <option value="Mon">Monday</option>
                                            <option value="Tue">Tuesday</option>
                                            <option value="Wed">Wednesday</option>
                                            <option value="Thu">Thursday</option>
                                            <option value="Fri">Friday</option>
                                            <option value="Sat">Sat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Time Open <span class="required">*</span>
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <select name="time_in" class="time_in form-control col-md-7 col-xs-12" type="text">
                                            @for($i=7;$i<=18;$i++)
                                            <?php
                                                $date = date('M d, Y '.$i.':00');
                                                $time = date('h:i A',strtotime($date));
                                                $date = date('M d, Y '.$i.':30');
                                                $time2 = date('h:i A',strtotime($date));
                                            ?>
                                            <option data-time="{{ $i }}">{{ $time }}</option>
                                            <option data-time="{{ $i }}">{{ $time2 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <select name="time_out" class="time_out form-control col-md-7 col-xs-12" type="text">
                                            @for($i=7;$i<=18;$i++)
                                                <?php
                                                $date = date('M d, Y '.$i.':00');
                                                $time = date('h:i A',strtotime($date));
                                                $date = date('M d, Y '.$i.':30');
                                                $time2 = date('h:i A',strtotime($date));
                                                ?>
                                                <option>{{ $time }}</option>
                                                <option>{{ $time2 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('center/class') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        <button id="saveProfile" type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
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
@section('js')
    @include('script.daterange')
    @include('script.select2')
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
    <script>
        $('.time_in').on('change', function() {
            var time = parseInt(this.value)+1;
            var a = 'AM';
            var tmp ='';
            if(time>=1 && time<=7){
                time = time + 12;
            }
            $('.time_out').empty();
            var content = '';
            for(time;time<=18;time++)
            {
                tmp = time;
                if(time>11){
                    a = 'PM';
                }
                if(time>12){
                    tmp = time-12;
                }
                var time1 = tmp+':00 '+a;
                var time2 = tmp+':30 '+a;
                content += '<option>'+time1+'</option>'
                content += '<option>'+time2+'</option>'
            }
            $('.time_out').html(content);
        })
    </script>
@endsection