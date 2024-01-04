<?php
require_once 'configs/connection.php';
session_start();

if (!isset($_SESSION['authname']) && !isset($_SESSION['authname1']) && !isset($_SESSION['authname2'])) {
    header("Location: index.html");
}else{
  $filter = $_SESSION['authname'];
$sql = "SELECT * FROM `users` WHERE `userId` = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$filter]);
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Web Project Assignment - Author Homepage</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-digimedia-v1.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">

  </head>

              <script type="text/javascript">
function printData()
{
   var divToPrint=document.getElementById("printTable");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('button').on('click',function(){
printData();
})  
</script>

        <style type="text/css">
        
          table{
    align-items: center;
    color: black;
  }

   th, tr, td{
    padding: 10px 10px;
  }

  label{
    color: white;
  }
  input{
    margin-bottom: 20px;
    width: 100%;
  }
   textarea{
    margin-top: 10px;
    margin-bottom: 20px;
    width: 100%;
  }
    </style>
<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
              <img src="assets/images/logo.png" style="width: 300px;" alt="">
            </a>
            <!-- ***** Logo End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                  <div class="col-lg-12">
                    <h6>Welcome <?php echo $row1['UserType']; ?>,</h6>
                    <h2><?php echo $row1['Full_Name']; ?>!</h2>
                    <br>
                  </div>
                  <div class="col-lg-12">
                    <div class="border-first-button scroll-to-section">
                      <a href="functions/logout.php">Logout</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                <img src="assets/images/bg.png" style="width: 400px;" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="contact" class="contact-us section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h6>Database</h6>
            <h4>My Profile</h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
           <table>
<tr style="text-align: left;
  padding: 8px;">
<th style="text-align: left;
  padding: 8px;">#</th>
<th style="text-align: left;
  padding: 8px;">Fullname</th>
<th style="text-align: left;
  padding: 8px;">Username</th>  
  <th style="text-align: left;
  padding: 8px;">Email Address</th>
 <th style="text-align: left;
  padding: 8px;">Phone Number</th>
 <th style="text-align: left;
  padding: 8px;">Gender</th> 
 <th style="text-align: left;
  padding: 8px;">Address</th> 
 <th style="text-align: left;
  padding: 8px;">Access Time</th> 
 <th style="text-align: left;
  padding: 8px;">Image</th>      
  <th style="text-align: left;
  padding: 8px;">User Type</th>
   <th style="text-align: left; padding: 8px;"></th>
</tr>

<?php
$sql = "SELECT `userId`, `Full_Name`, `User_Name`, `phone_Number`, `email`, `Gender`, `AccessTime`, `UserType`, `Address`, `profile_Image` FROM `users` WHERE `userId` =:filter";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':filter', $filter, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><?php echo($row["userId"]); ?></td>
<td><?php echo($row["Full_Name"]); ?></td>
<td><?php echo($row["User_Name"]); ?></td>
<td><?php echo($row["email"]); ?></td>
<td><?php echo($row["phone_Number"]); ?></td>
<td><?php echo($row["Gender"]); ?></td>
<td><?php echo($row["Address"]); ?></td>
<td><?php echo($row["AccessTime"]); ?></td>
<td><img style="width: 50px;" src="assets/images/<?php echo($row["profile_Image"]); ?>" title="<?php echo($row["Full_Name"]); ?>"></td>
<td><?php echo($row["UserType"]); ?></td>
</tr>
<?php
}
} else { echo "No results"; }

?>

</table>
        </div>
      </div>
    </div>
    <br>
        <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h4>List of Articles</h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
          <table id="printTable">
<tr style="text-align: left;
  padding: 8px;">
<th style="text-align: left;
  padding: 8px;">#</th>
<th style="text-align: left;
  padding: 8px;">Author ID</th>
  <th style="text-align: left;
  padding: 8px;">Title</th>
 <th style="text-align: left;
  padding: 8px;">Order</th>
  <th style="text-align: left;
  padding: 8px;">Display</th> 
  <th style="text-align: left;
  padding: 8px;">Created At</th>
    <th style="text-align: left;
  padding: 8px;">Last Updated At</th>
<th style="text-align: left; padding: 8px;"></th>
</tr>

<?php
$sql = "SELECT `article_id`, `authorId`, `article_title`, `article_full_text`, `article_display`, `article_order`, `article_created_date`, `article_last_update` FROM `articles`";
$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
<tr>
<td><?php echo($row["article_id"]); ?></td>
<td><?php echo($row["authorId"]); ?></td>
<td><?php echo($row["article_title"]); ?></td>
<td><?php echo($row["article_order"]); ?></td>
<td><?php echo($row["article_display"]); ?></td>
<td><?php echo($row["article_created_date"]); ?></td>
<td><?php echo($row["article_last_update"]); ?></td>
<td><button class="btn btn-primary py-3 px-5" onclick="return confirm('Are you sure that you want to delete this article?')?window.location.href='functions/main.php?action=deleteA&id=<?php echo($row["article_id"]); ?>':true;" title='Delete Article'>Delete</button></td>
<br>
<br>
</tr>
<?php
} 
?>

