<?php
session_start();
session_destroy();
unlink("cart_data.json");
header("Location: index.php");
