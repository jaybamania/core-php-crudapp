<?php
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
        
        // if (mysqli_num_rows($duplicate)>0)
        // {
        //     $emailError = "<p style='color:red;'> This email is already registered</p>";

        // }	
        if(!$duplicate){
            $emailError = "<p style='color:red;'> This email is already registered</p>";
            echo $emailError;
        }   
        else{
            $runn= $user->insert($conn);
            if($runn){
                $created= "<h4 style='color:green;'>Account Created Successfully</h4>";
                echo $created;

            }else{
                // echo "Error: " . $insert . "    " . mysqli_error($conn);
                echo "Error:".mysqli_error($conn);
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


<form class="addForm" method="POST">
    <div class="singleform">
        <label>Name : </label>
        <input type="text" name="name" id="name">
        <!-- <span style="color:red">@error('name'){{$message}}@enderror</span> -->
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email">
        <!-- <span style="color:red">@error('email'){{$message}}@enderror</span> -->
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone">
        <!-- <span style="color:red">@error('phone'){{$message}}@enderror</span> -->
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        
        </textarea>
        <!-- <span style="color:red">@error('address'){{$message}}@enderror</span> -->
    </div>
    <button type="submit" name="adddata">Submit</button>
</form>

</div>
</body>
</html>
