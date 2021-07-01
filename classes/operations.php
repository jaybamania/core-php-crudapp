<?php
namespace Ops;
require "include/connect.php";

class GetData
{
    public $id = 0;

    public function getUserData($conn)
    {
        $userData = mysqli_query($conn, "select * from members where id='{$this->id}' ");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_array($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
    public function getAllData($conn,$offset,$noOfRecordsPerPage)
    {
        $userData = mysqli_query($conn, "select * from members LIMIT $offset, $noOfRecordsPerPage");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_all($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
    public function getAllMembers($conn)
    {
        $userData = mysqli_query($conn, "select * from members");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_all($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
    public function getEducationData($conn)
    {
        $educationData = mysqli_query($conn, "select * from education ");
        if (mysqli_num_rows($educationData) > 0) {
            $fetch_educations = mysqli_fetch_all($educationData, MYSQLI_ASSOC);
            return $fetch_educations;
        }
    }
    public function getHobbiesData($conn)
    {
        $hobbiesData = mysqli_query($conn, "select * from hobbies ");
        if (mysqli_num_rows($hobbiesData) > 0) {
            $fetch_hobbies = mysqli_fetch_all($hobbiesData, MYSQLI_ASSOC);
            return $fetch_hobbies;
        }
    }

    public function getEducationNamebyId($conn,$str)
    {
        $number  = explode(",",$str);

        $return_str="";
        for($i = 0; $i<count($number);$i++){
            $getNames = mysqli_query($conn, "select education_name from education where education_id = '$number[$i]' ");
            if (mysqli_num_rows($getNames) > 0) {
                $fetch_names = mysqli_fetch_array($getNames, MYSQLI_ASSOC);
                $return_str = $return_str.$fetch_names['education_name']."  ";
            }
        }
        return $return_str;
    }
    public function getHobbiesNamebyId($conn,$str)
    {
        // $numbers = preg_replace('/[^0-9]/', '', $str);
        
        $number = explode(",", $str);
        $return_str="";
        for($i = 0; $i<count($number);$i++){
            $getNames = mysqli_query($conn, "select hobby_name from hobbies where hobbies_id = '$number[$i]' ");
            if (mysqli_num_rows($getNames) > 0) {
                $fetch_names = mysqli_fetch_array($getNames, MYSQLI_ASSOC);
                $return_str = $return_str.$fetch_names['hobby_name']."  ";
                
            }
        }
        return $return_str;
    }

    public function getMemberEducation($conn,$member_id){
        $userData = mysqli_query($conn, "select education_id from members where id='$member_id' ");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_array($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }

    public function getMemberHobbies($conn,$member_id){
        $userData = mysqli_query($conn, "select hobbies_id from members where id='$member_id' ");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_array($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
}

class Add
{
    public $name = "";
    public $email = "";
    public $phone = "";
    public $address = "";
    public $education = "";
    public $hobbies = "";
    public $image="";
    public $created = "";

    public function insert($conn)
    {
        $insert = "insert into members(`name`, `phone`, `email`, `address`,`education_id`,`hobbies_id`,`image`) values('{$this->name}','{$this->phone}','{$this->email}','{$this->address}','{$this->education}','{$this->hobbies}','{$this->image}');";
        $runn = mysqli_query($conn, $insert);
        $hobbies_id = explode(",", $this->hobbies);
        $education_id = explode(",", $this->education);
        
        $member_info = mysqli_query($conn, "select * from members where email='{$this->email}' ");
        $fetch_member = mysqli_fetch_array($member_info, MYSQLI_ASSOC);
        $member_id = $fetch_member['id'];

        for($i = 0; $i<count($education_id);$i++){
            $insertEducation = mysqli_query($conn, "insert into member_education(`member_id`,`education_id`) values('$member_id','$education_id[$i]');");
        }
        for($i = 0; $i<count($hobbies_id);$i++){
            $insertHobbies = mysqli_query($conn, "insert into member_hobbies(`member_id`,`hobbies_id`) values('$member_id','$hobbies_id[$i]');");
        }
        if ($runn && $insertEducation && $insertHobbies) {
            $this->created = "Member {$this->name} has been Created Successfully";
            return $this->created;
        }
    }
}

class EditData
{
    public $id = 0;
    public $serial_id = 0;
    public $name = "";
    public $email = "";
    public $phone = "";
    public $address = "";
    public $education = "";
    public $hobbies = "";
    public $image = "";
    public $updated = "";

    public function update($conn)
    {
        $post_education_id = explode(",", $this->education);
        $post_hobbies_id = explode(",",$this->hobbies);
        $getData = new GetData();
        $db_hobbies = $getData->getMemberHobbies($conn, $this->id);
        $db_hobbies_id = explode(",", $db_hobbies['hobbies_id']);
        $db_education = $getData->getMemberEducation($conn, $this->id);
        $db_education_id = explode(",", $db_education['education_id']);
        // print_r($db_hobbies_id); 
        // print_r($post_hobbies_id);
        //
        $educationdiff = array_merge(array_diff($post_education_id, $db_education_id));
        $educationdiff2 = array_merge(array_diff($db_education_id, $post_education_id));
        $educationiffe3 = array_merge(array_diff($educationdiff2, $post_education_id));
        // print_r($educationdiff);
        // print_r($educationdiff2);
        // print_r($educationiffe3);
        
        $hobbiesdiff = array_merge(array_diff($post_hobbies_id, $db_hobbies_id));
        $hobbiesdiff2 = array_merge(array_diff($db_hobbies_id, $post_hobbies_id));
        $hobbiesiffe3 = array_merge(array_diff($hobbiesdiff2, $post_hobbies_id));

        $counteducation=0;
        $counthobbies=0;
        if(count($educationdiff)>count($educationiffe3)){$count = count($educationdiff);}else{
            $counteducation = count($educationiffe3);
        }
        if(count($hobbiesdiff)>count($hobbiesiffe3)){$count = count($hobbiesdiff);}else{
            $counthobbies = count($hobbiesiffe3);
        }
        // echo $counteducation;
        for($i = 0; $i<$counteducation;$i++){
            if(isset($educationdiff[$i])){
                if(strpos($db_education['education_id'],$educationdiff[$i] ) == false){
                    $updateEducation = mysqli_query($conn, "insert into member_education (`member_id`,`education_id`) values('$this->id','$educationdiff[$i]');");
                      echo "Insert : ".$educationdiff[$i];
                 }
            }
            if(isset($educationiffe3[$i])){
                if(strpos($this->education,$educationiffe3[$i] ) == false){
                    $deleteEducation = mysqli_query($conn,"delete from member_education  where education_id = '$educationiffe3[$i]';");
                     echo "Delete : ".$educationiffe3[$i];
                }
            }
            
        }
        for($i = 0; $i<$counthobbies;$i++){
            if(isset($hobbiesdiff[$i])){
                if(strpos($db_hobbies['hobbies_id'],$hobbiesdiff[$i] ) == false){
                     $updateHobbies = mysqli_query($conn, "insert into member_hobbies(`member_id`,`hobbies_id`) values('$this->id','$hobbiesdiff[$i]');");
                      echo "Insert : ".$hobbiesdiff[$i];
                 }
            }
            if(isset($hobbiesiffe3[$i])){
                if(strpos($this->hobbies,$hobbiesiffe3[$i] ) == false){
                     $deleteHobbies = mysqli_query($conn,"delete from member_hobbies where hobbies_id = '$hobbiesiffe3[$i]';");
                     echo "Delete : ".$hobbiesiffe3[$i];
                }
            }
            
        }
        $update_query = "update members set name = '{$this->name}', phone = '{$this->phone}',email = '{$this->email}', address = '{$this->address}', education_id='{$this->education}' ,hobbies_id='{$this->hobbies}', image='{$this->image}' where id = '{$this->id}';";
        $runn = mysqli_query($conn, $update_query);
        
        if ($runn) {
            $this->updated = "Member  {$this->name} has been Updated Successfully";
            return $this->updated;
        }
        // for($i = 0; $i<count($db_hobbies_id);$i++){

        // }
        // //db_hobbies2 = 5,8,9,4,6
        // $db_hobbies2 = $getData->getMemberHobbies($conn, $this->id);
        // $db_hobbies_id2 = explode(",", $db_hobbies2['hobbies_id']);
        // for($i = 0; $i<count($db_hobbies_id2);$i++){
        //     if(strpos($db_hobbies['hobbies_id'],$diffrence[$i] ) !== false){
        //         // $updateDetails = mysqli_query($conn, "insert into member_hobbies(`member_id`,`hobbies_id`) values('$this->id','$hobbies_id[$i]');");
        //         echo "Insert : ".$diffrence[$i];
        //     }
        // }
        ;
        // $delete = "delete from member_details where member_id = '{$this->id}';";
        // $delete_query = mysqli_query($conn, $delete);
        
        
        // $count = 0;
        // if (count($education_id)>count($hobbies_id)){ $count = count($education);}else{ $count = count($hobbies_id); }
        // for($i = 0; $i<$count;$i++){
        //     $updateDetails = mysqli_query($conn, "insert into member_details(`member_id`,`education_id`,`hobbies_id`) values('$this->id','$education_id[$i]','$hobbies_id[$i]');");
        // }
        
    }
}


class CheckEmail
{
    public $email = "";
    public $emailError = "";
    public $id = "";

    public function getEmailId($conn)
    {
        $userData = mysqli_query($conn, "select * from members where id='{$this->id}' ");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_array($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }

    public function checkEmail($conn)
    {
        $duplicate = mysqli_query($conn, "select * from members where email='{$this->email}' ");
        if (mysqli_num_rows($duplicate) > 0) {
            $emailError = "<p style='color:red;'> This email is already registered</p>";
            return $emailError;
        }
    }
    public function checkEmailWhileUpdate($conn)
    {
      $getemail = $this->getEmailId($conn);
      if($this->email == $getemail['email']){
        return true;
      }else{
      $getemail = $this->checkEmail($conn);
      if(!$getemail){
        return true;
      }else{
        return false;
      }
      }
    }
}

class Validations
{
    public $name = "";
    public $email = "";
    public $phone = "";
    public $address = "";
    public $education = "";
    public $hobbies = "";
    public $image = "";

    public $nameErr = "";
    public $emailErr = "";
    public $phoneErr = "";
    public $addressErr = "";
    public $educationErr = "";
    public $hobbiesErr = "";
    public $imageErr = "";

    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validate_name()
    {
        if (empty($this->name)) {
            $this->nameErr = " Name is Required";
            return $this->nameErr;
        }
    }
    public function validate_email()
    {
        if (empty($this->email)) {
            $this->emailErr = " Email is Required";
            return $this->emailErr;
        } else {
            $this->email = $this->test_input($_POST["email"]);

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = " Invalid Email Format";
                return $this->emailErr;
            }
        }
    }
    public function validate_phone()
    {
        if (empty($this->phone)) {
            $this->phoneErr = "<p style='color:red;'> Phone No. is Required</p>";
            return $this->phoneErr;
        }
    }

    public function validate_address()
    {
        if (empty($this->address)) {
            $this->addressErr = "<p style='color:red;'> Address is Required</p>";
            echo $this->addressErr;
            return $this->addressErr;
        }
    }

    public function validate_education()
    {
        if (empty($this->education)) {
            // echo "Hello" . $this->education;
            $this->educationErr = "<p style='color:red;'> Alteast you must Qualify SSC </p>";
            return $this->educationErr;
        }
    }

    public function validate_hobbies()
    {
        if (empty($this->hobbies)) {
            $this->hobbiesErr = "<p style='color:red;'> Enter atleast one Hobby</p>";
            return $this->hobbiesErr;
        }
    }

    public function validate_image()
    {
        if (empty($this->image)) {
            $this->imageErr = "<p style='color:red;'> Upload Image</p>";
            return $this->imageErr;
        }
    }
}

class DeleteData
{
    public $id = 0;
    public $serial_id = 0;

    public function delete($conn)
    {
        $delete = "delete from members where id = '{$this->id}';";
        $runn_query1 = mysqli_query($conn, $delete);
        $delete_education = "delete from member_education where member_id = '{$this->id}';";
        $delete_hobbies = "delete from member_hobbies where member_id = '{$this->id}';";
        $runn_education = mysqli_query($conn, $delete_education);
        $runn_hobbies = mysqli_query($conn, $delete_hobbies);
        if ($runn_query1 && $runn_education && $runn_hobbies) {
            $this->deleted = "Member  {$this->serial_id} has been Deleted Successfully";
            return $this->deleted;
        }
    }
}

class SearchData
{
    public $string = "";
    public $field_name = "name";

    public function search($conn, $offset, $noOfRecordsPerPage)
    {
        $search_query = mysqli_query($conn, "select * from members where $this->field_name like '%$this->string%' LIMIT $offset, $noOfRecordsPerPage");
        if (mysqli_num_rows($search_query) > 0) {
            $fetch_users = mysqli_fetch_all($search_query, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
}

class UploadImage{


    public function uploadimage($ImageName, $imgType, $output_dir){
        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt = str_replace('.','',$ImageExt);
        $RandomNum   = time();
        $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
        $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
        $ret[$NewImageName]= $output_dir.$NewImageName;
        
        /* Try to create the directory if it does not exist */
        if (!file_exists($output_dir))
        {
            @mkdir($output_dir, 0777);
        }               
        $upload = move_uploaded_file($_FILES["image"]["tmp_name"][0],$output_dir."/".$NewImageName );
        if($upload){
            return $NewImageName;
        }else{
            return 0;
        }
    }
}
?>
