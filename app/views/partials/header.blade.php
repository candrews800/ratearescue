<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    @if(isset($title))
    <title>{{ $title }} - Rate a Rescue</title>
    @else
    <title>Rate a Rescue</title>
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ url('assets/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/style.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
    <nav class="navbar">
        <h3 class="navbar-left">Rate A Rescue</h3>
        <form id="find-pets" method="post" class="navbar-form navbar-right" action="{{ url('/') }}/">
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="animal" value="dog" checked="checked"> Dogs
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="animal" value="cat" > Cats
                    </label>
                </div>
            </div>
            <div class="form-group">
                <input type="text" name="zipcode" class="form-control" placeholder="Zipcode" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Find" />
            </div>
        </form>
        <div class="navbar-right visible-lg visible-md">
            <p class="navbar-text">Search: </p>
        </div>
    </nav>
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="navbar-text">Top Rated: </li>
                <li><a href="{{ url('top/cute') }}">Too Cute</a></li>
                <li><a href="{{ url('top/love') }}">Needs Love</a></li>
                <li><a href="{{ url('top/tuff') }}">So Tuff</a></li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <div class="row">
    <div class="col-xs-12 col-md-8 col-lg-9">