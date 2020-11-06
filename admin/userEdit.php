<?php 
  require_once '../config/config.php';
  session_start();
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location:login.php');
  }
  if ($_SESSION['role'] == 1) {
   
    header('Location:login.php');
  }
  if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
  
    if (empty($_POST['role'])) {
        $role = 0;
    }else{
       $role= 1;
    }

      $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
     
      $stmt->execute(
                    array(':email'=>$email,':id'=>$id)
      );
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user)  {
        echo "<script>alert('User email has already existed.')</script>";
      }
      else{

      $stmt = $pdo->prepare("UPDATE  users SET name= '$name' , email = '$email' , role ='$role' WHERE id = '$id'");
      $result = $stmt->execute();

      
      if ($result) {
        echo "<script>alert('Successfully Updated');window.location.href='users.php';</script>";

      }
      }

  

  } 

  $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ".$_GET['id']);
  $stmt->execute();
  $result = $stmt->fetchAll();
  

 ?>
 <?php 
     require_once 'header.php';
  ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                     <label for="name">Name</label>
                     <input type="text" class="form-control " name="name" id="name" value="<?php echo $result[0]['name']; ?>">
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="text" name="email" id="email" class="form-control" cols="30" rows="10" value="<?php echo $result[0]['email']?>">
                       
                     </input>
                  </div><div class="form-group">
                     <label for="role" class="d-block">Role</label>
                     <input type="checkbox" name="role" id="role">
                       
                     </input>
                  </div>
                  
                  <div class="form-group d-flex justify-content-end">
                    <input type="submit" value="SUBMIT" class="btn btn-success mr-3">
                    <a href="index.php" class="btn btn-danger">Back</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php 
     require_once 'footer.html';
   ?>
