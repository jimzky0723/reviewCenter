@extends('panel')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a class="btn btn-default btn-sm" href="{{ url('reviewee/class/'.$lesson->class_id) }}">
                                    <i class="fa fa-arrow-left"></i>
                                    Back</a>
                            </h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content" style="font-size:1.3em;text-align: justify;">
                            <center><h1 class="text-strong">{{ $lesson->title }}</h1></center>
                            <hr />
                            {!! nl2br($lesson->content) !!}
                            <hr />
                            @if($lesson->file)
                                Downloadable File : <a class="text-danger text-strong" href="{{ url('view/file/'.$lesson->file) }}" target="_blank">{{ $lesson->file }}</a>
                            @endif

                            @if($title!='Review lesson')
                            <div class="pull-right">
                                <button data-toggle="modal" data-target="#finishLesson" class="btn btn-success" type="button">
                                    <i class="fa fa-book"></i> Finish Lesson
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" tabindex="-1" role="dialog" id="finishLesson">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmation</h3>
            </div>
            <div class="modal-body">
                <p class="text-success">Are you sure you want to end this lesson?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                <a href="{{ url('reviewee/lesson/finish/'.$lesson->id) }}" class="btn btn-success btn-sm"><i class="fa fa-send"></i> Yes</a>
            </div>
            </form>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@include('modal.disable')
@section('js')
<script>
    $('.x_content').bind('copy paste cut',function(e) {
        e.preventDefault();
        $('#copyAlert').modal('show');
    });
</script>
@endsection