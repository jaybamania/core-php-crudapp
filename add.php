<?php
$my_header = 'Add Form';
include "include/header.php";
?>
<?php
include "classes/operations.php";
use Ops as O;

require "include/connect.php";
if (isset($_POST['adddata'])) {
    $user = new O\Add();
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    if(isset($_POST['hobbies'])){$user->hobbies = implode(',', $_POST['hobbies']); }
    if(isset($_POST['education'])){$user->education = implode(',', $_POST['education']); }
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];
    if(isset($_POST['hobbies'])){$validation->hobbies = implode(',', $_POST['hobbies']);}
    if(isset($_POST['education'])){$validation->education = implode(',', $_POST['education']); }
    //Variables for Error Messages
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = $hobbiesErr = $educationErr = ""; 
    //Variable for Successful Message
    $created = "";
    //validations of every fields
    $nameErr = $validation->validate_name();
    $emailErr = $validation->validate_email();
    $phoneErr = $validation->validate_phone();
    $addressErr = $validation->validate_address();
    $hobbiesErr = $validation->validate_hobbies();
    $educationErr = $validation->validate_education();
    if (!$nameErr && !$emailErr && !$phoneErr && !$addressErr && !$hobbiesErr && !$educationErr) {
        //Check Email if already exists
        $check_email = new O\CheckEmail();
        $check_email->email = $_POST['email'];
        $duplicate = $check_email->checkEmail($conn);
        if (!$duplicate) {
            //if Email Already Mesg doesn't get then insert the data
            $created = $user->insert($conn);
            if (!$created) {
                echo "Error:" . mysqli_error($conn);
            } else {
                session_start();
                $_SESSION['success'] = $created;
                header('Location: index.php');
            }
        }
    }
}else{
    $user = new O\Add();
    $user->name = "";
    $user->email = "";
    $user->phone = "";
    $user->address = "";
    $user->hobbies="";
}
?>
<body>
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>
<form class="addForm" method="POST">
<div class="singleform">
        <label>Name : </label>
        
        <input type="text" name="name" id="name" value="<?php echo $user->name; ?>">
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email" value="<?php echo $user->email; ?>">
        <span style="color:red"><?php if (isset($emailErr)) {
            echo $emailErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone" value="<?php echo $user->phone; ?>">
        <span style="color:red"><?php if (isset($phoneErr)) {
            echo $phoneErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        <?php echo $user->phone; ?>
        </textarea>
        <span style="color:red"><?php if (isset($addressErr)) {
            echo $addressErr;
        } ?></span> 
    </div>
        <?php 
            $getData = new O\GetData();
            $educationData = $getData->getEducationData($conn);
            $hobbiesData = $getData->getHobbiesData($conn);
        ?>
      
        <div  class="singleform">
         <label>Education : </label>
            <select name="education[]" id="education" multiple>
            <?php
                foreach ($educationData as $row): ?>
                <option value="<?php echo $row['education_id'] ?>"><?php echo $row['education_name']?></option>
                <?php endforeach;
            ?>
            </select>
            <span style="color:red"><?php if (isset($educationErr)) {
            echo $educationErr;
        } ?></span> 
        </div>

        <div  class="singleform">
         <label>Hobbies : </label>
            <div class="checkboxClass">
            <?php
                foreach ($hobbiesData as $row): ?>
                <input type="checkbox" name="hobbies[]" value="<?php echo $row['hobby_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                <?php endforeach;
            ?>
            </div>
            <span style="color:red"><?php if (isset($hobbiesErr)) {
            echo $hobbiesErr;
        } ?></span> 
        </div>
            <button type="submit" name="adddata">Submit</button>
    
</form>

</div>
</body>
</html>
