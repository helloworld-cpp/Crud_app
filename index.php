<?php

    $temp = false;
    $update = false;
    $delete = false;
    // server connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db_farhan";

    // connecting server and database

    $conn = mysqli_connect($servername,$username,$password,$database);
    if($conn != true){
      die ("Not Connected");
    }
    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $sql = "DELETE FROM `notes` WHERE `notes`.`serial_num` = $sno";
      $res = mysqli_query($conn, $sql);
      if($res == true){
        $delete = true;
      }else{
        echo "Error Record not Deleted <br>";
      }

    }

    //echo $_SERVER['REQUEST_METHOD'];
    if(($_SERVER['REQUEST_METHOD'] == 'POST')){
      if(isset($_POST['snoEdit'])){
        //update
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $desc = $_POST['descriptionEdit'];
        $sql = "UPDATE `notes` SET `name` = '$title' , `description` = '$desc' WHERE `notes`.`serial_num` =$sno;";
        $res = mysqli_query($conn,$sql);
          if($res == true){
              $update = true;
          }else{
            echo "We could not update your record <br>";
          }
      }
      else{
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        // echo $title . "<br>";
        // echo $desc . "<br>";
        $sql = "INSERT INTO notes (serial_num,name,description,date) VALUES (NULL,'$title','$desc',current_timestamp())";
        $res = mysqli_query($conn,$sql);
        if($res == true){
              $temp = true;
        }else{
            echo "Data not inserted <br>";
        } 
      }
      
      

    }

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <title>My Notes</title>
  </head>
  <body>

        <!-- Edit Modal -->
          <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <form action="/crud/index.php" method="POST">
                  <div class="modal-body">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="form-group">
                      <label for="title">Note Title</label>
                      <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                      <label for="desc">Note Description</label>
                      <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                    </div> 
                  </div>
                  <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                <a class="navbar-brand" href="/crud"><img src="/crud/logo.png" height="33px" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/crud">Home</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                </div>
        </nav>
        <?php
        if($temp){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> You note has been inserted successfully.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
          $temp = false;
        }
        ?>

        <?php
          if($update){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> You note has been updated successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            $temp = false;
          }
        ?>

        <?php
          if($delete){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> You note has been delete successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
            $temp = false;
        }
        ?>
        <div class="container my-3">
            <h2> Add a note</h2> 
            <form action="/crud/index.php" method="post">
                <div class="mb-3">
                  <label for="title" class="form-label">Name Title</label>
                  <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="aria-desc" class="form-label">Note Description</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                  </div>

                <button type="Add Note" class="btn btn-primary">Submit</button>
                
              </form>

        </div>

        <div class="container my-4">

        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">S.No</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $sql = "SELECT * from notes";
              $res = mysqli_query($conn,$sql);
              $sn = 0;
              if($res == true){
                  while($arr = mysqli_fetch_assoc($res)/* return associative array */){
                    $sn = 1 + $sn;
                    echo "<tr>

                        <th scope='row'>" . $sn . "</th>
                        <td>". $arr['name'] . "</td>
                        <td>". $arr['description']. "</td>
                        <td> <button class = 'edit btn btn-sm btn-primary' id=".$arr['serial_num']." >Edit</button> <button class = 'delete btn btn-sm btn-primary' id=d".$arr['serial_num']." >Delete</button> </td>
                        </tr>";
                  } 
                     
              }else{
                  echo "Invalid querry <br>";
              }
            
              ?>
          </tbody>
        </table>

        </div>

    <!-- Optional JavaScript; choose one of the two! -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>

  <!-- JavaScript for the modal -->
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1,);
        if (confirm("Are you sure to delete this record!")){
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;   
          // TODO : create a form and use post request to submit a form//

        }else{
          console.log("no");
        }

      })
    })

  </script>

   
   
  </body>
</html>