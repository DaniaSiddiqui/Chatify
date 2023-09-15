<?php
session_start();
include 'connection.php';
$_SESSION['register'] = false;
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$pass_hash = password_hash($password,PASSWORD_DEFAULT); 
$location = $_POST['location'];
$select = mysqli_query($con,"SELECT * FROM `signup` WHERE `user_email` = '$email' and `account_status` = 'active'");
$num_rows = mysqli_num_rows($select);
$select2 = mysqli_query($con,"SELECT * FROM `signup` WHERE `user_name` = '$name'");
$num_rows2 = mysqli_num_rows($select2);
if($num_rows > 0)
{
    echo "Dublicate Email,";
}
if($num_rows2 > 0)
{
    echo" This username already taken";
}
else {
if(isset($_FILES['image']))
{
        $image = $_FILES['image'];
        $imagename = $image['name'];
        $image_size = $image['size'];
        $extension = pathinfo($imagename, PATHINFO_EXTENSION);
        $format = array("jpeg", "jpg", "png", "gif");
        $currentDate = date('Y-m-d');
        if (in_array($extension, $format)) {
            if ($image_size <= 1000000) {
                $newname = rand() . "." . $extension;
                $folder = "images/" . $newname;
        
                if (!is_dir("images/")) {
                    mkdir("images/", 0777);
                    if (strpos($folder, ' ') !== false) {
                        $folder = str_replace(' ', '', $folder);
                    }
                  
                    $query = mysqli_query($con, "INSERT INTO `signup` (`user_name`,`user_email`,`user_password`,`user_location`,`user_image`,`user_register_date`,`account_status`) values ('$name','$email','$pass_hash','$location','$folder','$currentDate','active')");
                    if ($query) {
        
                        if(move_uploaded_file($image['tmp_name'], $folder))
                        {
                            echo " You Registered Successfully";
                            $_SESSION['register'] = true;
                        }
                        
                        else {
                            echo " Cannot Upload File";
                        }
        
                    } else {
                        echo " Cannot insert recored";
                    }
                }
                if (strpos($folder, ' ') !== false) {
                    $folder = str_replace(' ', '', $folder);
                }
                
                $query = mysqli_query($con, "INSERT INTO `signup` (`user_name`,`user_email`,`user_password`,`user_location`,`user_image`,`user_register_date`,`account_status`) values ('$name','$email','$pass_hash','$location','$folder','$currentDate','active')");
                if ($query) {
        
                    if(move_uploaded_file($image['tmp_name'], $folder))
                        {
                             echo " You Registered Successfully";
                            $_SESSION['register'] = true;
                        }
                        
                        else {
                            echo " Cannot Upload File";
                        }
                } else {
                    echo " Cannot insert recored";
                }
            }
            else {
                echo " Image should be less than 1Mb";
            }
          
        } else {
            echo " Invalid Format";
        }
    
}
else {
    echo " Please Select an Image";
}
}



