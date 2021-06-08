<?php
namespace Ops;
require("include/connect.php");

class GetData{

  public $id = 0;

  public function getUserData($conn) {
    $userData = mysqli_query($conn,"select * from members where id='{$this->id}' ");
    if (mysqli_num_rows($userData)>0)
     {   
       $fetch_users = mysqli_fetch_array($userData, MYSQLI_ASSOC);
       return $fetch_users;
     }
 }
 public function getAllData($conn) {
  $userData = mysqli_query($conn,"select * from members ");
  if (mysqli_num_rows($userData)>0)
   {   
     $fetch_users = mysqli_fetch_all($userData, MYSQLI_ASSOC);
     return $fetch_users;
   }
}
}

class Add {

    public $name = "";
    public $email = "";
    public $phone = "";
    public $address = "";
    public $created = "";


  public function insert($conn) {
    // echo "<p>Table '{$this->title}' has {$this->numRows} rows.</p>";
    $insert="insert into members(`name`, `phone`, `email`, `address`) values('{$this->name}','{$this->phone}','{$this->email}','{$this->address}');";
    $runn=mysqli_query($conn, $insert);
    if($runn){
        $this->created = "Member {$this->name} has been Created Successfully";
        return $this->created;
    }
  }
}

class CheckEmail {

    public $email = "";
    public $emailError = "";

    public function checkEmail($conn) {
       $duplicate = mysqli_query($conn,"select * from members where email='{$this->email}' ");
       if (mysqli_num_rows($duplicate)>0)
        {
            $emailError = "<p style='color:red;'> This email is already registered</p>";
            return $emailError;
        }

    }
 }

 class Validations {
    
        public $name = "";
        public $email = "";
        public $phone = "";
        public $address = "";

        public $nameErr = "";
        public $emailErr = "";
        public $phoneErr = "";
        public $addressErr = "";

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    
      public function validate_name() {
        if (empty($this->name)) {
            $this->nameErr = "<p style='color:red;'> Name is Required</p>";
            return $this->nameErr;
          } 
      }
      public function validate_email(){
          if (empty($this->email)) {
            $this->emailErr = "<p style='color:red;'> Email is Required</p>";
            return $this->emailErr;
          } else {
            $this->email = $this->test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "<p style='color:red;'> Invalid Email Format</p>";
                return $this->emailErr;
            }
          }
        }  
        public function validate_phone(){
          if (empty($this->phone)) {
            echo "Hello".$this->phone;
            $this->phoneErr = "<p style='color:red;'> Phone No. is Required</p>";
            return $this->phoneErr;
          } 
      }

        public function validate_address(){
          if (empty($this->address)) {

            $this->addressErr = "<p style='color:red;'> Address is Required</p>";
            echo $this->addressErr;
            return $this->addressErr;
          } 
        }
    }

    class EditData {

      public $id = 0;
      public $serial_id = 0;
      public $name = "";
      public $email = "";
      public $phone = "";
      public $address = "";
      public $updated = "";
  
    public function update($conn) {
      $update_query="update members set name = '{$this->name}', phone = '{$this->phone}',email = '{$this->email}', address = '{$this->address}' where id = '{$this->id}';";
      $runn=mysqli_query($conn, $update_query);
      if($runn){
          $this->updated = "Member {$this->serial_id} {$this->name} has been Updated Successfully";
          return $this->updated;
      }
    }
      
   }

   class DeleteData {

        public $id = 0;
        public $serial_id = 0;
        public $email = "";
        public $phone = "";
        public $address = "";
        public $deleted = "";
    
    
      public function delete($conn) {
        // echo "<p>Table '{$this->title}' has {$this->numRows} rows.</p>";
        $delete="delete from members where id = '{$this->id}';";
        $runn=mysqli_query($conn, $delete);
        if($runn){
            $this->deleted = "Member  {$this->serial_id} has been Deleted Successfully";
            return $this->deleted;
        }
      }
    }

class Row {
  public $numCells = 0;
  public function message() {
    echo "<p>The row has {$this->numCells} cells.</p>";
  }
}
?>