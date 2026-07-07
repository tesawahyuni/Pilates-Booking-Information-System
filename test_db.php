<?php

echo "STEP 1<br>";

require_once "config/database.php";

echo "STEP 2<br>";

if ($conn) {
    echo "Database Connected";
} else {
    echo "Database Failed";
}