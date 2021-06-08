<?php
$my_header = "Edit Form";
include "include/header.php";
?>
<?php
require "include/connect.php";
include "classes/operations.php";
use Ops as O;
if (isset($_GET['id'])) {
    $userData = new O\GetData();
    $userData->id = $_GET['id'];
    $getData = $userData->getUserData($conn);
}
if (isset($_POST['updatedata'])) {
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = "";
    $updated = "";
    $nameErr = $validation->validate_name();
    $emailErr = $validation->validate_email();
    $phoneErr = $validation->validate_phone();
    $addressErr = $validation->validate_address();
    if (!$nameErr && !$emailErr && !$phoneErr && !$addressErr) {
        $updated_user = new O\EditData();
        $updated_user->serial_id = $_GET['i'];
        $updated_user->id = $_POST['id'];
        $updated_user->name = $_POST['name'];
        $updated_user->email = $_POST['email'];
        $updated_user->phone = $_POST['phone'];
        $updated_user->address = $_POST['address'];
        //Check Email if already exists
        $check_email = new O\CheckEmail();
        $check_email->id = $_POST['id'];
        $check_email->email = $_POST['email'];
        $email_while_update = $check_email->checkEmailWhileUpdate($conn);
        if($email_while_update){
            $email_updated = "Email Updated Successfull";
            
            $updated = $updated_user->update($conn);
            if (!$updated) {
                echo "Error:" . mysqli_error($conn);
            } else {
                session_start();
                $_SESSION['success'] = $updated;
                header('Location: index.php');
            }
        }else{
            $duplicate="Email Already Exists, try something new";
        }
    }
}
?>
<body>
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>
<h4 style="color:green; font-size:2vw;"><?php if (isset($email_updated)) {
    echo $email_updated;
} ?></h4>
<form class="addForm" method="post">
<input type="hidden" name="id" id="id" value="<?php echo $getData['id']; ?>" >
    <div class="singleform">
        
        <label>Name : </label>
        
        <input type="text" name="name" id="name" value="<?php echo $getData['name']; ?>">
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email" value="<?php echo $getData['email']; ?>">
        <span style="color:red"><?php if (isset($emailErr)) {
            echo $emailErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone" value="<?php echo $getData['phone']; ?>">
        <span style="color:red"><?php if (isset($phoneErr)) {
            echo $phoneErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        <?php echo $getData['address']; ?>
        </textarea>
        <span style="color:red"><?php if (isset($addressErr)) {
            echo $addressErr;
        } ?></span> 
    </div>
    <button type="submit" name="updatedata">Submit</button>
</form>

</div>
</body>
</html>
