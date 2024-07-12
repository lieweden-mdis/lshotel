<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - TRIPLE ROOM</title>
    <link rel="icon" href="img/icon.jpg" >
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/room-details.css">
</head>
      
<body>

<?php include 'header.php'; ?>

<!--Room-->

    <div class="room-header">
        <span class="header">Triple Room</span>
    </div>
    <div class="roomcontainer">
        <div class="room-gallery">
                <div class="mySlides">
                  <img src="img/room-image/triple-room/triple1.jpg"  alt="roomimg1" style="width:100%">
                </div>
              
                <div class="mySlides">
                  <img src="img/room-image/triple-room/triple2.jpg" alt="roomimg2" style="width:100%">
                </div>
              
                <div class="mySlides">
                  <img src="img/room-image/triple-room/triple3.webp" alt="roomimg3" style="width:100%">
                </div>
                  
                <div class="mySlides">
                  <img src="img/room-image/triple-room/triple4.jpg" alt="roomimg4" style="width:100%">
                </div>
                  
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
              
                <div class="caption-container">
                  <p id="caption"></p>
                </div>
              
                <div class="row">
                  <div class="column">
                    <imgsrc="img/room-image/gallery.webp" alt="gallery" style="width:100%">
                    <img class="demo" src="img/room-image/triple-room/triple1.jpg" onclick="currentSlide(1)" alt="">
                  </div>
                  <div class="column">
                    <img class="demo" src="img/room-image/triple-room/triple2.jpg" onclick="currentSlide(2)" alt="">
                  </div>
                  <div class="column">
                    <img class="demo" src="img/room-image/triple-room/triple3.webp" onclick="currentSlide(3)" alt="">
                  </div>
                  <div class="column">
                    <img class="demo" src="img/room-image/triple-room/triple4.jpg" onclick="currentSlide(4)" alt="">
                  </div>  
                </div>
              </div>

        <div class="room-details">
            <span class="price">RM 500 per night</span>
            <div class="features">
                <span class="label">Features</span>
                <div class="features-list">
                  <span class="features-items">1 Queen Bed</span>
                  <span class="features-items">1 Single Bed</span>
                  <span class="features-items">Smoking</span>
                  <span class="features-items">Non-Smoking</span>
                </div>
            </div>
            <div class="facility">
                <span class="label">Facilities</span>
                <div class="facility-list">
                    <span class="facility-items">Mobility accessibility</span>
                    <span class="facility-items">Hair dryer</span>
                    <span class="facility-items">Private bathroom</span>
                    <span class="facility-items">Toiletries</span>
                    <span class="facility-items">Towels</span>
                    <span class="facility-items">Satellite/cable channels</span>
                    <span class="facility-items">Telephone</span>
                    <span class="facility-items">Fan</span>
                    <span class="facility-items">Slippers</span>
                    <span class="facility-items">Air conditioning</span>
                    <span class="facility-items">Coffee/tea maker</span>
                    <span class="facility-items">Mineral Water</span>
                    <span class="facility-items">Refrigerator</span>
                    <span class="facility-items">Daily housekeeping</span>
                    <span class="facility-items">Desk</span>
                    <span class="facility-items">Window</span>
                    <span class="facility-items">Closet</span>
                    <span class="facility-items">Ironing facilities</span>
                    <span class="facility-items">Safety Box</span>
                </div>
            </div>
            <div class="size">
                <span class="label">Size</span>
                <span class="size-info">17 m²/183 ft²</span>
            </div>
            <button>Book Now</button>
            <div class="availability">
              <span>Room Availability: 9</span>
            </div>
        </div>
      </div>
        <!--Room Description-->
        <div class="room-descripion">
          <span class="description-header">Description</span>
          <p class="description-content">
            Experience comfort and convenience in our well-appointed Triple Room, designed to cater to the needs of small groups or families. This room offers a perfect blend of functionality and style, ensuring a pleasant and memorable stay.
          </p>
        </div>

    <footer>
        <p>&copy;2024 L's Hotel  All Right Reserved.</p>
    </footer>
    
    </body>
    <script src="script/room-details.js" type="text/javascript"></script>
    </html>