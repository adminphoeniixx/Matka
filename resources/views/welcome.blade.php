<!DOCTYPE html>
<html lang="en">
<head>
  <title>Matka App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="images/logo.svg" type="image/gif" sizes="32x32">
  <link rel="stylesheet" href="{{asset('style.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>
<body>

<section id="bannercard">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="logo"><img src="{{asset('images/logo.svg')}}" alt="matka" class="img-fluid"></div>
            </div>
        </div>
    </div>
    <div class="container banner">        
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('images/player.png')}}" alt="MatkaApp" class="img-fluid">
            </div>
            <div class="col-md-6 banner-info">
                <h3>Download the official <span> D Company Matka App</span></h3>
                <button class="btn btn-app">DOWNLOAD APP</button>
            </div>
        </div>
    </div>
</section> 
<section id="usercard">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <span>
                    <h3>2 Lakhs+</h3>
                    <p>USERS</p>
                </span>
                <span class="horizontal-line"></span>
                <span>
                    <h3>₹ 1 Crore+</h3>
                    <p>IN DAILY WINNINGS</p>
                </span>
            </div>
        </div>
    </div>
</section>
<section id="dcomapny">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-white m-both">
                <h2 class="heading">It's easy to start playing on 
                    <span>D Company Matka</span>
                </h2>
            </div>            
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6">
                <div class="dc-box">
                    <span>1</span>
                    <h3>Select A Game</h3>
                    <p>Choose a game that you want to play</p>
                    <div class="SelectGamebox">
                        <div class="SelectGame">
                            <p>Jodi Game</p>
                            <p>Crosing Game</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="dc-box">
                    <span>2</span>
                    <h3>Select A Number</h3>
                    <p>Choose a number that you want to place a bet</p>
                    <div class="SelectGamebox">
                        <div class="SelectGame">
                            <span>01</span>
                            <span>02</span>
                            <span>03</span>
                            <span>04</span>
                            <span>05</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="dc-box">
                    <span>3</span>
                    <h3>Place A Bet</h3>
                    <p>Place a bet on number that you have selected and win money</p>
                    <div class="SelectGamebox">
                        <div class="SelectGame">
                            <span>01
                                <p class="prize"><i class="fa fa-rupee-sign">12</i></p>
                            </span>
                            <span>02</span>
                            <span>03</span>
                            <span>04</span>
                            <span>05</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section id="Dmarket">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-white m-both">
                <h2 class="heading">Todays
                    <span>Result</span>
                </h2>
            </div>            
        </div>
        <div class="row justify-content-center">

            @php
            date_default_timezone_set('Asia/Kolkata');
            $date=date("Y-m-d");
            $time=date("H:m:s");  
            $results = \DB::table('winning_number')
            ->leftJoin('live_games','live_games.id','winning_number.live_game_id')
            ->leftJoin('companies','companies.id','live_games.company')
            ->select('companies.name','companies.image','winning_number.number')
            ->whereDate('winning_number.created_at',$date)
            ->get();
            @endphp

            @forelse($results as $result)

            <div class="col-auto mb-2">
                <div class="cardbox">
                    <div class="marketlogo"><img src="{{env('APP_URL')}}/storage/{{$result->image}}" alt="MatkaApp"></div>
                    <div class="marketc">
                        <h3>{{$result->name}}</h3>
                        <p>Todays winner Number</p>
                    </div>
                    <p class="result">
                        {{$result->number}}
                    </p>
                </div>
            </div>


            @empty

            <h5 class="text-center">Results will be announced soon.</h5>

            @endif
            

             

        </div>

    </div>
</section>
<section id="Dreview">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-white m-both">
                <h2 class="heading">Reviews &
                    <span>Rating</span>
                </h2>
            </div>            
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <div class="ratingbox">
                    <div class="rating">
                        <p>4.5</p>
                         <span class="rating-star"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            <i class="fa fa-star-half-alt"></i></span>
                    </div>
                    <div class="rating-bar">
                        <div class="probox">
                            <p class="num">
                                5
                            </p>
                            <div class="progress">
                                <div class="progress-bar" style="width:100%;"></div>
                            </div>
                        </div>
                        <div class="probox">
                            <p class="num">
                                4
                            </p>
                            <div class="progress">
                                <div class="progress-bar" style="width:80%;"></div>
                            </div>
                        </div>
                        <div class="probox">
                            <p class="num">
                                3
                            </p>
                            <div class="progress">
                                <div class="progress-bar" style="width:60%;"></div>
                            </div>
                        </div>
                        <div class="probox">
                            <p class="num">
                                2
                            </p>
                            <div class="progress">
                                <div class="progress-bar" style="width:40%;"></div>
                            </div>
                        </div>
                        <div class="probox">
                            <p class="num">
                                1
                            </p>
                            <div class="progress">
                                <div class="progress-bar" style="width:20%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  


        @php

        $winners = \DB::table('winners')
        ->leftJoin('users','users.id','winners.user_id')
        ->leftJoin('live_games','live_games.id','winners.live_game_id')
        ->leftJoin('companies','companies.id','live_games.company')
        ->select('users.name','winners.profit','companies.name as cname')
        ->orderBy('winners.profit', 'desc')
        ->whereDate('winners.created_at',$date)
        ->limit(6)
        ->get();

        @endphp

        @if($winners)

        <div class="row winners">
            <div class="col-md-12">
                <div id="brands-carousel" class="owl-carousel owl-theme">
                    @foreach($winners as $winner)
                     <div class="item winner">
                        <p>{{$winner->name}}</p>
                        <h2>₹ {{$winner->profit}}</h2>
                        <h3>Winner of {{$winner->cname}}</h3>
                    </div>
                    @endforeach
                   
                  
                </div>
            </div>
        </div>

        @endif
      
    </div>
</section>
<section id="bannercard">
    <div class="container bannertwo">
        <div class="row">
            <div class="col-md-12">
                <h3>Compete with other games fans and Win</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="{{asset('images/bannertwo.svg')}}" alt="MatkaApp" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="B-con">
                    <span><img src="{{asset('images/usericon.png')}}" alt="MatkaApp" class="img-fluid"></span>
                    <p>Play with over 1 Crore D Company Matka users in public contests or create your own private contest</p>
                </div>
                <div class="B-con">
                    <span><img src="{{asset('images/userlogo.png')}}" alt="MatkaApp" class="img-fluid"></span>
                    <p>Invite others and get 3% commission for his game</p>
                </div>
                <div class="B-playstore">
                    <img src="{{asset('images/playstore.png')}}" alt="MatkaApp" class="img-fluid">
                    <img src="{{asset('images/storlogo.png')}}" alt="MatkaApp" class="img-fluid">
                </div>
                <div class="B-con">
                    <img src="{{asset('images/bar.png')}}" alt="MatkaApp" class="img-fluid">
                    <p>Scan the QR Code to download the app</p>
                </div>

                
            </div>
        </div>
    </div>
</section>
<section id="dfaq">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center text-white m-both">
                <h2 class="heading">D Company Matka
                    <span>FAQ</span>
                </h2>
            </div>            
        </div>
        <div class="row justify-content-center">
            <div class="col-auto dfaq">
                <div id="accordion">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            What is D Company Matka?
                          </button>
                        </h5>
                      </div>
                  
                      <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Can I actually win money on D Company Matka?
                          </button>
                        </h5>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Is it safe to add money to D company Matka?
                          </button>
                        </h5>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry.
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>


@include('partials.footer')