<?php
 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "feelingsdb";
$billNo = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
if(isset($_POST['name'])){
    $sql = "INSERT INTO `salesregister` ( `billNo`, `billdate`, `customerName`, `address`, `gstNo`, `netTotal`, `cgstPercent`, `sgstPercent`, `igstPercent`, `cgstRate`, `sgstRate`,`igstRate`, `grossTotal`) VALUES ('".$_POST['billNo']."', '".$_POST['billDate']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['gstNo']."', '".$_POST['netTotal']."', '".$_POST['cgstPercent']."', '".$_POST['sgstPercent']."','".$_POST['igstPercent']."', '".$_POST['cgstAmt']."', '".$_POST['sgstAmt']."','".$_POST['igstAmt']."', '".$_POST['grossTotal']."')";
    if (mysqli_query($conn, $sql)) {
          $last_id = $conn->insert_id;
          $sqlbill = "select billNo from salesregister where id = $last_id";
          $res = mysqli_query($conn,$sqlbill);
           while($result=$res->fetch_object()){
            $billNo = $result->billNo;
           }

          for($i=1;$i<=6;$i++){
          if($_POST['item'.$i]){
            $sqlitem = "INSERT INTO `salesitemregister` (`billNo`, `itemName`, `hsnCode`, `quantity`, `rate`, `totalAmount`) VALUES ( '".$billNo."', '".$_POST['item'.$i]."', '".$_POST['hsn'.$i]."', '".$_POST['qty'.$i]."', '".$_POST['rate'.$i]."', '".$_POST['amt'.$i]."');";
            if (mysqli_query($conn, $sqlitem)) {
            echo '<script>';
            echo 'console.log("sales item'.$i.' inserted Success")';
            echo '</script>';
            }else{
            echo "Error: " . $sqlitem . "<br>" . mysqli_error($conn);
            }
          }
        }
          header('location:invoice.php?bill='.$billNo);
        }else{
           /*echo "Error: " . $sqlitem . "<br>" . mysqli_error($conn);die;*/
            if(strpos(mysqli_error($conn),"Duplicate")==false){
            echo '<script>';
            echo 'alert("Bill Number already exists")';
            echo '</script>';
            echo '<script>';
            echo 'window.history.back()';
            echo '</script>';

            }  else{
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        }
      }
       
 if(isset($_GET['del']))
{

    $id = $_GET['del'];
    
  //  $transactionType = $_GET['type'];
    $sql = "DELETE FROM salesitemregister WHERE billno=$id";
if ($conn->query($sql) === TRUE) {
            //echo "Record deleted successfully";
       $sql1 = "DELETE FROM salesregister  WHERE billNo=$id";
       if ($conn->query($sql1) === TRUE) {
            header( 'location: record.php?type='.$transactionType);
    }else{
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Error deleting 1 record: " . $conn->error;
}
$conn->close();
}
      //  
        /*header('location:index.php');*/


}
$conn->close();
?>