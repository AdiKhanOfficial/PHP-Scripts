<?php
include("include/userLib.php");
if(!isLogin()){
	header("location:login.php");
	exit();
}

if(isset($_POST["uploadCSV"])){
	 $file = $_FILES['contactFile']['tmp_name'];
	 $group = $_POST["groupName"];
	 $userId = decryptMe($_COOKIE["bwmsu"]);
	 
	 if($group == ""){
		 $alertMessage =  showAlert("Please Enter a Group Name","danger");
		 $chatArea = "upload";
	 }
	 else if($file == ""){
		 $alertMessage = showAlert("Please Select a File","danger");
		 $chatArea = "upload";
	 }
	 else{
			$checkGroup = mysqli_query($conn,"SELECT * FROM groups WHERE group_name = '$group' and group_owner_id = '$userId'");
		 if(mysqli_num_rows($checkGroup)>0){
			 $row = mysqli_fetch_assoc($checkGroup);
			 $groupId = $row[id];
		 }
		 else{
			 $query = mysqli_query($conn,"INSERT INTO groups (group_name,group_owner_id) values('$group','$userId') ");
			 if($query){
				 $groupId = mysqli_insert_id($conn);
			 }
		 }
		 $file2 = $_FILES['contactFile']['name'];
		 $type = strtolower(pathinfo($file2, PATHINFO_EXTENSION));
		 if(!($type == "csv" || $file == "")){
			 $alertMessage = showAlert("Invalid File Type ($type)","danger"	);
			 $chatArea = "upload";
		 }
		 else{
			$adding = true;
		 } 
	 }
	 

	 
}

include("include/head.php");

