<?php
	if(isset($_POST['savemode'])){
		$savemode = $_POST['savemode'];
		
		if($savemode === "edit"){
			// Edit mode entered
			$id = $db->escape_string($_POST['id']);
				// SQL was successful
				// Is there a changed password?
			if($_POST['password'] !== ""){
				$pass_ok = check_new_pass($_POST['password'], $_POST['password_rep']);
				if($pass_ok === true){
					// Password is okay and can be set
					$pass_hash = gen_pass_hash($_POST['password']);
					write_pass_hash_to_db($pass_hash, $id);
					// $editsuccessful = true;
					add_message("success", "User edited successfully.");
						
				}
				else{
					// Password is not okay
					// $editsuccessful = 2;
					add_message("fail", $PASS_ERR_MSG);
				}
			}
			else{
					// Redirect user to user list
				header("Location: ".FRONTEND_BASE_PATH."admin/listusers/?edited=1");
			}				
		}
		
		else if($savemode === "create"){
			// Create mode entered
			$username = $db->escape_string($_POST['username']);
			$domain = $db->escape_string($_POST['domain']);			
			$pass = $_POST['password'];
			$pass_rep = $_POST['password_rep'];
			
			if($username !== "" && $domain !== "" && $quota !== ""){
				// All fields filled with content
				// Check passwords
				$pass_ok = check_new_pass($pass, $pass_rep);
				if($pass_ok === true){
					// Password is okay ... continue
					$pass_hash = gen_pass_hash($pass);
					
					$sql = "INSERT INTO `".DBT_USERS."` (`".DBC_USERS_USERNAME."`, `".DBC_USERS_DOMAIN."`, `".DBC_USERS_PASSWORD."`) VALUES ('$username', '$domain', '$pass_hash')";
					
					if(!$result = $db->query($sql)){
						die('There was an error running the query [' . $db->error . ']');
					}
					
					// Redirect user to user list
					header("Location: ".FRONTEND_BASE_PATH."admin/listusers/?created=1");
				}
				else{
					// Password not okay
					add_message("fail", $PASS_ERR_MSG);
				}
			}
		 	else{
		 		// Fields missing
		 		add_message("fail", "Not all fields were filled out.");
		 	}		
		}
	}
	
	
	// Select mode 
	$mode = "create";	
	if(isset($_GET['id'])){
		$mode = "edit";
		$id = $db->escape_string($_GET['id']);
	}
	
	if($mode === "edit"){
		//Load user data from DB
		$sql = "SELECT * from `".DBT_USERS."` WHERE `".DBC_USERS_ID."` = '$id' LIMIT 1;";
		
		if(!$result = $db->query($sql)){
			die('There was an error running the query [' . $db->error . ']');
		}
		
		while($row = $result->fetch_assoc()){
			$username = $row[DBC_USERS_USERNAME];
			$domain = $row[DBC_USERS_DOMAIN];
		}
	}
?>



<h1><?php if($mode === "create") { ?> Create <?php } else {?>Edit <?php } ?>User</h1>


<?php output_messages(); ?>


<p>
	<a class="button button-small" href="<?php echo FRONTEND_BASE_PATH; ?>admin/listusers/">&#10092; Back to user list</a>
</p>

<p>
<?php 
	if($mode === "edit"){
		echo "Username and domain cannot be edited.";
	}
?>
</p>

<form action="" method="post">	
	<table>
	<tr> <th>Username</th> <th>Domain</th> <th>Password</th> </tr>
	
	<tr>
		<td>
			<input name="username" class="textinput" type="text" autofocus value="<?php if(isset($username)){echo $username;} ?>" placeholder="Username" required="required"/>
		</td>
		
		<td>
			@ 
			<select name="domain">
				<?php  
				//Load user data from DB
				$sql = "SELECT `".DBC_DOMAINS_DOMAIN."` FROM `".DBT_DOMAINS."`;";
				
				if(!$result = $db->query($sql)){
					die('There was an error running the query [' . $db->error . ']');
				}
				
				while($row = $result->fetch_assoc()){
					$selected = "";
					if(isset($domain) && $row[DBC_DOMAINS_DOMAIN] === $domain){$selected = "selected=\"selected\"";}
					echo "<option value=\"".$row[DBC_DOMAINS_DOMAIN]."\" ".$selected." >".$row[DBC_DOMAINS_DOMAIN]."</option>";
				}
				?>
			</select>
		</td>
		
		<td>
			<input name="password" class="textinput" type="password" placeholder="New password"/></br>
			<input name="password_rep"  class="textinput" type="password" placeholder="New password (repeat)"/>
		</td>
	</tr>
	
	</table>
	
	<input name="savemode" type="hidden" value="<?php if(isset($mode)){echo $mode;} ?>"/>
	<input name="id" class="sendbutton" type="hidden" value="<?php if(isset($id)){echo $id;} ?>"/>
	
	<p>
		<input type="submit" class="button button-small" value="Save settings">
	</p>
</form>