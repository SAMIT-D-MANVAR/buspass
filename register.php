
<!------------------------------ BUS FORM VALIDATION -------------------------------->

<?php 
//first check if emalid is already present in student table to verify if he has a bus pass
//if he does have a bus pass display that he does else display Successfully Booked Bus Pass 
session_start();

$email=$_POST['email_id'];



$conn=mysqli_connect('localhost','root','') or die(mysqli_error($conn));

$select_db=mysqli_select_db($conn,'bus_booking') or die(mysqli_error($conn));


$sql="SELECT * FROM student WHERE email_id='$email' ";

$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
 
    if($result==true)
      {

        $rowcount=mysqli_num_rows($result);

        if($rowcount!=0)
        {

         
                    echo ("<script LANGUAGE='JavaScript'>

                    window.alert('You already have a bus pass!');
                   
                    </script>");

                
        }


        else 
        {
           


      $starting_location=$_POST['starting_location'];
      echo $starting_location;

        /* Check if buses with specific starting locations are available */
        $sql1="SELECT bus_id
        FROM bus_details
        WHERE total_strength<60 AND bus_id in 
                     (SELECT bus_id 
                     FROM bus_routes
                      where starting_location='$starting_location') 

        LIMIT 1";
        /* End of query */
  

        $result1=mysqli_query($conn,$sql1) or die(mysqli_error($conn));
                $rows=mysqli_fetch_assoc($result1);


                      $bus_id=$rows['bus_id'];
                       echo "$bus_id";

         
            if($result1==true)
              {
                $rowcount1=mysqli_num_rows($result1);

            //if no buses are available with that starting location
            if($rowcount1==0)
              {
                   echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Buses with this starting location is full !');
                   window.location.href='studentportal.php';
                    </script>");
              }
              else {
                /*
                $rows=mysqli_fetch_assoc($result1);


                      $bus_id=$rows['bus_id'];*/
                      $usn=$_POST['usn']; 
                      $name=$_POST['name']; 
                       $dob=$_POST['dob'];
                      $year=$_POST['year'];
                      $branch=$_POST['branch'];
                      $address=$_POST['address'];
                      $mobile_no=$_POST['mobile_no'];           
                      $email_id=$_POST['email_id'];
                      $gender=$_POST['gender'];
                      $date=date('Y-m-d');



                      $sql2="SELECT total_strength FROM bus_details WHERE bus_id='$bus_id' ";
                      $result2=mysqli_query($conn,$sql2) or die(mysqli_error($conn));

                      //$total;
                      //if($result2==true)
                      //{
                        $rows=mysqli_fetch_assoc($result2);
                        $total=$rows['total_strength']+1;
                        echo $total;
                      //}


                      $sql3="UPDATE bus_details set total_strength='$total' WHERE bus_id='$bus_id' ";
                       $result3=mysqli_query($conn,$sql3) or die(mysqli_error($conn));
                       

                      $sql4="INSERT INTO student values ('$usn','$name','$dob','$year','$branch','$address','$mobile_no','$starting_location','$email_id',
                      '$gender')";
                       $result4=mysqli_query($conn,$sql4) or die(mysqli_error($conn));



                      $sql5="INSERT INTO booking_details values ('$bus_id','$total','$usn','$date','$email_id','$starting_location') ";
                      $result5=mysqli_query($conn,$sql5) or die(mysqli_error($conn));
                      


          echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Successfully Booked Bus Pass !');
                   window.location.href='studentportal.php';
                    </script>");
                }
        }
      
}
}

?>

<!-------------------------Ennd of Bus form validation -------------------------------->