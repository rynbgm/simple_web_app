<?php 
session_start();
include("../connection.php");
include("../function.php");
check_login();
$query="SELECT book.BookId, Title, BORROWDATE, RETURNDATE FROM BOOK, RECORD WHERE USERID='$_SESSION[ID]' AND book.BookId=record.BOOKID";
$result=mysqli_query($con,$query);



if(isset($_GET['bookid'])){
    $bookid = $_GET['bookid'];
    $returnbook = "DELETE FROM RECORD WHERE BOOKID = '$bookid'";
    $update = "UPDATE BOOK SET Availability= Availability +1 WHERE BOOKID = $bookid";
    $con->query($returnbook);
    $con->query($update);
    echo "<script>window.location = 'borrowedbooks.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/acceuil.css"/>
    <title>Document</title>
</head>
<body>
<div class="add"><a href="acceuil.php"><button>Go Back</button></a></div>
    <table>
        <tr><th>Title</th>
            <th>Borrowed Date</th>
            <th>Return Date</th>
            <th>Action</th>
        </tr>
        
        <?php if(mysqli_num_rows($result)> 0){ ?>
            <?php foreach($result as $row){ ?>
              <?php if(date("Y - M - D") > $row["RETURNDATE"]){
                $message = "<p style='color:red'>The due date has passed</p>";
              }else{
                $message = "<p style='color:green'>The  date has not passed</p>";
              }?>
                <form method="post" action="borrowedbooks.php?action=remove&id=<?php echo $row["BookId"];?>"><tr>
                <td><?= $row['Title'];?></td>
                <td><?= $row['BORROWDATE'];?></td>
                <td><?= $row['RETURNDATE'];?><?php echo $message; ?></td>
                <td><a href="borrowedbooks.php?bookid=<?php echo $row['BookId'];?>" class= "return">Return</a></td>
            </tr></form>
            <?php } ?>
            <?php }else{ ?>
                <tr ><td colspan=4>No borrowed books</td></tr>
           <?php } ?>
    </table>
</body>
</html>