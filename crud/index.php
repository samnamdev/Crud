<?php
$insert= false;
$update= false;
$delete= false;


// connect to the server
  $server = "localhost";
  $username = "root";
  $password = "";
  $database = "notes";
  
  $conn = mysqli_connect($server,$username,$password,$database);
  if (!$conn) {
    die ("error");
  }

  // Delete karne ke liye
if (isset($_GET['delete'])) {
  $sn=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `notes` WHERE `sn` = $sn";
  $result=mysqli_query($conn,$sql);
}
#######################################################

  if ($_SERVER['REQUEST_METHOD'] =='POST') {
    if(isset($_POST['snedit'])){
      // Records update karne ke liye
      $sn = $_POST["snedit"];
      $title = $_POST["titleedit"];
    $description = $_POST["descriptionedit"];
    $author = $_POST["author"];

    $sql= "UPDATE `notes` SET `title` = '$title' , `description` = '$description', `author` = '$author'  WHERE `notes`.`sn` = $sn";
    $result=mysqli_query($conn,$sql);
    if ($result) {
      $update=true;
    }

    }

    else {
        
    // Notes ko Insert karne ke liye
    $title = $_POST["title"];
    $description = $_POST["description"];
    $author = $_POST["author"];


    $sql= "INSERT INTO `notes` ( `title`, `description`,`author`, `date`) VALUES ( '$title', '$description','$author', current_timestamp())";
    $result=mysqli_query($conn,$sql);

    if ($result) {
      //echo "The record has been inserted succefully";
      $insert= true;
    }
    else {
      echo "The record has not been inserted succefully";
    }
  }
}
  
?>






<!doctype html>
<html lang="eg">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous">

    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <title>iNOTES CRUD</title>
</head>

<body>

    <!-- Edit modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
  Edit modal
</button> -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editmodalLabel">Edit this Note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/crud/index.php" method="POST">

                        <input type="hidden" name="snedit" id="snedit">
                        <div class="mb-3">
                            <label for="titleedit" class="form-label">Note title</label>
                            <input type="text" class="form-control" id="titleedit" name="titleedit"
                                aria-describedby="emailHelp">

                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Note Description</label>
                            <textarea class="form-control" id="descriptionedit" name="descriptionedit"
                                rows="3"></textarea>

                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <textarea class="form-control" id="author" name="author"
                                rows="3"></textarea>

                        </div>

                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="/crud/logo.img" height="28px" alt=""> Crud</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact US</a>
                    </li>

                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
      if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Record has inserted seccessfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      
    ?>
    <?php
      if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong>Your note has been deleted seccessfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      
    ?>
    <?php
      if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong>Your note has been Updated seccessfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      
    ?>


    <div class="container my-3">

        <h2>Add A Note to iNotes App</h2>
        <form action="/crud/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>

            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <textarea class="form-control" id="author" name="author" rows="3"></textarea>

            </div>

            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>

    </div>

    <div class="container my-4">

        <!-- <?php
     //   $sql= "SELECT * FROM `notes`";
       // $result = mysqli_query($conn, $sql);
       // while ($row=mysqli_fetch_assoc($result)) {
          
         // echo $row ['sn']   .  ".  title"    .$row ['title']   . "Desc is"  .   $row ['description'];
         // echo"<br>";
        //}
      ?> -->

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">sn</th>
                    <th scope="col">title</th>
                    <th scope="col">description</th>
                    <th scope="col">Author</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
        $sql= "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sn=0;
        while ($row=mysqli_fetch_assoc($result)) {
          $sn=$sn+1;
          echo "<tr>
          <th scope='row'>".$sn ." </th>
          <td>". $row ['title']."</td>
          <td>". $row ['description']."</td>
          <td>". $row ['author']."</td>
          <td><button class=' edit btn btn-sm btn-primary' id=". $row ['sn']." >Edit</button> <button class=' delete btn btn-sm btn-primary' id= d".$row ['sn']." >Delete</button> </td>
      </tr>";
          
        }
      ?>



                <!-- <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr> -->

            </tbody>
        </table>

    </div>
    <hr>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            titleedit.value = title;
            descriptionedit.value = description;
            snedit.value = e.target.id;
            console.log(e.target.id)
            $('#editmodal').modal('toggle');
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            sn = e.target.id.substr(1);

            if (confirm("Your message was deleted!")) {
                console.log("yes");
                window.location = `/crud/index.php?delete=${sn}`;
                // TODO: Create a form and use post request to submit a form
            } else {
                console.log("no");
            }
        })
    })
    </script>

</body>

</html>


<!-- <script>
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
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html> -->