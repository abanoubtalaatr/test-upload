$(function(){
  $('#banner-carousel').slick({
    dots: true,
    arrows: false
  });
  $('#store-carousel').slick({
    dots: true,
    speed: 300,
    slidesToShow: 6,
    slidesToScroll: 3,
    prevArrow:'<button class="caro-arrow prev-arrow"><img src="assets/imgs/home/right-arrow.svg"><button>',
    nextArrow:'<button class="caro-arrow next-arrow"><img src="assets/imgs/home/left-arrow.svg"><button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  });
  $('#center-carousel').slick({
    dots: true,
    speed: 300,
    slidesToShow: 6,
    slidesToScroll: 3,
    prevArrow:'<button class="caro-arrow prev-arrow"><img src="assets/imgs/home/right-arrow.svg"><button>',
    nextArrow:'<button class="caro-arrow next-arrow"><img src="assets/imgs/home/left-arrow.svg"><button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  });
  $('#product-carousel').slick({
    dots: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 2,
    prevArrow:'<button class="caro-arrow prev-arrow"><img src="assets/imgs/home/right-arrow.svg"><button>',
    nextArrow:'<button class="caro-arrow next-arrow"><img src="assets/imgs/home/left-arrow.svg"><button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  });
  $('#product-carousel2').slick({
    dots: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 2,
    prevArrow:'<button class="caro-arrow prev-arrow"><img src="assets/imgs/home/right-arrow.svg"><button>',
    nextArrow:'<button class="caro-arrow next-arrow"><img src="assets/imgs/home/left-arrow.svg"><button>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }
    ]
  });
  //toggle steps
  //toggle steps
  $('.next-step-btn').on('click',function() {
    $(this).parents('.step').hide();
    $(this).parents('.step').next().show();
    //timer
    if($('#timer').is(":visible")){
      var timer2 = $('#timer').html();
      var interval = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        //minutes = (minutes < 10) ?  minutes : minutes;
        $('#timer').html(minutes + ':' + seconds);
        if (minutes < 0) clearInterval(interval);
        //check if both minutes and seconds are 0
        if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
        timer2 = minutes + ':' + seconds;
      }, 1000);
    }
  });
  $('.prev-step-btn').on('click',function() {
    $(this).parents('.step').hide();
    $(this).parents('.step').prev().show();
  });
  //confirm box
  $('#confirm-box input').keyup(function(){
    if(this.value.length==$(this).attr("maxlength")){
        $(this).next().focus();
    }
  });
  //range slider
  var range = $(".range").attr("value");
  $("#slide-info").html(range);
  $(".slide").css("width", "20%");
  console.log('slide');
  $(document).on('input change', '.range', function() {
    $('#slide-info').html( $(this).val() );
    var slideWidth = $(this).val() * 100 / 1000;
    console.log('width'+slideWidth);
    $(".slide").css("width", slideWidth + "%");
  });
  //increament
  $(".pro-increase").on("click", function () {
    var num = $(".pro-number");
    var curr_quantity = parseInt(num.val());
    if (curr_quantity<100) {
      num.val(curr_quantity + 1);
    }
  });
  $(".pro-decrease").on("click", function () {
    var num = $(".pro-number");
    var curr_quantity = parseInt(num.val());
    if (curr_quantity>1) {
      num.val(curr_quantity - 1);
    }
  });
  //datepicker
  $('.datepicker').datepicker();
  //nav tabs
  $('input[name="pay-m"]').click(function () {
    $(this).tab('show');
    $(this).removeClass('active');
  });
  //account edit
  $('.edit-info').on('click',function(){
    $('.profile').hide();
    var getDiv ='.' + $(this).attr('id');
    $(getDiv).show();
    $(getDiv).addClass('profile-active');
  });
  $('.prev-profile').on('click',function() {
    $('.profile-active').hide();
    $('.profile').show();
  });
  //star rating
  $(".rateyo").rateYo({
    rtl: true,
    normalFill:"#A6AE9B",
    ratedFill:"#F6C900"
  }).on("rateyo.change", function (e, data) {
    $('#rate-val').text(data.rating);
  });
  //like products
  $('.pro-like').each(function(){
    $(this).on('click',function(){
      $(this).find('i').toggleClass('liked');
    });
  });
});
//map
/*function initMap() {
    // The location of Uluru
  if($('#map').length){
    const uluru = {lat: -33.9, lng: 151.2};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center:uluru
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
      position: uluru,
      map: map,
    });
  }
  else{
    return null;
  }
}*/