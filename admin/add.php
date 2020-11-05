<?php 
  require_once '../config/config.php';
  session_start();
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location:login.php');
  }
  if ($_POST) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);
 
  if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
      echo "<script>alert('Invalid Image Format')</script>";
  }
  else{
      $title = $_POST['title'];
      $content = $_POST['content'];
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], $file);

      $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES(:title,:content,:author_id,:image)");
      $result = $stmt->execute(
          array(':title' => $title , ':content' => $content , ':image' => $image , ':author_id'=> $_SESSION['user_id'])
        );
      if ($result) {
        echo "<script>alert('Successfully Added');window.location.href='index.php';</script>";

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
                <form action="add.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control " name="title" id="title" required>
                  </div>
                  <div class="form-group">
                     <label for="content">Content</label>
                     <textarea name="content" id="content" class="form-control" cols="30" rows="10"></textarea>
                  </div>
                  <div class="form-group">
                     <div class="row ml-auto">
                       <label for="file">Image</label>
                     </div>
                     <input type="file" name="image" id="file" required>
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