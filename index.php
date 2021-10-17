<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Practice</title>

    <!--bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <!-- bootstrap js --->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
        crossorigin="anonymous"></script>

    <!-- jquery cdn and data table  start -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <!-- for data table table part end -->

    <!--my own css -->
    <link rel="stylesheet" href="./styles.css">

    <style>
        
    </style>
</head>

<body id="body">

    <!-- EDIT MODAL START -->
    <div class="modal-container" id="edit-modal-div">
        <div class="modalbody">
            <form action="" method='post' style = "">
                <div class="modal-content">
                    <h3 style="text-align: center;">Edit Your Info</h3>
                    <input name="post_type_UPDATE" type="text" value="update" hidden>
                    <input name="username" class="my-2 mx-2" id="username_modal_update" type="text" hidden><br>
                    <label class="my-2 mx-2" for="">Email Name</label>
                    <input name="email" class="my-2 mx-2" id="emailUpdate" type="email"><br>
                    <label class="my-2 mx-2" for="">Password</label>
                    <input name="pass" class="my-2 mx-2" id="passwordUpdate" type="text"><br>
                    <Button type="submit" class="btn btn-md btn-light" style="width : 100px">Update</Button>
                </div>
            </form>
            <div class="modal-footer">
                <button id="modal-closer" class="btn btn-md btn-light">Cancel</button>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL END  -->


    <!-- delete m odal -->

    <div class="modal-container" id="delete-modal-div">
        <div class="modalbody">
            <form action="" method='post'>
                <div class="modal-content">
                    <h3 style="text-align: center;">Are Your Sure You want to Delete this record ? </h3>
                    <input name="post_type_DELETE" type="text" value="delete" hidden>
                    <input name="username" class="my-2 mx-2" id="username_modal_delete" type="text" hidden><br>
                    <Button type="submit" class="btn btn-md btn-light"
                        style="width : 100px ; margin : 20px auto;">Delete</Button>
                        <button id="delModalCloseBtn" class="btn btn-md btn-light"
                        style="width : 100px ; margin : 20px auto;">Cancel</button>
                </div>
            </form>
          
        </div>
    </div>
    <!-- delete modal end -->


    <?php
        // info of the server we want to connect to
        $server = "localhost";
        $user = "root";
        $password = "";
        $database = "employeedb";
        // connection object / creating connection to server 
        $connection = mysqli_connect($server , $user , $password , $database);
        
        if(!$connection){
            die("connection un-uccessfull" . mysqli_connect_error()." db creationFailed reason " . mysqli_error($connection));
        }
        
        /*

        // create the database 
        $createdb_query = "create database employeeDB";
        mysqli_query($connection , $createdb_query);

        // create the emp table 
        mysqli_query($connection , "CREATE TABLE `emp` (`uname` varchar(30) not null primary key , `email` VARCHAR(30) NOT NULL , `password` VARCHAR(20) NOT NULL);");
        
        */


        // if post type is to edit a entry
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $uname = $_POST['username'];
            if(isset($_POST['post_type_UPDATE'])){
                $email = $_POST['email'];
                $pass = $_POST['pass'];
          
                $query = "UPDATE `emp` SET `email` = '$email' , `password` = '$pass' WHERE `emp`.`uname` = '$uname'";
                $res = mysqli_query($connection , $query);
                if($res){
                    
                    header("location: ./index.php?edited=true");
                }
                else{
                    echo mysqli_error($connection);
                }
            }

            // if post type is to delete
            else if(isset($_POST['post_type_DELETE'])){
                $query = "DELETE FROM `emp` WHERE `emp`.`uname` = '$uname'";
                $res = mysqli_query($connection , $query);
                if($res){
                    header("location: ./index.php?deleted=true");
                }
                else{
                    echo mysqli_error($connection);
                }
            }

            // if post type is to insert a entry
            else{
                $email = $_POST['email'];
                $pass = $_POST['pass'];
        
                if($uname == "" or $email == "" or $pass == ""){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> You have one or more input fields empty !<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                }
                else{
                    $insert_query = "INSERT INTO `emp` (`uname` , `email` , `password`) values ('$uname','$email', '$pass');";
                    $bool = mysqli_query($connection , $insert_query);
                    
                    if($bool){
                        // show a success alert
                        header("location: ./index.php?inserted=true");
                    }
                    else{
                        echo "Cant submit " . mysqli_error($connection);
                    }
                }
            }
        }


        //show success alert for update query 
        if(isset($_GET['edited'])){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> You have successfully Updated your information <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
        else if(isset($_GET['deleted'])){
            //show success alert for delete query 
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> You have successfully DELETED your information <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
        else if(isset($_GET['inserted'])){
            //show success alert for insert query 
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> You have successfully registered ! <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        }
    ?>

    <div class="container mt-5">
        <h1>
            Enter your name and password to Register
        </h1>
        <!--  -->
        <form id="form" method="POST" action="/first_php_project/index.php">
            <div class="mb-5 mt-5">
                <label for="username" class="form-label">UserName</label>
                <input name='username' type="text" class="form-control" id="username" placeholder="fatcat">
            </div>
            <div class="mb-5 mt-5">
                <label for="email" class="form-label">Email address</label>
                <input name='email' type="email" class="form-control" id="email" placeholder="abcd@gmail.com">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-5 mt-5">
                <label for="pass" class="form-label">Password</label>
                <input name='pass' type="password" class="form-control" id="pass"
                    placeholder="Enter your password here">
            </div>
            <button id="submit-btn" type="submit" class="btn btn-outline-dark">Submit</button>
        </form>
    </div>
    <div class="container my-5">
        <h3 class="my-5">Registered Users</h3>
        <table id="myTable" class="table">
            <thead>
                <tr class = "tablerow">
                    <th scope="col">UserName</th>
                    <th scope="col">Registered Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //echo var_dump($_POST);
                    $query = "SELECT * FROM `emp`";
                    $res = mysqli_query($connection , $query);
                    
                    while($row = mysqli_fetch_assoc($res)){
                        echo "<tr  class = 'tablerow'>
                            <th scope='row'> " . $row['uname'] . "</th>
                            <td> " . $row['email'] . " </td>
                            <td> " . $row['password'] . " </td>
                            <td> <button class='editBtn btn btn-primary btn-sm'> Edit </button> 
                             <button class='deleteBtn btn btn-primary btn-sm'> Delete </button> </td>
                            </tr>";
                    }
                ?>
            </tbody>

        </table>
    </div>
    <script>
        var editBtns = document.querySelectorAll('.editBtn');
        var modalcloser = document.getElementById('modal-closer');
        var edit_modal = document.getElementById('edit-modal-div');
        var body = document.getElementById('body');

        editBtns.forEach((element) => {
            element.addEventListener('click', () => {
                edit_modal.classList.add('show-modal');
                edit_modal.style.top = `${window.scrollY}px`;
                body.style.overflow = "hidden";

                var tr = element.parentNode.parentNode;
                var row = tr.children;
                var uname = row[0].innerText;
                var email = row[1].innerText;
                var pass = row[2].innerText;


                username_modal_update.value = uname;
                emailUpdate.value = email;
                passwordUpdate.value = pass;
                
            })
        });

        modalcloser.addEventListener('click', () => {
            edit_modal.classList.remove('show-modal');
            body.style = null;
        })


        var deleteBtns = document.querySelectorAll('.deleteBtn');
        var delete_modal = document.getElementById('delete-modal-div');
        deleteBtns.forEach((element) => {
            element.addEventListener('click', () => {
                delete_modal.classList.add('show-modal');
                delete_modal.style.top = `${window.scrollY}px`;
                body.style.overflow = "hidden";

                var tr = element.parentNode.parentNode;
                var row = tr.children;
                var uname = row[0].innerText;

                username_modal_delete.value = uname;
                
            })
        });

        delModalCloseBtn.addEventListener('click', () => {
            delete_modal.classList.remove('show-modal');
            body.style = null;
        })
    </script>
</body>

</html>