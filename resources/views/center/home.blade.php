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
                    <h3>Dashboard</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Welcome to PHERC, <strong>{{ $user->fname }}</strong></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content y_content">
                            <p>PHERC is a Software-as-a-Service for Philippine Exam Review Centers. This study is to
                                help develop a web and mobile-based system that allows the review centers to have an automated
                                system and online presence. The study also aims to benefit the clients of the review centers; the
                                reviewees.</p>
                            <p>If the review center has an online presence, they will be able to inform/advertise to their
                                prospective clients/reviewees on what courses are offered. It will also help disseminate schedules,
                                announcements like daily or weekly examinations. The module lessons of subjects/topics will be
                                made available for perusal to current and/or prospective reviewees wherever they may be.</p>
                            <p>For the reviewees, they can remotely access the contents of the portal for their perusal. It
                                allows them to have a notification alert from the review centers of their review materials,
                                schedules of examination and examination results. And an individual account management
                                system is provided upon enrollment. They are also encouraged to post feedbacks and testimonials
                                in the portal.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
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
                                        $class='unread';
                                        $check = \App\AnnoucementStatus::where('user_id',$user->id)
                                                ->where('announcement_id',$row->id)
                                                ->first();
                                        if($check){
                                            $class = 'read';
                                        }
                                    ?>
                                    <li class="{{ $class }} class_{{$row->id}}">
                                        <div class="block">
                                            <div class="block_content">
                                                <h2 class="title">
                                                    <a>{{ $row->title }}</a>
                                                </h2>
                                                <div class="byline">
                                                    <span>{{ date('M d, Y h:i A',strtotime($row->updated_at)) }}</span>
                                                </div>
                                                <p class="excerpt">{!! $row->content !!}
                                                </p>
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
        var link = "{{ url('center/home/read/') }}/"+id;
        var div = '.class_'+id;
        $(this).fadeOut();
        $.ajax({
            url: link,
            type: 'GET',
            success: function(data){
                $('.badge').html(data+' New');
                $(div).removeClass('unread').addClass('read');
            }
        });
    })
</script>
@endsection