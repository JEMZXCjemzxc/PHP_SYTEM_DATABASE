<?php

    if(isset($_GET['id'])){  // check if the array contains the id 
        $id = $_GET["id"];

        include "conn.php";

        $sql = "DELETE FROM clients WHERE id =$id"; //i delete ang client based sa id nga gi click
        $conn->query($sql); //execute the query
    }

    header ("location: /jemzxc_shop/home.php");
    exit();

?>