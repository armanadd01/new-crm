<?php include 'db_connect.php' ?>
<div class="card-tools" style="margin: 30px auto; margin-top:0px;">
	<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_employee"><i class="fa fa-plus"></i> Add New Employee</a>
</div>
 <div class="col-md-6" style="float:left; display:inline-block">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Morning Shift</b>
          </div>
          <div class="card-body p-0 table-responsive-sm">
            <div class="table-responsive">
              <table class="table m-0 table-bordered " id="list0">
                 <colgroup>
                  <col width="10%">
                  <col width="20%">
                  <col width="30%">
                  <col width="20%">
                  <col width="20%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>Name </th>
                  <th>In time</th>
                  <th>Action</th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $qry = $conn->query("SELECT * FROM shift_list $where order by id asc");
                while($row= $qry->fetch_assoc()):
                  ?>
                  <?php if($row['shift'] == 1 ): ?>
                  <tr >
                      <td>
                         <?php 
							echo $i++;
						?>
                      </td>
                      <td>
							<p><b><?php echo date("d M, y",strtotime("now")) ?></b></p>
					  </td>
                      <td>
                          <a>
                              <?php echo $row['member_name']; ?>
                          </a>
                      </td>
                      <td>
							<p><b><?php echo date(" h:i a",strtotime("10:00:00")) ?></b></p>
					  </td>
					  <td class="text-center th_class_rt">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_employee&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                    </div>
						</td>
                      
                      
                  </tr>
                  <?php endif; ?>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        
        
        <div class="col-md-6" style="float:right; display:inline-block">
        <div class="card card-outline card-success">
          <div class="card-header">
            <b>Evening Shift</b>
          </div>
          <div class="card-body p-0 table-responsive-sm">
            <div class="table-responsive">
              <table class="table m-0 table-bordered list" id="list1">
                 <colgroup>
                  <col width="10%">
                  <col width="20%">
                  <col width="30%">
                  <col width="20%">
                  <col width="20%">
                </colgroup>
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>Name </th>
                  <th>In time</th>
                  <th>Action</th>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $qry = $conn->query("SELECT * FROM shift_list $where order by id asc");
                while($row= $qry->fetch_assoc()):
                  ?>
                  <?php if($row['shift'] == 2 ): ?>
                  <tr>
                      <td>
                         <?php 
							echo $i++;
						
						?>
                      </td>
                      <td>
							<p><b><?php echo date("d M, y",strtotime("now")) ?></b></p>
					  </td>
                      <td>
                          <a>
                              <?php echo $row['member_name']; ?>
                          </a>
                          <br>
                          <!--<small>
                              Due: <?php //echo date("Y-m-d",strtotime($row['end_date'])) ?>
                          </small>-->
                      </td>
                      <td>
							<p><b><?php echo date(" h:i a",strtotime("14:00:00")) ?></b></p>
					  </td>
					  <td class="text-center th_class_rt">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_project" href="./index.php?page=view_project&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_employee&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                    </div>
						</td>
                  </tr>
                  <?php endif; ?>
                <?php endwhile; ?>
                </tbody>  
              </table>
            </div>
          </div>
        </div>
        </div>
        
        
        
        
        
        
        
<script>
	$(document).ready(function(){
		$('#list0').dataTable()
		$('#list1').dataTable()
		
	
	$('.delete_employee').click(function(){
	_conf("Are you sure to delete this Employee?","delete_employee",[$(this).attr('data-id')])
	})
	})
	function delete_employee($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_employee',
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

</script>