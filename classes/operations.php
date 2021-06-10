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
    public function getAllData($conn)
    {
        $userData = mysqli_query($conn, "select * from members ");
        if (mysqli_num_rows($userData) > 0) {
            $fetch_users = mysqli_fetch_all($userData, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
    public function getEducationData($conn)
    {
        $educationData = mysqli_query($conn, "select * from member_education ");
        if (mysqli_num_rows($educationData) > 0) {
            $fetch_educations = mysqli_fetch_all($educationData, MYSQLI_ASSOC);
            return $fetch_educations;
        }
    }
    public function getHobbiesData($conn)
    {
        $hobbiesData = mysqli_query($conn, "select * from member_hobbies ");
        if (mysqli_num_rows($hobbiesData) > 0) {
            $fetch_hobbies = mysqli_fetch_all($hobbiesData, MYSQLI_ASSOC);
            return $fetch_hobbies;
        }
    }

    public function getEducationNamebyId($conn,$str)
    {
        
        // preg_match_all('!\d+!', $str, $matches);
        // print_r($matches);
        // $int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);  
        // echo("The extracted numbers are: $int \n");
        $numbers = preg_replace('/[^0-9]/', '', $str);
        $return_str="";
        // $educationData = mysqli_query($conn, "select education_name from member_education where education_id = '$numbers[0]' ");
        // if (mysqli_num_rows($educationData) > 0) {
        //     $fetch_hobbies = mysqli_fetch_array($educationData, MYSQLI_ASSOC);
        //     return $fetch_hobbies['education_name'];
        // }
        for($i = 0; $i<strlen($numbers);$i++){
            $getNames = mysqli_query($conn, "select education_name from member_education where education_id = '$numbers[$i]' ");
            if (mysqli_num_rows($getNames) > 0) {
                $fetch_names = mysqli_fetch_array($getNames, MYSQLI_ASSOC);
                $return_str = $return_str.$fetch_names['education_name']."  ";
            }
        }
        return $return_str;
    }
    public function getHobbiesNamebyId($conn,$str)
    {
        $numbers = preg_replace('/[^0-9]/', '', $str);
        $return_str="";
        for($i = 0; $i<strlen($numbers);$i++){
            $getNames = mysqli_query($conn, "select hobby_name from member_hobbies where hobby_id = '$numbers[$i]' ");
            if (mysqli_num_rows($getNames) > 0) {
                $fetch_names = mysqli_fetch_array($getNames, MYSQLI_ASSOC);
                $return_str = $return_str.$fetch_names['hobby_name']."  ";
                
            }
        }
        return $return_str;
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
    public $created = "";

    public function insert($conn)
    {
        $insert = "insert into members(`name`, `phone`, `email`, `address`,`education_id`,`hobbies_id`) values('{$this->name}','{$this->phone}','{$this->email}','{$this->address}','{$this->education}','{$this->hobbies}');";
        $runn = mysqli_query($conn, $insert);
        if ($runn) {
            $this->created = "Member {$this->name} has been Created Successfully";
            return $this->created;
        }
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

    public $nameErr = "";
    public $emailErr = "";
    public $phoneErr = "";
    public $addressErr = "";
    public $educationErr = "";
    public $hobbiesErr = "";

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
            $this->nameErr = "<p style='color:red;'> Name is Required</p>";
            return $this->nameErr;
        }
    }
    public function validate_email()
    {
        if (empty($this->email)) {
            $this->emailErr = "<p style='color:red;'> Email is Required</p>";
            return $this->emailErr;
        } else {
            $this->email = $this->test_input($_POST["email"]);

            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "<p style='color:red;'> Invalid Email Format</p>";
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
            // echo "Hello" . $this->hobbies;
            $this->hobbiesErr = "<p style='color:red;'> Enter atleast one Hobby</p>";
            return $this->hobbiesErr;
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
    public $updated = "";

    public function update($conn)
    {
        $update_query = "update members set name = '{$this->name}', phone = '{$this->phone}',email = '{$this->email}', address = '{$this->address}' where id = '{$this->id}';";
        $runn = mysqli_query($conn, $update_query);
        if ($runn) {
            $this->updated = "Member {$this->serial_id} {$this->name} has been Updated Successfully";
            return $this->updated;
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
        $runn = mysqli_query($conn, $delete);
        if ($runn) {
            $this->deleted = "Member  {$this->serial_id} has been Deleted Successfully";
            return $this->deleted;
        }
    }
}

class SearchData
{
    public $string = "";

    public function search($conn)
    {
        $search_query = mysqli_query($conn, "select * from members where name like '%$this->string%'");
        if (mysqli_num_rows($search_query) > 0) {
            $fetch_users = mysqli_fetch_all($search_query, MYSQLI_ASSOC);
            return $fetch_users;
        }
    }
}
?>
