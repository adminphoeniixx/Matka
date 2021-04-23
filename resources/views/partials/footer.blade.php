<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 text-md-center">
                <img src="{{asset('images/footerlogo.svg')}}" alt="MatkaApp" class="img-fluid">
                <div class="social-icon">
                    <a href="https://www.facebook.com/"><img src="{{asset('images/facebook.svg')}}" alt="fb" class="img-fluid"></a>
                    <a href="https://www.instagram.com/"><img src="{{asset('images/instagram.svg')}}" alt="ins" class="img-fluid"></a>
                    <a href="https://telegram.org/"><img src="{{asset('images/telegram.svg')}}" alt="tel" class="img-fluid"></a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <ul class="links">
                    <li><a href="">Download App</a></li>
                    <li><a href="{{route('howtoplay')}}">How to Play</a></li>
                    <li><a href="">Invite Friends</a></li>
                    <li><a href="">Privacy Policy</a></li>
                    <li><a href="{{route('termsandconditions')}}">Terms and Conditions</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6">
                <ul class="links">
                    <li><a href="{{route('aboutus')}}">About Us</a></li>
                    <li><a href="">Helpdesk</a></li>
                    <li><a href="">Community</a></li>
                    <li><a href="">Guidelines</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-6 contact-details">
                <p class="title">Contact Us</p>
                <p class="phone"><img src="{{asset('images/phoneicon.svg')}}" alt="Matka"><a href="tel:+919515845525">+91 9515845525</i></a></p>
                <p class="title">Corporate Office</p>
                <p class="addres">Frist Floor, G-187, Sector 63 Rd, Block M, Mamura Sector 63, Noida, Uttar Pradesh 201301</p>
            </div>
        </div>
        <div class="row message">
            <div class="col-md-12 text-center">
                <div class="horizontal-line"></div>
                <p>The game involves an element of financial risk and may be addictive. please play resposibly at your own risk.
                    The game is applicable for people above 18 only.
                </p>
            </div>
        </div>
    </div>

</section>
<div class="stricky-downloadapp sticky">
    <a href="" class="downloadapp">Download App</a>
</div>
</body>
</html>
<script>
    $('.stricky-downloadapp').fadeOut();
    $(document).scroll(function() {
  var y = $(this).scrollTop();
  var x =  screen.width;
  if ( x < 767 & y > 600) {
    $('.stricky-downloadapp').fadeIn();
  } else {
    $('.stricky-downloadapp').fadeOut();
  }
});
    $('#brands-carousel').owlCarousel({
           loop:true,
           autoplay:true,
           margin:20,
           nav:false,
           responsiveClass:true,
           responsive:{
               0:{
                   items:1
               },
               600:{
                   items:2
               },
               1000:{
                   items:3,
                   loop:false
               }
           }
         })
</script>