?>
<div class="row content" align="center">
	<div class="col-sm-1"></div>
		<div class="col-sm-10 login" align="center">
			<div class="row">
					<div class="col-sm-12"><hr>
						<span class="alertMessage"><?php echo $alertMessage; ?> </span><hr><br>
						<div class="row">
							<div class="col-lg-4 groupsPan"  align="left">
								<br>
								<input type="text" class="search form-control input" id="groupSearch" placeholder="Search Group"/><hr>
								<?php
								$userId = decryptMe($_COOKIE["bwmsu"]);
								$filter = "groups";
								if(isset($_POST["showGroups"])){
									$filter = "groups";
								}
								else if(isset($_POST["showContacts"])){
									$filter = "contacts";
								}
								else if(isset($_POST["showCSV"]) ){
									$chatArea = "upload";
								}
								if($filter == "groups"){
									echo"<h4 class='groupsHeading'>Available Groups</h4><hr>
									<div id='contacts'>";
									$query = mysqli_query($conn, "SELECT * FROM groups where group_owner_id='$userId'");
									if(mysqli_num_rows($query) > 0){
										while($row = mysqli_fetch_assoc($query)){
											$id = $row["id"];
											$encryptedId = encryptMe($row["id"]);
											$groupName = $row["group_name"];
											$groupDescription = $row["group_description"];
											$photo = "./css/images/groups/".$row["group_photo"];
											
											if(!is_file($photo) || !file_exists($photo)){
												$photo = "css/images/groups/default.png";
											}
											
											echo "
												<table class='contact'>
												<tr ><td width='50px'><img src='$photo' class='contactLogo'/></td>
												<td class='contactName'  data-type='group' data-id='$encryptedId' onclick='startChat(this)'><h4>$groupName</h4></td>
												<td class='contactActions'>
													<form action='' method='post'>
														<input type='hidden' value='$' name='showGroups'/>
														<input type='hidden' value='$encryptedId' name='id'/>
														<button class='defaultButton' name='eidtGroup'  title='Edit Group Details'><span class='glyphicon glyphicon-edit'></span></button>
													</form>
												</td></tr>
											</table>
											";
										}
									}
									echo "</div>";
								}
								if($filter == "contacts"){
									echo"<h4 class='groupsHeading'>Available Contacts</h4><hr>
									<div id='contacts'>";
									$query = mysqli_query($conn, "SELECT * FROM contacts where owner_id='$userId'");
									if(mysqli_num_rows($query) > 0){
										while($row = mysqli_fetch_assoc($query)){
											$id = $row["id"];
											$encryptedId = encryptMe($row["id"]);
											$contactName = $row["contact_name"];
											$contactNo = $row["contactNo"];
												$photo = "css/images/contacts/default.png";
											
											
											if($contactName == ""){
												$contactName  = $contactNo;
											}
											
											echo "
												<table class='contact'>
												<tr ><td width='50px'><img src='$photo' class='contactLogo'/></td>
												<td class='contactName' data-type='user' data-id='$encryptedId' onclick='startChat(this)'><h4>$contactName</h4></td>
												<td class='contactActions'>
													<form action='' method='post'>
														<input type='hidden' value='' name='showContacts'/>
														<input type='hidden' value='$encryptedId' name='id'/>
														<button class='defaultButton' name='editContact' title='Edit Contact Details'><span class='glyphicon glyphicon-edit'></span></button>
													</form>
												</td></tr>
											</table>
											";
										}
									}
									echo "</div>";
								}
									
								
								?>
								<div id="tools">
									<form action="" method="post" style="display:inline-block">
										<button type="submit" name="showCSV"  title="Upload Contacts"><span class="glyphicon glyphicon-floppy-open"></span></button>
										<button type="submit" name="showGroups" Title="Groups">
											<span class="glyphicon glyphicon-user">
											</span><span class="glyphicon glyphicon-user"></span>
										</button>
										<button type="submit" name="showContacts" title="Contacts"><span class="glyphicon glyphicon-user" ></span></button>
										
									</form>
									<a href='signout.php'>
										<button  type="none" style='float:right' title="Logout"><span class="glyphicon glyphicon-log-out" ></span></button></a>
									
								</div>
							</div>
							<div class="col-lg-8 groupsPan"  align="center" id="chatArea">
								<?php
									if($chatArea == "upload"){
										echo "<div class='row'>
												<div class='col-lg-1'>
												
												</div>
												<div class='col-lg-10'>
													<br><br><h3>Upload Contacts</h3><hr>
													<form action='' method='post' enctype='multipart/form-data'>
														<input type='text' class='form-control input' name='groupName' placeholder='Group Name'/><br>
														<input type='file' class='form-control input2' name='contactFile' placeholder='Group Name'/><br>
														<span class='form-control input2' align='left'><input type='checkbox' style='padding:10px' name='saveContacts' value='save'	/> Save</span><br>
														<input type='submit' class='input btn myButton' name='uploadCSV'value='Upload'/>
													</form>
												</div><div class='col-lg-1'>
												
												</div>
												
												</div>";
									}
									else if($adding){
										$handle = fopen($file, "r");
										$count = 0;
										$added = 0;
										$row = 0;;
										$total = 0;
										while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
											$name = $filesop[0];
											$contact = $filesop[1];
											$city = $filesop[2];
											$country = $filesop[3];
											if($row == 0){
												echo $row;
												if($name != "Name" || $contact != "Contact" || $city != "City" || $country != "Country"){
													$alertMessage = showAlert("Invalid File Structure $name","danger");
													
													break;
												}
												$row += 1;
											}
											else{
												$sql = "INSERT INTO contacts (contact_name, contact_no, contact_city, contact_country, owner_id) VALUES ('$name','$contact', '$city','$country','$userId')";
												$query = mysqli_query($conn,$sql);
												
												if($query){
													$contactId = mysqli_insert_id($conn);
													$addToGroup = mysqli_query($conn, "INSERT INTO groupsdetails (group_id,contact_id) values('$groupId','$contactId')");
													if($addToGroup){
													$added += 1;
												}
												else{
													echo "$sql";
												}
											}
											$total += 1;
											$values = ""; 	
										}
									}
									}
									if($added > 0){
										$id = $groupId;
										echo "<div id='chatBox'>";
											$query  = mysqli_query($conn, "SELECT * FROM groups WHERE	 id = '$id'");
											$sql = mysqli_query($conn, "SELECT * FROM contacts where id in (SELECT contact_id FROM groupsdetails WHERE group_id='$id')");
											if(mysqli_num_rows($query) == 0){
												echo "<h4 style='margin-top:30%'>Unknown Group</h4>";
											}
											else{
												$group = mysqli_fetch_assoc($query);
												$group_name = $group["group_name"];
												
												$groupMembers = mysqli_num_rows($sql);
												if($groupMembers > 0){
													$contacts = "$groupMembers Contacts";
												}
												else{
													$contacts = "No Contact";
												}
												
												echo "<h4 class='groupsHeading' align='left'>$group_name ($contacts)</h4>";
												echo "<div style='max-height:450px;height:450px;overflow-Y:scroll;overflow-wrap: break-word' align='right'>";
												
												if($groupMembers > 0){
													while($row = mysqli_fetch_assoc($sql)){
														$id = $row["id"];
														$encryptedId = encryptMe($row["id"]);
														$contactName = $row["contact_name"];
														$contactNo = $row["contact_no"];
															$photo = "css/images/contacts/default.png";
														
														
														if($contactName == ""){
															$contactName  = $contactNo;
														}
														
														echo "
															<table class='chatContact pending' data-contact='$contactNo'>
															<tr ><td width='70px'><img src='$photo' class='contactLogo'/></td>
															<td class='contactName'><h4>$contactName</h4></td>
															<td class='chatStatus'>
																<span class='glyphicon glyphicon-trash' onclick='this.parentElement.parentElement.parentElement.parentElement.remove();' style='margin-left:-10px'/> </span>
															</td></tr>
														</table>
														";
													}
												}
													
													
												echo "</div>";
												if($groupMembers > 0)
												echo "<table style='width:101%;background:white;height:183px'>
												<tr><td><textarea class=' input' id='msg' style='position:sitcky;bottom:2px;max-width:90%;width:100%;max-height:180px;height:100%;border:none;' autofocus></textarea></td><td  style='width:10px' valign='bottom'><button id='cancelButton' class='btn myButton' onclick='cancelBulk()';>Cancel Bulk</button><button id='sendButton' class='btn myButton' onclick='bulkStart()';>Send Bulk</button></td></tr></table><br><br>
												";
											}
										
										echo "</div><br><br>";
									}
										
									else{
										echo '<div class="declaration"><h3>Warning !</h3><p  >
											It is to inform you that your WhatsApp account can be banned permanently by WhatsApp team due to spreading any suspecious or spam messages. We will not be responsible for this. Be careful!
										</p>';
									}
								?>
								
								
							</div>
						</div>
						
					</div>
			</div>
	</div>
	<div class="col-sm-1"></div>
</div>
<script src="js/chat.js">

</script>
<?php include("include/foot.php");?>