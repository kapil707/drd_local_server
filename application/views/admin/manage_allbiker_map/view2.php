<div class="row">
	<?php /* <meta http-equiv="refresh" content="30" />*/ ?>
    <div class="col-xs-12" style="margin-bottom:5px;">		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>		<?php */ ?>
   	</div>
    <div class="col-xs-12">
	<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 600px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>		
        <div id="map"></div>
    <script>
setTimeout(function(){
  initMap();
}, 600000000000000);
// Initialize and add the map
function initMap() {
  // The location of Uluru
   var locations = [
   <?php
   $i = 1;
   
   $result = $this->db->query("SELECT * FROM `tbl_tracking` WHERE `id`='$id'")->result();   
   foreach($result as $row) { 
		$row->name = $row->user_name1." - (". $row->user_phone1.") <br> Time:-".$row->time."--".$row->date;
	?>
		["<?= $row->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
   <?php 
   $i++;
   } 
    
   $latitude = $row->latitude;
   $longitude = $row->longitude;?>
	["<?= $row->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 18,
      center: new google.maps.LatLng(<?= $latitude;?>, <?= $longitude;?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
	
setTimeout(function(){
initMap();
}, 600000000);
}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
	<?php $mapapikey =  $this->Scheme_Model->get_website_data("mapapikey") ;?>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?=$mapapikey ?>&callback=initMap">
    </script>
    </div>
		<div class="col-xs-12"><br><br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
                        	Name
                        </th>
						<th>
                        	View Info
                        </th>
						<th>
                        	Wake Up
                        </th>
                    </tr>
                </thead>
				<tbody>
                <?php
				$i=1;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $row->id; ?>">
                    	<td>
                        	<?= $i++; ?>
                        </td>
 						<td>
                        	<?= $row->name; ?>
                        </td>
						<td>
							<a href="<?= base_url()?>admin/<?= $Page_name; ?>/view2/<?= $row->id; ?>">
							View Info</a>
                        </td>
						<td>
							<a onClick="wakeup('<?= $row->id; ?>');" href="#">
							Wake Up </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function create_copy_order(id)
{
	if (confirm('Are you sure Resend?')) { 
		order_id = $(".order_id_"+id).val();
		$.ajax({
		type       : "POST",
		data       :  {order_id:order_id},
		url        : "<?= base_url()?>admin/<?= $Page_name; ?>/create_copy_order",
		success    : function(data){
				if(data!="")
				{
					java_alert_function("success","Created Successfully");
				}
				else
				{
					java_alert_function("error","Something Wrong")
				}
			}
		});
	}
}

function wakeup(id)
{
	if (confirm('Are you sure wakeup?')) { 
		order_id = $(".order_id_"+id).val();
		$.ajax({
		type       : "POST",
		data       :  {id:id},
		url        : "<?= base_url()?>admin/<?= $Page_name; ?>/wakeup",
		success    : function(data){
				if(data!="")
				{
					java_alert_function("success","Successfully");
				}
				else
				{
					java_alert_function("error","Something Wrong")
				}
			}
		});
	}
}
</script>