﻿<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>MediaLibrary</title>

        <link href="../../assets/css/admin.css" rel="stylesheet">
        <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../assets/css/bootstrap.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <link href="../../assets/css/bars.css" rel="stylesheet">
        <link href="../../assets/css/common.css" rel="stylesheet">
        <link href="../../assets/css/profile.css" rel="stylesheet">

        <script src="../../assets/js/jquery-1.11.1.min.js"></script>
        <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/js/popper.min.js"></script>


    </head>

    <body>

        <div id="wrap" class="wrapper">
            @include('pages.sidebar')
            <div id="content">

                @include('pages.navbar logged in') 

                <div id="containerID">
                    <div id="contentID">
                        <div id="classContainerID" class="container">


                            <br>

                            <section class="row">
                                <div id="photoSideID" class="col-md-6 text-center pb-3">
                                    <h1 class="text-center"></h1>
                                    <br>
                                    <img class="img-fluid" src="../assets/img/users/{{$user[0]->img_path}}" alt="">
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <br>
                                    <br>

                                    <p class="text-dark">
                                        <b class="text-dark font-weight-bold">Email:</b> {{$user[0]->email}} </p>
                                    <p class="text-dark">
                                        <b class="text-dark font-weight-bold">Description:</b>  {{$user[0]->description}} </p>
                                    <p class="text-dark">
                                        <b class="text-dark font-weight-bold">Points:</b>  {{$user[0]->points}} </p>

                                    @if($user != null && count($user) > 0)
                                        @if(Auth::user()->id == $user[0]->id || DB::select('SELECT type FROM users WHERE id=:id', ['id' => Auth::user()->id])[0]->type == "ADMIN")
                                            <a href="{{url('users/'.$user[0]->id.'/edit')}}"><button style="background:#007bff; margin:5px 5px;" class="btn btn-primary col-md-6">Edit Profile</button></a>
                                            <form id="deleteForm" action="{{url('users/'.$user[0]->id.'/delete')}}" method="post">
                                                {{csrf_field()}}
                                                <button style="margin:5px 5px;" class="btn btn-danger col-md-6" onclick="confirmDelete(event)">Delete Profile</button>
                                            </form>
                                        @endif
                                    @endif 
                                </div>
                            </section>
                            <br>
                            <br>
                            <br>
                            <br>
                            <section class="row pb-3">
                                <div class="col-md-6">
                                    <h3>Active Questions</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($userActivePosts as $activePost)
                                                <tr>
                                                    <td>
                                                        <a href= {{"questions/".$activePost->id}}> {{$activePost->title}} </a>
                                                    </td>
                                                    <td> 
                                                        <?php
                                                            $dt = new DateTime($activePost->date);
                                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                                            echo $dt->format('d-m-Y');
                                                        ?> 
                                                    </td>
                                                    <td>
                                                        @if(Auth::user()->id == $user[0]->id || DB::select('SELECT type FROM users WHERE id=:id', ['id' => Auth::user()->id])[0]->type == "ADMIN")
                                                            <form action="{{url("questions/".$activePost->id."/close")}}" method="POST">
                                                                {{ csrf_field() }}
                                                                <a> <input type="submit" value="Close Question" /> </a>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h3>Closed Questions</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($userClosedPosts as $closedPost)
                                                <tr>
                                                    <td>
                                                        <a href= {{"questions/".$closedPost->id}}> {{$closedPost->title}} </a>
                                                    </td>
                                                    <td> 
                                                        <?php
                                                            $dt = new DateTime($closedPost->date);
                                                            $dt->setTimezone(new DateTimeZone('UTC'));
                                                            echo $dt->format('d-m-Y');
                                                        ?> 
                                                    </td>
                                                </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                        </div>
                    </div>
                </div>

                <script src="../../assets/js/bars.js"></script>

                 <script>
                    function confirmDelete(event)
                    {
                        event.preventDefault();
                        let button = event.target;
                        button.innerText = "Confirm delete";
                        button.removeAttribute("onclick");
                        setTimeout(function deleteDefaultValue()
                        {
                            button.innerText = "Delete Profile";
                            button.setAttribute("onclick", "confirmDelete(event)");
                        }, 3000);
                    }
                 </script>





                </body>

                </html>