<!DOCTYPE html>
<html lang="en">
<head>
  <title>About Us</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="{{asset('images/logo.svg')}}" type="image/gif" sizes="32x32">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
  <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="top-nav">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-md navbar-dark">
                    <a class="navbar-brand" href="{{route('welcome')}}"><img src="{{asset('images/logo.svg')}}" alt="MatkaApp" class="img-fluid"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                      <span class="fas fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse ml-auto" id="collapsibleNavbar">
                      <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('aboutus')}}">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('howtoplay')}}">HOW TO PLAY</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{route('termsandconditions')}}">TERMS AND CONDITIONS</a>
                        </li>    
                      </ul>
                    </div>  
                  </nav>
            </div>
        </div>
    </div>
</section>