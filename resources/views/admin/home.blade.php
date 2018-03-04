@extends('panel')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">

            </div>

            <div class="clearfix"></div>
            <style>
                .info p {
                    font-size:1.3em;
                    text-align: justify;
                }
            </style>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>WELCOME TO PHERC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="info">
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
                            <p>In order to verify that the system will run accordingly as planned, the researchers
                            conducted various testing methods such as unit testing, integration testing, and alpha testing. The
                            study focuses on developing a software-as-a-service for the review centers. Its primary concern is
                            that the system is linked to the review centers and to concerned and involved clients/reviewees.
                            The proponents believe that this study will assist the needs of the review center to better serve
                                their clientele in an efficient manner.</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="col-md-12 col-sm-12col-xs-12">

                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Breakdown</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table class="" style="width:100%">
                                    <tr>
                                        <th style="width:37%;">

                                        </th>
                                        <th>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                <p class="">Users</p>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                <p class="">Total</p>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                        </td>
                                        <td>
                                            <table class="tile_info">
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square blue"></i>Instructor </p>
                                                    </td>
                                                    <td>{{ $totalInstructor }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square aero"></i>Male Students </p>
                                                    </td>
                                                    <td>{{ $totalMale }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square purple"></i>Female Students </p>
                                                    </td>
                                                    <td>{{ $totalFemale }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square red"></i>Satisfied Students </p>
                                                    </td>
                                                    <td>{{ $totalSatisfied }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Feedbacks</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="dashboard-widget-content">

                                    <ul class="list-unstyled timeline widget">
                                        @foreach($feedback as $row)
                                            <li>
                                                <div class="block">
                                                    <div class="block_content">
                                                        <h2 class="title">
                                                            <a>{{ $row->fname }} {{ $row->lname }}
                                                                @if($row->heart)
                                                                    <i class="fa fa-heart text-danger"></i><small>+1 Satisfied</small>
                                                                @endif
                                                            </a>
                                                        </h2>
                                                        <div class="byline">
                                                            <span>{{ date('M d, Y h:i A',strtotime($row->created_at)) }}</span>
                                                        </div>
                                                        <p class="excerpt">{!! nl2br($row->contents) !!}
                                                        </p>

                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                    @if(count($feedback)==0)
                                        <div class="alert alert-warning">No Feedbacks!</div>
                                    @endif
                                </div>
                                <div class="text-center">
                                    {{ $feedback->links() }}
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
<!-- NProgress -->
<script src="{{ asset('public/panel') }}/vendors/Chart.js/Chart.min.js"></script>
<script>
    $(document).ready(function(){
        var options = {
            legend: false,
            responsive: false
        };
        var link = "{{ url('admin/home/chart') }}";
        $.ajax({
            url: link,
            type: 'GET',
            success: function(data){
                console.log(data.total);
                new Chart(document.getElementById("canvas1"), {
                    type: 'doughnut',
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.total,
                            backgroundColor: [
                                "#3498DB",
                                "#BDC3C7",
                                "#9B59B6",
                                "#E74C3C",
                                "#26B99A"
                            ],
                            hoverBackgroundColor: [
                                "#49A9EA",
                                "#CFD4D8",
                                "#B370CF",
                                "#E95E4F",
                                "#36CAAB"
                            ]
                        }]
                    },
                    options: options
                });
            }
        });

    });
</script>
@endsection