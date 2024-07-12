<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL - STANDARD ROOM</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/room-details.css">
    <style>
        .room-description {
            display: flex;
            flex-direction: column;
            height: fit-content;
            margin: 1% 2% 2% 2%;
            padding: 1%;
            border-radius: 0.5em;
            box-shadow: rgba(187, 201, 211, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        }

        .room-description .description-header {
            font-size: 2em;
            font-weight: bold;
        }

        .room-description .description-content {
            font-size: 1.1em;
            line-height: 1.5;
        }

        .book-now-btn {
            margin-top: 10px;
            padding: 10px;
            font-size: 1em;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .book-now-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <!--Room-->
    <div class="room-header">
        <span class="header" id="roomType">Standard Room</span>
    </div>
    <div id="roomDetails"></div>
    
    <footer>
        <p>&copy;2024 L's Hotel All Right Reserved.</p>
    </footer>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var roomType = document.getElementById('roomType').textContent;

        // Make an AJAX request to fetch room details
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch-room-details.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('roomDetails').innerHTML = xhr.responseText;
                // Re-initialize slideshow functions after content load
                initSlideshow();
                
                // Check room availability and disable book now button if necessary
                var availability = document.getElementById('roomAvailability').value;
                var bookNowButton = document.getElementById('bookNow');
                if (availability == 0) {
                    bookNowButton.disabled = true;
                    bookNowButton.textContent = 'Not Available';
                } else {
                    bookNowButton.addEventListener('click', function() {
                        window.location.href = 'booking.php?roomType=' + encodeURIComponent(roomType);
                    });
                }
            }
        };
        xhr.send('room_type=' + encodeURIComponent(roomType) + '&response_type=html');
    });

    function initSlideshow() {
        let slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("demo");

            if (slides.length === 0 || dots.length === 0) {
                console.error("Slideshow elements not found.");
                return;
            }

            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
        }

        document.querySelector('.prev').addEventListener('click', function() { plusSlides(-1); });
        document.querySelector('.next').addEventListener('click', function() { plusSlides(1); });
        document.querySelectorAll('.demo').forEach((element, index) => {
            element.addEventListener('click', function() { currentSlide(index + 1); });
        });
    }
    </script>
</body>
</html>
