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
                    <strong>{{ $record->code }} updated successfully!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update Class</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form class="form-horizontal form-label-left form-submit" novalidate action="{{ url('center/class/'.$record->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PATCH">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Class Code <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input name="code" type="text" value="{{ $record->code }}" class="code form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="desc" style="width: 100%;resize: none;" rows="5">{{ $record->desc }}</textarea>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Limit <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" min="1" value="{{ $record->max }}" name="max" class="form-control col-md-7 col-xs-12" required="required">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="province">Province <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="instructor" id="instructor" required="required" class="form-control col-md-7 col-xs-12">
                                            <option value="">Select Instructor...</option>

                                            @foreach($instructors as $row)
                                                <?php
                                                $count = \App\Classes::where('instructor_id',$row->id)->count();
                                                ?>
                                                <option {{ ($record->instructor_id==$row->id) ? 'selected': '' }} value="{{ $row->id }}">{{ $row->lname}}, {{ $row->fname }} - {{ $count }} Class{{ ($count<2) ? '':'es' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Range <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <?php
                                            $date_open = date('m/d/Y',strtotime($record->date_open));
                                            $date_close = date('m/d/Y',strtotime($record->date_close));
                                            $daterange = "$date_open - $date_close";
                                            if($record->date_open==='0000-00-00' && $record->date_close==='0000-00-00'){
                                                $daterange = null;
                                            }
                                        ?>
                                        <input name="date_range" value="{{ $daterange }}" id="reservation" class="date-picker form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Days <span class="required"></span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="days[]" class="form-control select2" multiple="multiple">
                                            <?php
                                                $mon = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Mon');
                                                $tue = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Tue');
                                                $wed = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Wed');
                                                $thu = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Thu');
                                                $fri = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Fri');
                                                $sat = \App\Http\Controllers\center\ClassCtrl::checkDay($record->id,'Sat');
                                            ?>
                                            <option value="">Select...</option>
                                            <option value="Mon" {{ ($mon) ? 'selected':'' }}>Monday</option>
                                            <option value="Tue" {{ ($tue) ? 'selected':'' }}>Tuesday</option>
                                            <option value="Wed" {{ ($wed) ? 'selected':'' }}>Wednesday</option>
                                            <option value="Thu" {{ ($thu) ? 'selected':'' }}>Thursday</option>
                                            <option value="Fri" {{ ($fri) ? 'selected':'' }}>Friday</option>
                                            <option value="Sat" {{ ($sat) ? 'selected':'' }}>Sat</option>
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
                                                <option {{($time==$record->time_in) ? 'selected': '' }}>{{ $time }}</option>
                                                <option {{($time2==$record->time_in) ? 'selected': '' }}>{{ $time2 }}</option>
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
                                                    <option {{($time==$record->time_out) ? 'selected': '' }}>{{ $time }}</option>
                                                    <option {{($time2==$record->time_out) ? 'selected': '' }}>{{ $time2 }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="{{ url('center/class') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Delete</button>
                                        <button id="saveProfile" type="submit" class="btn btn-success"><i class="fa fa-send"></i> Update</button>
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
    <form action="{{ url('center/class/'.$record->id) }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE">
        <p class="text-danger">Are you sure you want to delete this record?</p>
@endsection
@section('js')
    @include('script.select2')
    @include('script.daterange')
    <script>
        var time_in = "{{ $record->time_in }}";
        var time_out = "{{ $record->time_out }}";
        if(time_in){
            changeTime(parseInt(time_in)+1,time_out);
        }
        $('.time_in').on('change', function() {
            var time = parseInt(this.value)+1;
            changeTime(time,'');
        })

        function changeTime(time,time_out)
        {
            var a = 'AM';
            var tmp ='';
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
                if(!time_out)
                {
                    time_out = tmp;
                    if(time_out>12){
                        time_out = time_out-12;
                    }
                    time_out = time_out+':00 '+a;
                }
                content += '<option>'+time1+'</option>'
                content += '<option>'+time2+'</option>'
            }
            console.log(time_out);
            $('.time_out').html(content).val(time_out);
        }
    </script>
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