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

                <div class="title_right">
                    <form method="post" action="{{ url('instructor/reviewee/search/'.$classID) }}">
                        {{ csrf_field() }}
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" name="keyword" value="{{ Session::get('searchReviewee') }}" class="form-control" placeholder="Enter keyword...">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                            </div>
                        </div>
                    </form>
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

            @if($status === 'accepted')
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ $name }} is successfully accepted to your center!</strong>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>
                                <a class="btn btn-default btn-sm" href="{{ url('instructor/class') }}">
                                <i class="fa fa-arrow-left"></i>
                                Back</a> My Students</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(count($data))
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Name</th>
                                        <th>Address / Contact</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <?php
                                            $str1 = str_pad($row->center_id, 3, '0', STR_PAD_LEFT);
                                            $str2 = str_pad($row->id, 4, '0', STR_PAD_LEFT);
                                            $age = \App\Http\Controllers\Parameter::getAge($row->dob);
                                            $muncity = \App\Muncity::where('muncityCode',$row->muncity_id)->first()->desc;
                                            $province = \App\Province::where('provCode',$row->province_id)->first()->desc;

                                            $count_quiz = \App\Quiz::leftJoin('lesson','lesson.id','=','quiz.lesson_id')
                                                    ->where('lesson.class_id',$classID)
                                                    ->count();
                                            $total_socre = \App\Grade::leftJoin('quiz','quiz.id','=','grade.quiz_id')
                                                    ->leftJoin('lesson','lesson.id','=','quiz.lesson_id')
                                                    ->where('lesson.class_id',$classID)
                                                    ->where('grade.student_id',$row->id)
                                                    ->sum('grade.percentage');
                                            if($total_socre > 0){
                                                $grade = number_format($total_socre / $count_quiz,1);
                                            }else{
                                                $grade = 0;
                                            }

                                            $class = ($grade > 74) ? 'text-success':'text-danger';
                                            $value = ($grade > 74) ? 'Passed':'Failed';
                                            if($grade==0)
                                            {
                                                $grade = 'N/A';
                                                $class = 'text-warning';
                                                $value = 'No grade';
                                            }
                                            ?>
                                            <td>
                                                {{ $str1 }}-{{ $str2 }}
                                            </td>
                                            <td>
                                                {{ $row->lname }}, {{ $row->fname }} {{ $row->mname }} {{ $row->suffix }}
                                                <br />
                                                <small class="text-danger">{{ $row->sex }} | {{ $age }} y/o</small>
                                            </td>
                                            <td>
                                                {{ $muncity }}, {{ $province }}
                                                <br />
                                                <small class="text-danger">{{ $row->contact }} / {{ $row->email }}</small>
                                            </td>
                                            <td class="text-warning">{{$grade }}</td>
                                            <td class="{{ $class }}">{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr />
                                <div class="text-center">
                                    {{ $data->links() }}
                                </div>
                            @else
                                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                    </button>
                                    <strong><i class="fa fa-info-circle"></i> No student found!</strong>
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
        $('a[href="#acceptModal"]').on('click',function(){
            var id = $(this).data('id');
            var txt = $('#acceptModal').find('#currentID');
            txt.val(id);
        });
    </script>
@endsection

@section('modal')
    <form action="{{ url('center/reviewee/accept') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" id="currentID" name="currentID" />
        <p class="text-success">Are you sure you want to accept this reviewee?</p>
@endsection