</table>       
<br>
<br>
                      <fieldset>
                        <button type="submit" id="form-submit" class="main-button " onclick="printData();">Print</button>
                      </fieldset>
        </div>
      </div>
    </div>
    <br>
        <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h6>My Module</h6>
            <h4>Update My Details</h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
          <form action="functions/main.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input name="fname" type="text" class="form-control" placeholder="Fullname" value="<?php echo $row1['Full_Name']; ?>" required>
                                        <input type="hidden" value="<?php echo $filter; ?>" name="uid" required>
                                        <input type="hidden" value="3" name="mod" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="uname" type="text" class="form-control" placeholder="Username" value="<?php echo $row1['User_Name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="phone" type="text" class="form-control" value="<?php echo $row1['phone_Number']; ?>" placeholder="Phone Number" required>
                                    </div>

                                    <div class="form-group">
                                        <input name="email" type="email" class="form-control" value="<?php echo $row1['email']; ?>" placeholder="Email Address" required>
                                    </div>                      
                                     <div class="form-group">
                                        <input name="address" type="text" value="<?php echo $row1['Address']; ?>" class="form-control" placeholder="Address" required>
                                    </div>
                                    <div class="form-group">
                            <select class="form-control" name="gender" required>
                              <option disabled value="" selected>Select A Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                           </select>  
                                    </div>
                                    <div class="form-group">
                                        <label>Profile Picture:</label>
                                        <br>
                                     <input name="image" type="file" accept=".jpg, .png, .jpeg" class="form-control" required>   
                                    </div>
                                    <div class="form-group">
                                        <input name="password" type="password" minlength="8" class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input name="cpassword" type="password" minlength="8" class="form-control" placeholder="Confirm Password" required>
                                    </div>                                                          
                                    <div class="form-group text-right">
                                        <input type="submit" name="upu" class="btn btn-primary" value="Update">
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </form>
        </div>
      </div>
    </div>
    <br>
        <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h4>Add An Article</h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
<form action="functions/main.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input name="atitle" type="text" class="form-control" placeholder="Article Title" required>
                                    </div>
                                    <div class="form-group">
                                <input name="aorder" type="text" class="form-control" placeholder="Article Order" required>
                                    </div>                                           <div class="form-group">
                            <select class="form-control" name="adisplay" required>
                              <option disabled value="" selected>Select A Display</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                           </select>  
                                    </div>                      
                                    <div class="form-group">
                                        <textarea name="aftext" class="textarea form-control" placeholder="Article Full Text..." required></textarea>
                                    </div>                       
                                    <div class="form-group text-right">
                                        <input type="submit" name="addarticle" class="btn btn-primary" value="Add Article">
                                    </div>
                                </form>
        </div>
      </div>
    </div>
    <br>
            <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
            <h4>Update An Article</h4>
            <div class="line-dec"></div>
          </div>
        </div>
        <div class="col-lg-12 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.25s">
                                <form action="functions/main.php" method="POST" enctype="multipart/form-data">
                            <div>
                            <select class="form-control" name="gender" required>
                              <option disabled value="" selected>Select An Article</option>
                                     <?php
$sql = "SELECT * FROM `articles` WHERE `authorId` = :filter";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':filter', $filter, PDO::PARAM_INT);
$stmt->execute();

while ($category = $stmt->fetch(PDO::FETCH_ASSOC)):
?>
                                  <option value="<?php echo $category["article_id"];?>"><?php echo $category["article_title"];?></option>
                                  <?php
                                      endwhile;
                                  ?>
                           </select>  
                                    </div>
                                    <div class="form-group">
                                        <input name="atitle" type="text" class="form-control" placeholder="Article Title" required>
                                    </div>
                                    <div class="form-group">
                                <input name="aorder" type="text" class="form-control" placeholder="Article Order" required>
                                    </div> 
                       <div class="form-group">
                            <select class="form-control" name="adisplay" required>
                              <option disabled value="" selected>Select A Display</option>
                              <option value="Yes">Yes</option>
                              <option value="No">No</option>
                           </select>  
                                    </div>                    
                                    <div class="form-group">
                                        <textarea name="aftext" class="textarea form-control" placeholder="Article Full Text..." required></textarea>
                                    </div>                         
                                    <div class="form-group text-right">
                                        <input type="submit" name="updatearticle" class="btn btn-primary" value="Update Article">
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </form>
        </div>
      </div>
    </div>
    <br>
  </div>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <p>Copyright © 2023.</p>
        </div>
      </div>
    </div>
  </footer>


  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/custom.js"></script>

</body>
</html>