@extends('panel')
@section('content')
    <?php
    $user = Session::get('access');
    ?>
    <style>
        .unread {
            background: #e4fffb;
        }
        .y_content p {
            font-size:1.3em;
            text-align: justify;
        }
        .y_content {

        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Welcome to PHERC, <strong>{{ $user->fname }}</strong></h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">


                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Announcements @if($countAnnouncement>0)<small class="badge">{{ $countAnnouncement }} New</small>@endif</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">

                                <ul class="list-unstyled timeline widget">
                                    @foreach($announcement as $row)
                                        <?php
                                        $class='class=unread';
                                        $check = \App\AnnoucementStatus::where('user_id',$user->id)
                                            ->where('announcement_id',$row->id)
                                            ->first();
                                        if($check){
                                            $class = 'read';
                                        }
                                        $creator = \App\User::find($row->created_by);
                                        ?>
                                        <li {{ $class }} id="id_{{$row->id}}">
                                            <div class="block">
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a>@if($row->subject_id)<font class="text-info">{{ \App\Classes::find($row->subject_id)->code }}</font> - @endif{{ $row->title }}</a>
                                                    </h2>
                                                    <div class="byline">
                                                        @if($creator)
                                                        <span>{{ date('M d, Y h:i A',strtotime($row->updated_at)) }}</span> by <a>{{ $creator->fname }} {{ $creator->lname }}</a>
                                                        @else
                                                        <span>{{ date('M d, Y h:i A',strtotime($row->updated_at)) }}</span>
                                                        @endif
                                                    </div>
                                                    <p class="excerpt">{!! $row->content !!}
                                                    </p>
                                                    @if($row->file)
                                                        <div class="attach">
                                                            <font class="text-primary"><i class="fa fa-paperclip"></i> Attached File</font> :
                                                            <a href="{{ url('view/file/'.$row->file) }}" target="_blank" class="text-danger">{{ $row->file }}</a>
                                                        </div>
                                                        <br/>
                                                    @endif
                                                    @if(!$check)
                                                        <a href="#" class="btn btn-sm btn-warning read" data-id="{{ $row->id }}">Mark as Read</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                                <div class="text-center">
                                    {{ $announcement->links() }}
                                </div>
                                @if(count($announcement)==0)
                                    <div class="alert alert-warning">No Announcements!</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.read').on('click',function () {
            var id = $(this).data('id');
            var link = "{{ url('reviewee/home/read/') }}/"+id;
            console.log(link);
            var div = '#id_'+id;
            $(this).fadeOut();
            $.ajax({
                url: link,
                type: 'GET',
                success: function(data){
                    $('.badge').html(data+' New');
                    $(div).removeClass('unread');
                }
            });
        })
    </script>
@endsection