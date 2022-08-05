<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<body>
<?php require_once('home_navbar.php'); ?>

<div class="container">
    <h3 class="mt-3">Tournament Searcher</h3>
    <div class="row">
        <div class="mt-4 bg-dark text-white rounded container">
            <h5 class="m-3">Search Filters</h5>
            <div class="row ms-2 me-2">
                <div class="col-sm-3 mt-2">
                    <div class="form-group">
                        <label for="country">City</label>
                        <input type="text" class="form-control" id="country" name="country">
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <div class="form-group">
                        <label for="country">Province</label>
                        <input type="text" class="form-control" id="province" name="province">
                    </div>
                </div>

                <div class="col-sm-4 mt-2">
                    <div class="form-group">
                        <label for="country">Format</label>
                        <select name="format" id="format" class="form-select">
                            <option value=""></option>
                            <option value="modern">Modern</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-2 mt-2">
                    <div class="form-group">
                        <label for="country">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                </div>
            </div>

            <p class="d-inline-block m-3 text-muted">At least 1 field is obligatory to search (*)</p>
            <button class="btn btn-dark-primary active m-3 d-inline-block" style="float:right;">Search</button>
        </div>

        <div class="row mt-4 mb-3" id="searched-tournaments">
            <div class="card ms-5" style="width: 14rem; background-color: #1b1a1a;">
                <img src="https://images.squarespace-cdn.com/content/v1/59309136ff7c50b2917d4985/1633299708682-MRK58XDLJJIX3NP5ENXU/OnlineStore_EventTicket_MtG_Modern_Tournament_MONDAYS_MHK.png?format=1000w" class="card-img-top mt-3 rounded" style="height: 130px;">
                <div class="card-body" style="margin-left: -0.5rem;">
                    <h6>Open Modern 2022</h6>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-location-dot"></i> Magic Barcelona - Barcelona</span><br>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> 07/07/2022 - 10:00 PM</span>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> 20/30 players</span>
                    <span class="text-muted"><b style="font-size:20px; color:#4723D9;">20€</b>/player</span>
                    <hr style="width: 100%;">
                    <center><a href="/profile/0"><button class="btn btn-dark-primary d-inline-block">View Site</button></a><button class="btn btn-dark-primary active d-inline-block ms-2"><i class="fa-solid fa-cart-shopping"></i></button></center>
                </div>
            </div>            
        </div>
    </div>
</div>
</body>

<script>
    $( document ).ready(function() {
        $("#SearchTour").addClass('active');

        locate();
    });  

    function locate() {
        navigator.geolocation.getCurrentPosition(success, error);
        function success(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;

            $.getJSON("https://api.opencagedata.com/geocode/v1/json?q="+latitude+"+"+longitude+"&key=604b367e1bd34ca29e5df3b3e76eefe3", function(data) {
                console.log(data);
            });
        }

        function error(){

        }
    }
</script>
</html>