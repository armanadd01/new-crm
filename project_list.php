<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
            <?php if($_SESSION['login_type'] != 3 && $_SESSION['login_type'] != 4): ?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_project"><i class="fa fa-plus"></i> Add New project</a>
			</div>
            <?php endif; ?>
		</div>
		<div class="card-body table-responsive-sm">
			<table class="table tabe-hover table-condensed table-sm w-auto tb_class table-bordered" id="list">
				<colgroup>
					<col width="4%">
					<col width="12%">
					<col width="8%">
					<col width="8%">
					<col width="8%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>To Do</th>
						<th>Client ID</th>
						<th>Quantity</th>
						<th>File Type</th>
						<th>Folder</th>
						<th>Brief</th>
						<th>Date Started</th>
						<th>End Date</th>
						<!--<th>Deadline Time</th>-->
						<th>Time Left</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$stat = array("Pending","Started","On-Progress","Finished","Over Due","Done");
					$where = "";
					if($_SESSION['login_type'] == 2){
						$where = " where manager_id = '{$_SESSION['login_id']}' ";
					}elseif($_SESSION['login_type'] == 3){
						$where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
					}
					$qry = $conn->query("SELECT * FROM project_list $where order by name asc");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
					 	$tprog = $conn->query("SELECT * FROM project_list where status = 2")->num_rows;
					 	$pnprog = $conn->query("SELECT * FROM project_list where status = 0")->num_rows;
					 	$odprog = $conn->query("SELECT * FROM project_list where status = 4")->num_rows;
					 	$dprog = $conn->query("SELECT * FROM project_list where status = 5")->num_rows;
					 	$qprog = $conn->query("SELECT * FROM project_list where project_quantity = {$row['quantity']} and status = 2");
		                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
		                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
		                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
						/*if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
						if($prod  > 0  || $cprog > 0)
		                  $row['status'] = 2;
		                else
		                  $row['status'] = 1;
						elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
						$row['status'] = 4;
						endif;*/
						//$qty = 0;
						$z = date_default_timezone_set("Asia/Dhaka");
						$d=strtotime("now");
						$asd = date("Y-m-d h:i:sa", $d);
						$asdt = date("h:i", $d);
						$as = date("Y-m-d", $d);
						$start_time = strtotime($row['start_date'])/86400;
						$end_time = strtotime($row['end_date'])/86400;
						$time_left= $end_time - $d;
						$days = floor(($time_left /1000* 60 * 60 * 24) );
                        $hours = floor(($time_left - $days* 60 * 60 * 24) / 60 * 60);
                        $countdown = round(($end_time - $d)/86400);
						$nowdateM=date('Y-m-d H:i:s',strtotime( $row['end_date'] ,strtotime($row['end_date'])));
                        $nowdate=strtotime($nowdateM);
                        $m=date('M',$nowdate);
                        $d=date('d',$nowdate);
                        $y=date('Y',$nowdate);
                        $time=date("H:i:s",$nowdate);
					    
						if(strtotime("now") > strtotime($row['end_date']) && $row['status'] != 3 && $row['status'] != 5):
						if( strtotime("today") > strtotime($row['end_date']) && $row['status'] != 5 && $row['status'] != 3 )
						  $row['status'] = 4;
                        else
                            $row['status'] = 4;
						  endif;
						  /*
						if($time_left >= strtotime($row['end_date'])):
						if($time_left >= (time()-strtotime($row['start_date']))/86400/100*50 )
                            $color='yellow';
                        elseif ($time_left>(time()-strtotime($row['start_date']))/86400/100*70 )
                            $color='orange';
                        elseif ($time_left>(time()-strtotime($row['start_date']))/86400/100*90 )
                            $color='yello';
                        else
                            $color='#00FFFF';
						endif;
						*/
					?>
					<?php if($stat[$row['status']] !='Finished'): ?>
					<tr style="background:<?php if($stat[$row['status']] =='Pending'){
							echo "#DCDCDC !important;";
						}elseif($stat[$row['status']] =='On-Progress'){
							echo "#EEE8AA !important";
						}elseif($stat[$row['status']] =='Over Due'){
							  	echo "#DC143C !important";
						}elseif($stat[$row['status']] =='Done'){
							echo "#90EE90 !important";
						}
						?>; display: <?php if($stat[$row['status']] =='Finished'){
							//echo "none";
						} ?>">
						<th class="text-center th_class_lt armanent1723"><?php if($stat[$row['status']] !='Finished'){
						 echo $i++;
						}  ?></th>
						<td>
							<p><b class="addReadMore showlesscontent"><?php echo ucwords($row['name']) ?></b></p>
							<p class="truncate addReadMore showlesscontent"><b style="color: #007BFF;"> <?php echo ucwords($row['subname']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['client']) ?></b></p>
						</td>
						<td>
							<p><b><?php echo ucwords($row['quantity']) ?></b> /<b style="color: #007BFF;"><?php echo ucwords($row['subquantity']) ?></b></p>
						</td>
						<td>
						    <p><b><?php echo ucwords($row['file']) ?></b> /<b style="color: #007BFF;"><?php echo ucwords($row['subfile']) ?></b></p>
						</td>
						<td>
						    <p class="addReadMore showlesscontent"><?php echo ucwords($row['folder']) ?></p>
						</td>
						<td>
						    <p class="addReadMore showlesscontent"><?php echo ucwords($row['description']) ?></p>
						</td>
						<td style="color:<?php if(strtotime($row['start_date']) < strtotime("today")){
							echo "red";
						}else{
						    echo "#000000";
						}
						?>;"><b><?php echo date("M d, Y",strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y",strtotime($row['end_date'])) ?></b></td>
						<td>
						    <b><?php echo date(" h:i a",strtotime($row['end_date'])) ?></b>
						</td>
						<!--<td>
						    <b id="" class="countdDemo"><?php//  echo /*$days;*/ date(" h:i:s", strtotime($days));  ?></b>
						</td>-->
						<td class="text-center">
							<?php
							  if($stat[$row['status']] =='Pending'){
							  	echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
							  }elseif($stat[$row['status']] =='Started'){
							  	echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
							  }elseif($stat[$row['status']] =='On-Progress'){
							  	echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
							  }elseif($stat[$row['status']] =='Finished'){
							  	echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
							  }elseif($stat[$row['status']] =='Over Due'){
							  	echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
							  }elseif($stat[$row['status']] =='Done'){
							  	echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
							  }
							?>
						</td>
						<td class="text-center th_class_rt">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_project&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <?php if($_SESSION['login_type'] != 3 && $_SESSION['login_type'] != 4): ?>
		                      <a class="dropdown-item delete_project" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                  <?php endif; ?>
		                    </div>
						</td>
					</tr>
					<?php endif; ?>
				<?php endwhile; ?>
				</tbody>
				<tbody style="background-color:#A7E7FF; ">
				    
				    <tr style="display: <?php ?>">
				        <td style="border-radius: 0px 0px 0px 5px;"></td>
				        <td class="text-primary"> Total job <b><?php echo number_format($tprog + $dprog + $odprog); ?></b></td>
				        <td class="text-primary">Total Quantity</td>
				        <td class="text-primary armanent001"><b class="armanent002"><?php /*echo $tprog;*/
				        $qty= 0 ;
				        $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
				        while($row= $qry->fetch_assoc()):
				        if($stat[$row['status']] !='Finished' ):
				            $qty += $row['quantity'];?>
				            
				       <p class="armanent003"><?php  echo $qty; ?></p>
				        <?php    
				        endif;
				        endwhile;
				        ?> </b></td>
				        <td class="text-danger">Panding <b> <?php echo number_format($pnprog); ?></b></td>
				        <td></td>
				        <td class="text-info">On Progress <b><?php echo number_format($tprog); ?></b></td>
				        <td></td>
				        <td class="text-danger">Over Due <b><?php echo number_format($odprog); ?></b></td>
				        <td></td>
				        <td class="text-success"> Done <b > <?php echo number_format($dprog); ?></b></td>
				        <td style="border-radius: 0px 0px 5px 0px;"></td>
				    </tr>
				    
				</tbody>
				
			</table>
			
		</div>
	</div>
