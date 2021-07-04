<?php include 'db_connect.php' ?>
<div class="card-tools" style="margin: 30px auto; margin-top:0px;">
	<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_employee"><i class="fa fa-plus"></i> Add New Invoice</a>
</div>
    <div class="card-tools">
        <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> Print</button>
    </div>
 <div class="col-md-12" id="printable">
     
     
    	<div class="invoice_header">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="invoice_head">
						<img src="https://www.clippingworld.com/wp-content/uploads/2021/03/250x250.png" alt="">
						<h2>Clipping World ltd</h2>
						<h3>BILL TO: <span>Name</span></h3>
						<h3>June, 2021</h3>
					</div>
					<div class="invoince_details">
						<table class="table m-0 table-bordered">
							<colgroup>
								<col width="70%">
								<col width="30%">
							</colgroup>
							<tbody>
								<tr>
									<td>
										<p class="bold">Client Name: <span class="name"> </span></p>
										<p class="bold">Company Name: <span class="name"> </span></p>
										<p class="bold">Address: <span class="name"> </span></p>
										<br><br>
										<p class="bold">Contact No# <span class="name"> </span></p>
										<p class="bold">Email: <span class="name"> </span></p>
										<p class="bold">Website: <span class="name"> </span></p>
 									</td>
 									<td>
 										<p class="bold">Invoice No#</p>
 										<p class="bold">Invoice Date:</p>
 									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
	</div> 
     
     
     
     
     
        <div class="card card-outline card-success">
          <!--<div class="card-header">
            <b>Project Progress</b>
            
          </div>-->
          <div class="card-body p-0 table-responsive-sm">
            <div class="table-responsive">
              <table class="table m-0 table-bordered" id="list">
                 <colgroup>
                  <col width="5%">
                  <col width="7%">
                  <col width="10%">
                  <col width="8%">
                  <col width="8%">
                  <col width="18%">
                  <col width="8%">
                  <col width="10%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>To Do</th>
                  <th>Client ID</th>
				  <th>Quantity</th>
				  <th>File Type</th>
				  <th>Folder</th>
				  <th>Brief</th>
                  <!--<th>Status</th>-->
                  <th>Price</th>
                  <th>Total Price</th>
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
                $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                $prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
                $prog = $prog > 0 ?  number_format($prog,2) : $prog;
                $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                $dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
                $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
                if($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])):
                if($prod  > 0  || $cprog > 0)
                  $row['status'] = 2;
                else
                  $row['status'] = 1;
                elseif($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])):
                $row['status'] = 4;
                endif;
                  ?>
                  <?php if($stat[$row['status']] =='Finished'): ?>
                  <tr style="display: <?php if($stat[$row['status']] !='Finished'){
							//echo "none";
						} ?>">
                      <td>
                         <?php if($stat[$row['status']] =='Finished' && !false ){
							echo $i++;
						}elseif( $row['status'] == !true ){
						    echo '51';
						}
						
						?>
                      </td>
                      <td>
							<p><b><?php echo date("d M, y",strtotime($row['start_date'])) ?></b></p>
					  </td>
                      <td>
                          <a>
                              <?php echo ucwords($row['name']) ?>
                          </a>
                          <br>
                          <!--<small>
                              Due: <?php //echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>-->
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
                      <td>
							<p><b>$ <?php echo ucwords($row['price']) ?></b></p>
					  </td>
                      <td class="text-center th_class_rt">
							<!--<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                    </div>-->
		                    <?php echo ucwords($row['quantity'])*ucwords($row['price']) ?>
						</td>
                      
                      
                  </tr>
                  <?php endif; ?>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        
        <div class="invoice_footer">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="invoince_foot">
						<table class="table m-0 table-bordered">
							<colgroup>
								<col width="70%">
							</colgroup>
							<tbody>
								<tr>
									<td>
									<p>Please pay us at our <span class="paypal">PayPal</span> account</p>
									<p><span class="paypal">PayPal Email:</span> </p>
									<p>Thanks For regards</p>
									<p>Md Sajidur Rahman</p>
									<p>Founder & Managing Director</p>
									<p class="company">Clipping World Ltd.</p>
									<p class="bottom">info@clippingworld.com | connectclippingworld@gmail.com | <span class="skype"> Skype:</span> connect_clippingworld |+1(973) 607 3131</p>
 									</td>
								</tr>
							</tbody>
						</table>
					</div>
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
            
    .invoice_head {
		margin: 0 auto !important;
		text-align: center;
	}
	.invoice_head img{
		display: block;
		margin: 0 auto !important;
		text-align: center !important;
		width: 8%;
	}
	.invoice_head h2{
		font-family: 'Open Sans', sans-serif;
		font-weight: 800;
		text-align: center !important;
		text-transform: uppercase !important;
		color: #4DD3C4;
	}
	.invoince_details bold {
		font-weight: 600;

	}

	.invoince_foot .paypal {
		color: #81AD63;
		font-weight: 700;

	}

	.invoince_foot .company {
		text-transform: uppercase;
		color: #4DD3C4;
		font-weight: 800;
	}
	.invoince_foot .bottom {
		font-size: 12px;
		font-weight: 200;
	}
	.invoince_foot .skype {
		color: #008DDD;
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
		var _d = "<p class='text-center'><b>Invoice as of (<?php echo date("F d, Y") ?>)</b></p>"
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
	});
	
	$('#list').daterangepicker({
    "showDropdowns": true,
    "showWeekNumbers": true,
    "showISOWeekNumbers": true,
    "autoApply": true,
    "ranges": {
        "Today": [
            "2021-07-02T13:25:57.310Z",
            "2021-07-02T13:25:57.310Z"
        ],
        "Yesterday": [
            "2021-07-01T13:25:57.310Z",
            "2021-07-01T13:25:57.310Z"
        ],
        "Last 7 Days": [
            "2021-06-26T13:25:57.310Z",
            "2021-07-02T13:25:57.310Z"
        ],
        "Last 30 Days": [
            "2021-06-03T13:25:57.310Z",
            "2021-07-02T13:25:57.310Z"
        ],
        "This Month": [
            "2021-06-30T18:00:00.000Z",
            "2021-07-31T17:59:59.999Z"
        ],
        "Last Month": [
            "2021-05-31T18:00:00.000Z",
            "2021-06-30T17:59:59.999Z"
        ]
    },
    "alwaysShowCalendars": true,
    "startDate": "06/26/2021",
    "endDate": "07/02/2021"
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
});
	
	
	
</script>