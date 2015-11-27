@extends('layouts.wrapper')

@section('title')
    <title>Slogan Admin | Twitch Random</title>
@stop

@section('meta')
    <meta name="description" content="Slogan Admin. Find something unexpected at http://twitchrandom.com!">
@stop

@section('css')
    <style>
        #approved .approve,#approved .destroy,#unapproved .unapprove{
            display:none;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $(".approved-list a.approve").click(function(event){
                event.preventDefault();
                var li = $(this).parents("li");
                var ul = li.parents(".approved-list");
                li.prependTo($("#approved .approved-list"));
                approveSlogan(li.data("slogan-id"));
            });
            $(".approved-list a.unapprove").click(function(e){
                e.preventDefault();
                var li = $(this).parents("li");
                var ul = li.parents(".approved-list");
                li.prependTo($("#unapproved .approved-list"));
                unapproveSlogan(li.data("slogan-id"));
            });
            $(".approved-list a.destroy").click(function(e){
                e.preventDefault();
                var li = $(this).parents("li");
                var ul = li.parents(".approved-list");
                li.remove();
                destroySlogan(li.data("slogan-id"));
            });
        });

        function approveSlogan(id){
            $.ajax({
                url: ("/slogans/"+id+"/approve")
            })
            .done(function(data){
                updateCount();
            }).fail(function(data){
                console.log(data);
            });
        }
        function unapproveSlogan(id){
            $.ajax({
                url: ("/slogans/"+id+"/unapprove")
            })
            .done(function(data){
                updateCount();
            }).fail(function(data){
                console.log(data);
            });
            updateCount();
        }

        function destroySlogan(id){
            $.ajax({
                url: ("/slogans/"+id+"/destroy")
            })
            .done(function(data){
                updateCount();
            }).fail(function(data){
                console.log(data);
            });
            updateCount();
        }

        function updateCount(){
            var approvedCount = $("#approved .approved-list li").length;
            var unapprovedCount = $("#unapproved .approved-list li").length;
            $("#approvedCount").text("Approved ("+approvedCount+")");
            $("#unapprovedCount").text("Unapproved ("+unapprovedCount+")");
        }
    </script>
@stop


@section('content')
    @include("layouts.header")
    <div class="container">
        <h2>Slogan Admin</h2>
        <h3>Approve, unapprove or remove slogans.</h3>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a id="approvedCount" href="#approved" aria-controls="approved" role="tab" data-toggle="tab">Approved ({{ count($approved)  }})</a></li>
            <li role="presentation"><a href="#unapproved" id="unapprovedCount" aria-controls="unapproved" role="tab" data-toggle="tab">Unapproved ({{ count($unapproved)  }})</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="approved">
                <h4>Approved Slogans</h4>
                <p>These slogans will appear under the Site Name on the header bar.</p>
                <ul class="list-group approved-list">
                    @foreach($approved as $ap)
                        <li class="list-group-item" data-slogan-id="{{ $ap->id }}">
                            <p>{{ $ap->slogan }}
                            <span class="pull-right">
                                    <a href="{{ $ap->id }}/approve" title="Approve Slogan" class="btn btn-xs btn-success approve"><span class="glyphicon glyphicon-ok"></span></a>
                                    <a href="{{ $ap->id }}/unapprove" title="Unpprove Slogan" class="btn btn-xs btn-danger unapprove"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a href="{{ $ap->id }}/destroy" title="Destroy Slogan" class="btn btn-xs btn-danger destroy"><span class="glyphicon glyphicon-trash"></span></a>
                                </span>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane" role="tabpanel" id="unapproved">
                <h4>Unapproved Slogans</h4>
                <p>These slogans can be approved or destroyed (removed from the database).</p>
                <ul class="list-group approved-list">
                    @foreach($unapproved as $un)
                        <li class="list-group-item" data-slogan-id="{{ $un->id }}">
                            <p>{{ $un->slogan }}
                                <span class="pull-right">
                                    <a href="{{ $un->id }}/approve" title="Approve Slogan" class="btn btn-xs btn-success approve"><span class="glyphicon glyphicon-ok"></span></a>
                                    <a href="{{ $un->id }}/unapprove" title="Unpprove Slogan" class="btn btn-xs btn-danger unapprove"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a href="{{ $un->id }}/destroy" title="Destroy Slogan" class="btn btn-xs btn-danger destroy"><span class="glyphicon glyphicon-trash"></span></a>
                                </span>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop