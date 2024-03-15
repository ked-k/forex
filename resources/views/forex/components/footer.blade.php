<footer class="page-footer">
    <p class="mb-0">Copyright ©{{date('Y')}}. <a target="_blank" href="https://ripontechug.com/">Ripon Technologies Ug Ltd</a> all right reserved.  <a target="_blank" href="https://ked.ripontechug.com">@ked</a></p>
</footer>
            <div class="modal fade hide" id="modal-smN">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title text-center text-warning">PAYMENT REMINDER</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Hi Mutagooka Forex,<br>
Domain and Hosting is Due for Renewal on January 12th, 2023.  

<b>Important: At the expiry date, if the domain/hosting has not been renewed, you will lose access to it and any services or products attached to it will cease to work.</b>
Again, please reach out if you have any questions on this payment. Otherwise, please organize for settlement to avoide any further inconviniance.
<br>
Kind regards,
Ripon Tech Ug Ltd
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
            </div>
          </div>
        </div>
      </div>
  {{-- <script type="text/javascript">
    window.onload = function () {
        OpenBootstrapPopup();
    };
    function OpenBootstrapPopup() {
        $("#modal-smN").modal('show');
    }
</script> --}}
   <div class="modal fade hide" id="modal-smNbn">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title text-center text-warning">PAYMENT REMINDER</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                             <h4>Dear customer ,</h4> 
                              <p>You are left with <span class="text-success" id="demo"></span> and Some features will be disabled due to standing payments<br>
                <span class="text-danger">Please contact our support team to avoid inconveniences.</span>
                </p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
              
            </div>
          </div> 
        </div> 
      </div>
       /.modal 
    <script>
// Set the date we're counting down to
var countDownDate = new Date("July 9, 2022 00:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "DISABLED";
  }
}, 1000);
</script>