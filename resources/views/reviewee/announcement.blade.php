@extends('panel')
@section('content')
    <?php
    $status = session('status');
    $name = session('name');
    ?>
    <style>
        .title-info {
            text-decoration: dotted;
            font-weight: bold;
        }
        .table tr td {
            vertical-align: middle !important;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>
            </div>

            <div class="clearfix"></div>
            @if($status === 'deleted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully deleted!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Announcements</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($record))
                               @foreach($record as $row)
                                   <?php
                                        $user = Session::get('access');
                                        $check = \App\AnnoucementStatus::where('announcement_id',$row->id)
                                            ->where('user_id',$user->id)
                                            ->first();
                                        $class = 'alert-info';
                                        if($check){
                                            $class = 'alert-warning';
                                        }
                                    ?>
                                    <div class="alert {{ $class }} alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-id="{{ $row->id }}">
                                                <i class="fa fa-trash"></i>
                                        </button>
                                        <strong><i class="fa fa-bullhorn"></i> {{ date('M d, Y',strtotime($row->date_created)) }} - {!!  $row->content  !!}</strong>
                                    </div>
                               @endforeach
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <strong><i class="fa fa-info-circle"></i> No announcement yet!</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    var link = "{{ url('reviewee/announcement/seen') }}";
    $('.close').on('click',function(){
        var id = $(this).data('id');
        $(this).parent().removeClass('alert-info').addClass('alert-warning');
        $.ajax({
            url: link+'/'+id,
            type: 'GET',
            success: function(data){
                if(data>0){
                    $('.label_announcement').html(data+' New');
                }else{
                    $('.label_announcement').addClass('hide');
                }
            }
        });
    });
</script>
@endsection