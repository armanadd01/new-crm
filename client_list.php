<?php include 'db_connect.php' ?>
 <div class="col-md-12">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Client Info List</b>
            <div class="card-tools">
            	<button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
            </div>
            <?php if($_SESSION['login_type'] != 3 && $_SESSION['login_type'] != 4): ?>
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_client"><i class="fa fa-plus"></i> Add New Clients</a>
			</div>
            <?php endif; ?>
          </div>
          <div class="card-body p-0 table-responsive-sm">
            <div class="table-responsive" id="printable">
              <table class="table m-0 table-bordered" id="list">
                 <colgroup>
                  <col width="5%">
                  <col width="7%">
                  <col width="10%">
                  <col width="8%">
                  <col width="8%">
                  <col width="8%">
                  <col width="8%">
                  <col width="19%">
                  <col width="10%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>Client ID</th>
                  <th>To Do</th>
				  <th>Quantity</th>
				  <th>File Type</th>
				  <th>Folder</th>
				  <th>Brief</th>
                  <th>Status</th>
                  <th>Price</th>
                  <th>Action</th>
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
                $qry = $conn->query("SELECT * FROM client_list $where order by name asc");
                //while($row= $qry->fetch_assoc()):
               // $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                //$cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                //$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                //$prog = $prog > 0 ?  number_format($prog,2) : $prog;
                //$prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                //$dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
                //$dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
                //if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                //if($prod  > 0  || $cprog > 0)
                 // $row['status'] = 2;
                //else
                 // $row['status'] = 1;
                //elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                $row['status'] = 4;
                //endif;
                  ?>
                  <?php //if($stat[$row['status']] =='Finished'): ?>
                  <tr style="display: <?php if($stat[$row['status']] !='Finished'){
							//echo "none";
						} ?>">
                      <td>
                         <?php if($stat[$row['status']] =='Finished'){
							echo $i++;
						} ?>
                      </td>
                      <td>
							<p><b><?php echo date("d M, y",strtotime($row['start_date'])) ?></b></p>
					  </td>
					  
                      <td>
							<p><b><?php echo ucwords($row['client_name']) ?></b></p>
					  </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['client']) ?>
                          </a>
                          <br>
                          <!--<small>
                              Due: <?php //echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>-->
                      </td>
                      <td>
							<p><b><?php echo ucwords($row['company']) ?></b> /<b style="color: #007BFF;"><?php //echo ucwords($row['subquantity']) ?></b></p>
					  </td>
                      <td>
						    <p><b><?php echo ucwords($row['tin']) ?></b> /<b style="color: #007BFF;"><?php //echo ucwords($row['subfile']) ?></b></p>
					  </td>
					  <td>
						    <p class="addReadMore showlesscontent"><?php echo ucwords($row['cmail']) ?></p>
						</td>
					  <td>
						    <p class="addReadMore showlesscontent"><?php echo ucwords($row['address']) ?></p>
						</td>
                      <!--<td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php// echo $prog ?>%">
                              </div>
                          </div>
                          <small>
                              <?php //echo $prog ?>% Complete
                          </small>
                      </td> -->
                      <td class="project-state">
                          <?php/*
                            if($stat[$row['status']] =='Pending'){
                              echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
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
                            }*/
                          ?>
                      </td>
                      <td>
							<p><b>$ <?php echo ucwords($row['cmail']) ?></b></p>
					  </td>
                      <td class="text-center th_class_rt">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_client&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                    </div>
						</td>
                      
                      
                  </tr>
                  <?php// endif; ?>
                <?php// endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        
        <style>
            
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
            }
            
            .addReadMoreWrapTxt.showmorecontent .SecSec,
            .addReadMoreWrapTxt.showmorecontent .readLess {
                display: block;
            }
            .card-tools {
                margin-right:10px !important;
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
    var carLmt = 60;
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


	$('#print').click(function(){
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("","","width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)
	})
</script>