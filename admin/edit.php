<?php 
  require_once '../config/config.php';
  session_start();
  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location:login.php');
  }
  if ($_SESSION['role'] = 0) {
   
    header('Location:login.php');
  }
  if ($_POST) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

  if ($_FILES['image']['name'] != null) {
      $file = 'images/'.($_FILES['image']['name']);
      $imageType = pathinfo($file,PATHINFO_EXTENSION);
 
  if ($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
      echo "<script>alert('Invalid Image Format')</script>";
  }
  else{
      
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], $file);

      $stmt = $pdo->prepare("UPDATE posts SET title='$title' , content = '$content' , image = '$image' WHERE id = '$id' ");
      $result = $stmt->execute();
      if ($result) {
        echo "<script>alert('Successfully Added');window.location.href='index.php';</script>";
        
      }

  }
  }else{
      

      $stmt = $pdo->prepare("UPDATE posts SET title= '$title' , content = '$content'   WHERE id = '$id' ");
      $result = $stmt->execute();
      if ($result) {
        echo "<script>alert('Successfully Updated');window.location.href='index.php';</script>";
      }

  }

  } 

  $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ".$_GET['id']);
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
                     <label for="title">Title</label>
                     <input type="text" class="form-control " name="title" id="title" value="<?php echo $result[0]['title']; ?>">
                  </div>
                  <div class="form-group">
                     <label for="content">Content</label>
                     <textarea name="content" id="content" class="form-control" cols="30" rows="10">
                       <?php echo $result[0]['content']?>
                     </textarea>
                  </div>
                  <div class="form-group">
                     <div class="row ml-auto">
                       <label for="file">Image</label>
                     </div>
                     <div class="row mb-3 ">
                       <img src="images/<?php echo $result[0]['image'] ?>" alt="" style="width:100%; height:50vh;">
                     </div>
                     <input type="file" name="image" id="file" >
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
