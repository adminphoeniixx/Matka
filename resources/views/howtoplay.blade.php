<!DOCTYPE html>
<html lang="en">
<head>
  <title>How To Play</title>
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
                    <a class="navbar-brand" href="index.html"><img src="{{asset('images/logo.svg')}}" alt="MatkaApp" class="img-fluid"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="fas fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse ml-auto" id="collapsibleNavbar">
                      <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                          <a class="nav-link" href="aboutus.html">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="howtoplay.html">HOW TO PLAY</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="term-and-condition.html">TERMS AND CONDITIONS</a>
                        </li>    
                      </ul>
                    </div>  
                  </nav>
            </div>
        </div>
    </div>
</section>
<section id="Howto-play-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="headingmain m-both text-center">How to
                    <span>Play</span>
                </h2>
                <p>In matka game when you play the game then you have 100 numbers. 00 to 99. You play with the jodi single and crossing.
                    Then where you play the game you can connect with that and get your money.before playing the matka game you confirm
                    that his good well is the market. Firstly play with small amount after that if you sure it's trustable then you play with big
                    amount. In tha matka the game play with many ways. The most famous two way is this.</p>
            </div>            
        </div>
    </div>
</section>
<section id="Howto-play-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="headingmain m-both text-center">Jodi
                    <span>Game</span>
                </h2>
                <p>You can pick satta number from 00 to 99 Like</p>
                <p>23, 34, 45, 52, 22,00</p>
            </div>            
        </div>
    </div>
</section>
<section id="Howto-play-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="headingmain m-both text-center">Crossing
                    <span>Game</span>
                </h2>
                <p>Like 3x3 || 4x4 || 5x5 you can play like this</p>
            </div>            
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8  b-custom mt-3">
                <table class="table table-borderless">
                    <thead>
                        <tr class="row">
                            <th class="col-sm-4">Crossing</th>
                            <th class="col-sm-4">Crossing No.</th>
                            <th class="col-sm-4">Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row">
                            <td class="col-sm-4">3x3 = 9 numbers</td>
                            <td class="col-sm-4">234</td>
                            <td class="col-sm-4">22, 23, 24, 32, 33, 34, 42, 43, 44.</td>
                        </tr>
                        <tr class="row">
                            <td class="col-sm-4">4x4 = 16 numbers</td>
                            <td class="col-sm-4">2345</td>
                            <td class="col-sm-4">22,23, 24, 25, 32, 33,
                                34, 35, 42, 43, 44, 45,
                                52, 53, 54, 55.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<section id="Howto-play-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="headingmain m-both text-center">Game
                    <span>Rate</span>
                </h2>                
            </div>   
        </div>
        <div class="row justify-content-center">            
            <div class="col-md-4">
                <p class="b-custom">1RS × 95RS = 95RS</p>
            </div>      
            <div class="col-md-4">                
                <p class="b-custom">10RS × 95RS = 950RS</p>
            </div>   
        </div>
    </div>
</section>

@include('partials.footer')