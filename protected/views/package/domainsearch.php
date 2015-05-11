<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<!-- Services block BEGIN -->
  <div class="services-block content content-center" id="services">
    <div class="container">
      <h2>Search<strong>Domain</strong></h2>
      <form action="" method="post">
          <input type="hidden" name="package_id" id="package_id" value="<?php echo $_GET['package_id']; ?>">
          <input type="text" name="domain" id="domain" placeholder="Enter Domain Name">
          <input type="button" name="submit"  value="Search" id="search">
      </form>
      <div id="suggestedDomain"> </div>
    </div>
  </div>
  <!-- Services block END -->
  <script>
$('#search').click(function(){
var package_id = $('#package_id').val(); 
var domain = $('#domain').val();
var dataString = 'domain='+domain+'&package_id='+package_id;  
var url = $('#URL').val();
$.ajax({
type: "GET",
url: "availabledomain",
data: dataString,
cache: false,
success: function(html){

document.getElementById("suggestedDomain").innerHTML = html;	 

}
});
});
  </script>