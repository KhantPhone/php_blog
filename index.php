<?php 
  session_start();
  require_once 'config/config.php';
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ) {
   header('Location:login.php');
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
  <!-- Google Font: Source <SAMP></SAMP>ns Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
   <style>
     @media screen and (max-width: 768px){
      .card-body img{
        display: flex;
        justify-content: center;
      }
     }
   </style>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  

  
  <div class="content-wrapper" style="margin-left: 0  !important">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="text-center text-uppercase font-weight-bold">Blogs Site</h1>
       
      </div><!-- /.container-fluid -->
    </section>
    <?php 
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();

     ?>
     <div class="row">
      
      <?php 
           foreach ($result as $value) {
             ?>
             <div class="col-md-4">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
                <h2 class="text-center">
                    <?php 
                        echo $value['title'];
                     ?>
                </h2>
                <!-- /.user-block -->
                
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <a href="blogdetail.php?id= <?php echo $value['id']; ?>">
                  <img class="img-fluid" src="admin/images/<?php echo $value['image']; ?>" alt="Photo" style= "height: 45vh;">
                </a>

                <p>I took this photo this morning. What do you guys think?</p>
                
                <span class="float-right text-muted">127 likes - 3 comments</span>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
          </div>
             <?php
           }
       ?>
          
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
