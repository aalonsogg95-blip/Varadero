<?php

$conn=mysqli_connect("localhost", "julisa", "juVadasa21", "varadero");
    if(!$conn){
        echo "Database connected".mysqli_connect_error();
    }

    mysqli_set_charset($conn, "utf8");