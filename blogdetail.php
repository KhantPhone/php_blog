<?php 
  session_start();
  require_once 'config/config.php';
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ) {
   header('Location:login.php');
  } 
  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = " . $_GET['id']); 
  $stmt->execute();
  $result = $stmt->fetchAll();

  $blog_id = $_GET['id'];
  $stmtcm = $pdo->prepare("SELECT * FROM comments WHERE post_id = $blog_id"); 
  $stmtcm->execute();
  $resultcm = $stmtcm->fetchAll();

  $blog_id = $_GET['id'];
  $stmtall = $pdo->prepare("SELECT * FROM comments INNER JOIN users on comments.author_id = users.id WHERE post_id = $blog_id ORDER BY comments.created_at DESC"); 
  $stmtall->execute();
  $resultall = $stmtall->fetchAll();
 



  $blog_id = $_GET['id'];
  $stmtcount = $pdo->prepare("SELECT content FROM comments WHERE post_id = $blog_id"); 
  $stmtcount->execute();
  $resultcount = $stmtcount->fetchAll();
  

  $author_id = $_SESSION['user_id'];
  $stmtau = $pdo->prepare("SELECT * FROM users WHERE id= $author_id"); 
  $stmtau->execute();
  $resultau = $stmtau->fetchAll();


  if ($_POST) {
     $content= $_POST['comment'];  
     $blog_id = $_GET['id'];
     $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id)");
     $result = $stmt->execute(
          array(':content' => $content , ':author_id' => $_SESSION['user_id'], ':post_id' => $blog_id)
        );



      if ($result) { 
        header('Location:blogdetail.php?id=' . $blog_id);

      }  

  }

 ?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  

  
  <div class="">
    <!-- Content Header (Page header) -->
    
     <div class="row">
          <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <h2 class="text-center">
                   <?php 
                      echo $result[0]['title'];
                    ?>
                </h2>
                <!-- /.user-block -->
                
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <img src="admin/images/<?php echo $result[0]['image'] ?>" alt="" class=" img-fluid w-100">

              <p>
                <?php echo $result[0]['content'] ?>
              </p>
               <h3 class="border-bottom pb-2">Comments</h3>  
               <a href="index.php" class="btn btn-outline-danger mt-2">Go Back</a> 
                
                
                <span class="float-right text-muted font-weight-bold"><?php echo count($resultcount) ?> comments</span>
              </div>
              <!-- /.card-body -->
              <?php 
                if ($resultcm) {
                  foreach ($resultall as $value) {
                    # code...
                  
                  ?>
                  <div class="row ml-3">
                    <div class="footer">
                  <p class="font-weight-bold text-uppercase">
                    <?php echo $value['name']; ?><span class="text-muted">
                      (<?php echo date('Y-M-D',strtotime($value['created_at'])); ?>)
                    </span>
                  </p>               
                  <p class="text-muted">
                   <?php 
                      echo $value['content'];
                    ?>
                  </p>
                    </div>
                  </div>
              <?php
                } }
               ?>
              
              <!-- /.card-footer -->
              <div class="card-footer">
                <form action="" method="post">
                  
                  <!-- .img-push is used to add margin to elements next to floating images -->
                  <div class="img-push">
                    <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                  </div>
                </form>
              </div>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
          </div>

          
        </div>
    

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer d-flex justify-content-end ">
   
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
