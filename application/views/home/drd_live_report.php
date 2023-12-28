<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="refresh" content="60">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		Dr. Distributor || Live Report
    </title>
    <meta charset utf="8">
	<meta name="theme-color" content="#f7625b">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	
	<style>
		body{
			font-size:12px;
			margin:0px;
			padding:0px;
		}
		table {
  border-collapse: separate !important;
  border-spacing: 0 !important;
  border-top: 1px solid grey !important;
}

td, th {
  margin: 0 !important;
  border: 1px solid grey !important;
  white-space: nowrap !important;
  border-top-width: 0px !important;
}

.div1 {
  width: 90% !important;
  overflow-x: scroll !important;
  margin-left: 8em !important;
  overflow-y: visible !important;
  padding: 0 !important;
}

.headcol {
  position: absolute !important;
  width: 7em !important;
  left: 0 !important;
  top: auto !important;
  border-top-width: 1px !important;
  /*only relevant for first row*/
  margin-top: -1px !important;
  /*compensate for top border*/
  padding:5px !important;
}

.headcol:before {
  content: '';
}

.long {
	cursor: pointer;
	padding:5px;
  //background: yellow;
  //letter-spacing: 1em;
}
	</style>
</head>

	<body>
	<div class="div1">
				<?php
				foreach(range('A', 'Z') as $elements) {}
					
					$loc = "";
					$result = $this->Drd_Invoice_Model->drd_live_report($elements);
					foreach($result as $row)
					{ 
						if($loc!=$row->scode){
							$loc = $row->scode;
							?>								
								<table cellspacing="1" cellpadding="1" style="margin-top:5px;">
								<tr>
								<th class="headcol">
								<?= $row->scode;?>
								</th>
								<?php
								$result2 = $this->Drd_Invoice_Model->drd_live_report2($row->scode,"deliverby");
								foreach($result2 as $row2)
								{ 
								?>
								<td class="long" style="background:#383845;color:white;text-align:center;" onclick="open_div('<?= $row2->altercode;?>','<?= $row2->mtime;?>','<?= $row2->tagno;?>','<?= $row2->amt;?>','<?= $row2->personalmsg;?>','<?= $row2->vno;?>','<?= $row2->gstvno;?>','<?= $row2->name;?>','<?= $row2->mobile;?>','<?= $row2->dispatchtime;?>','<?= $row2->checkedby;?>','<?= $row2->pickedby;?>','<?= $row2->deliverby;?>')">
									(<?= $row2->altercode;?>) <span style="font-size:8px;"><?= $row2->mtime;?></span>	</td>
								<?php
								}
								$result2 = $this->Drd_Invoice_Model->drd_live_report2($row->scode,"pickedby");
								foreach($result2 as $row2)
								{
								?>
								<td class="long" style="background:#a54343;color:white;text-align:center;"onclick="open_div('<?= $row2->altercode;?>','<?= $row2->mtime;?>','<?= $row2->tagno;?>','<?= $row2->amt;?>','<?= $row2->personalmsg;?>','<?= $row2->vno;?>','<?= $row2->gstvno;?>','<?= $row2->name;?>','<?= $row2->mobile;?>','<?= $row2->dispatchtime;?>','<?= $row2->checkedby;?>','<?= $row2->pickedby;?>','<?= $row2->deliverby;?>')">
									(<?= $row2->altercode;?>) <span style="font-size:8px;"><?= $row2->mtime;?></span>
								</td>
								<?php
								}
								if(empty($result2))
								{
									?>
									<td class="long">Empty</td>
									<?php
								}
								?>
								</tr>
							</table>
							<?php
						}
					}
					
				?>
		</div>
	</body>
</html>
<button class="modalopen" data-toggle="modal" data-target="#exampleModal" style="display:none;"></button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size:15px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
function open_div(altercode,mtime,tagno,amt,personalmsg,vno,gstvno,name,mobile,dispatchtime,checkedby,pickedby,deliverby)
{
	$(".modalopen").click();
	$("#exampleModalLabel").html(gstvno+" -- "+name+" ("+altercode+") Mobile "+mobile);
	$(".modal-body").html("Time : "+mtime+"<br>Dispatchtime : " +dispatchtime+"<br>Amt : "+amt+"<br>checkedby : "+checkedby+"<br>Pickedby : "+pickedby+"<br>Deliverby : "+deliverby+"<br><b>Massage : "+personalmsg+"</b>");
}
</script>