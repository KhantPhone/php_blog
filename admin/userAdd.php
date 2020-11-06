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
      
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      
      if (empty( $_POST['role'])) {
       $role = 0;
      }else{
        $role = 1;
      }
      $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
      $stmt->bindValue(':email',$email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        echo "<script>alert('User email has already existed.')</script>";
      }
      else{

      $stmt = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
      $result = $stmt->execute(
          array(':name' => $name , ':email' => $email ,':password' => $password , ':role' => $role)
        );
      if ($result) {
        echo "<script>alert('Successfully Added');window.location.href='users.php';</script>";

      }
      }

  
  }
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
                <form action="" method="post" >
                  <div class="form-group">
                     <label for="name">name</label>
                     <input type="text" class="form-control " name="name" id="name" required>
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type = "email" name="email" id="email" class="form-control" cols="10" rows="10"></input>
                  </div><div class="form-group">
                     <label for="password">Password</label>
                     <input type = "password" name="password" id="password" class="form-control" cols="10" rows="10"></input>
                  </div>

                  <input type="checkbox" name="role">
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