</div>
<style>
	table p{
		margin: unset !important;
	}
	table td{
		vertical-align: middle !important;
	}
	
table.table-bordered{
    border:0px solid transparent;
    margin-top:20px;
 }
.armanent1723 {
     border:transparent !important;
    border-bottom:1px solid #333333 !important;
}

.armanent002 b {
    display:none !important;
}



table.table-bordered > thead > tr > th {
    border:transparent !important;
    border-bottom:1px solid #333333 !important;
}
table.table-bordered > tbody > tr > td{
    border:transparent !important;
    border-bottom:1px solid #333333 !important;
}
	
	
	.addReadMore.showlesscontent .SecSec,
    .addReadMore.showlesscontent .readLess {
    display: none;
}

    .addReadMore.showmorecontent .readMore {
    display: none;
}

    .addReadMore .readMore,
    .addReadMore .readLess {
    font-weight: bold;
    margin-left: 2px;
    color: blue;
    cursor: pointer;
    overflow: hidden;
    width: 20%;
    margin: auto;
    position: relative;
    z-index: 9;
}

    .addReadMoreWrapTxt.showmorecontent .SecSec,
    .addReadMoreWrapTxt.showmorecontent .readLess {
    display: block;
}

.SecSec{
    border: 0.5px solid #0000FF;
    box-shadow: 2px 2px 15px #0000FF;
    display: block;
    overflow: hidden;
    width: 30%;
    margin: auto;
    position: fixed;
    background: #EDEDED !important;
    z-index: 99;
    border-radius:3px;
    color: #000000 !important;
}


tbody tr .th_class_lt {
    border-left: 1px solid #DEE2E6 !important;
}
tbody tr .th_class_rt {
    border-right: 1px solid #DEE2E6 !important;
}

.armanent001 .armanent002 p {
    display: none;
}
.armanent001 .armanent002 p:last-child {
    display: block !important;;
}

@media (prefers-color-scheme: dark) {
  /* defaults to dark theme */
  tr {
      --color:red;
  }
}

* {
  font-family: Arial, Helvetica, sans-serif;
}

</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	
	$('.delete_project').click(function(){
	_conf("Are you sure to delete this project?","delete_project",[$(this).attr('data-id')])
	})
	})
	function delete_project($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_project',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	function AddReadMore() {
    //This limit you can set after how much characters you want to show Read More.
    var carLmt = 20;
    // Text to show when text is collapsed
    var readMoreTxt = "+";
    // Text to show when text is expanded
    var readLessTxt = "-";


    //Traverse all selectors with this class and manupulate HTML part to show Read More
    $(".addReadMore").each(function() {
        if ($(this).find(".firstSec").length)
            return;

        var allstr = $(this).text();
        if (allstr.length > carLmt) {
            var firstSet = allstr.substring(0, carLmt);
            var secdHalf = allstr.substring(carLmt, allstr.length);
            var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
            $(this).html(strtoadd);
        }

    });
    //Read More and Read Less Click Event binding
    $(document).on("click", ".readMore,.readLess", function() {
        $(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
    });
}
$(function() {
    //Calling function after Page Load
    AddReadMore();
});








</script>