<?php if(!isset($conn)){ include 'db_connect.php'; } 



$z = date_default_timezone_set("Asia/Dhaka");
$d=strtotime("now");
$asd = date("Y-m-d\TH:i", $d);
$as = date("Y-m-d", $d);
?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-client">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row">
			<?php if($_SESSION['login_type'] != 3 && $_SESSION['login_type'] != 4): ?>
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Client Name</label>
					<input type="text" class="form-control form-control-sm" name="client_name" value="<?php echo isset($client_name) ? $client_name : '' ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Client ID</label>
					<input type="text" class="form-control form-control-sm" name="clientid" value="<?php echo isset($client) ? $client : '' ?>">
					
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Company Name</label>
					<input type="text" class="form-control form-control-sm" name="folder" value="<?php echo isset($company) ? $company : '' ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Business ID/TIN</label>
					<input type="text" class="form-control form-control-sm" name="file" value="<?php echo isset($tin) ? $tin : '' ?>">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Contact No.</label>
					<input type="text" class="form-control form-control-sm" name="quantity" value="<?php echo isset($contact) ? $contact : '' ?>">
				</div>
			</div><?php //if(empty(isset($price))): ?>  
			<div class="col-md-4">
				<div class="form-group">
					<label for="" class="control-label">Email</label>
					<input type="text" class="form-control form-control-sm" name="price" value="<?php echo isset($cmail) ? $cmail : '' ?>">
				</div>
			</div>
			<?php //endif; ?>
		</div>
        <div class="row">
      	<input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
      	    <div class="col-md-6">
      	        <div class="form-group">
    				<label for="" class="control-label">Bill To </label>
    				<input type="text" class="form-control form-control-sm" name="file" value="<?php echo isset($bill) ? $bill : '' ?>">
    			</div>
      	    </div>
          <!--<div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Project Team Members</label>
              <select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
              	<option></option>
              	<?php/* 
              	$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
              	while($row= $employees->fetch_assoc()):*/
              	?>
              	<option value="<?php echo $row['id'] ?>" <?php// echo isset($user_ids) && in_array($row['id'],explode(',',$user_ids)) ? "selected" : '' ?>><?php// echo ucwords($row['name']) ?></option>
              	<?php// endwhile; ?>
              </select>
            </div>
          </div>-->
        </div>
        
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Address</label>
					<textarea name="address" id="" cols="30" rows="10" class=" form-control">
						<?php echo isset($address) ? $address : '' ?>
					</textarea>
				</div>
			</div>
			<?php endif; ?>
		</div>
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    		    <?php // if(isset($status) && $status == 5 && $_SESSION['login_type'] == 1 ): ?>
    		    <!-- <button class="btn btn-flat  bg-gradient-info mx-2" form="">Finished</button> -->
    		    <?php // endif; ?>
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-client">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=clients_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
</div>

<script>
	$('#manage-client').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_client',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=client_list'
					},2000)
				}
			}
		})
	})

</script>