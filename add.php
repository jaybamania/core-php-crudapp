<?php
$my_header = 'Add Form';
include("include/header.php");
?>
<?php
include "classes/operations.php";
use Ops as O;
require("include/connect.php");
if(isset($_POST['adddata'])) {
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];

    //Variables for Error Messages
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = "";
    //Variable for Successful Message
    $created = "";

    $nameErr = $validation->validate_name();
    $emailErr = $validation->validate_email();
    $phoneErr = $validation->validate_phone();
    $addressErr = $validation->validate_address();

    if(!$nameErr && !$emailErr && !$phoneErr && !$addressErr){
        $user = new O\Add();
        // $table->title = "My table";
        // $table->numRows = 5;
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->phone = $_POST['phone'];
        $user->address = $_POST['address'];
        
        $check_email = new O\CheckEmail();
        $check_email->email = $_POST['email'];
        $duplicate=$check_email->checkEmail($conn);
	
        if(!$duplicate){
            $created= $user->insert($conn);
            if(!$created){
                echo "Error:".mysqli_error($conn);
            }
            else{
                session_start();
                $_SESSION['success'] = $created;
                header('Location: index.php');
            }
        }  
    }
    else{
        echo $nameErr;
        echo $emailErr;
        echo $phoneErr;
        echo $addressErr;
    }
    

}

?>
<body>
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if(isset($duplicate)){ echo $duplicate;}  ?></h4>
<h4 style="color:green; font-size:2vw;"><?php if(isset($created)){ echo $created;}  ?></h4>
<form class="addForm" method="POST">
    <div class="singleform">
        <label>Name : </label>
        
        <input type="text" name="name" id="name">
        <br />
        <span style="color:red"><?php if(isset($nameErr)){echo $nameErr;} ?></span> 
       
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email">
        <span style="color:red"><?php if(isset($emailErr)){echo $emailErr;} ?></span> 
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone">
        <span style="color:red"><?php if(isset($phoneErr)){echo $phoneErr;} ?></span> 
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        
        </textarea>
        <span style="color:red"><?php if(isset($addressErr)){echo $addressErr;} ?></span> 
    </div>
    <button type="submit" name="adddata">Submit</button>
</form>

</div>
</body>
</html>
