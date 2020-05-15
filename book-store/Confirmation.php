<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alina Kurliantseva | Book Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PHP, CSS, Bootstrap, Adobe Photoshop">
    <meta name="keywords" content="PHP, CSS, Bootstrap, Adobe Photoshop">
    <link href="inc/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
        include "inc/Class_Lib.php";
        session_start();
        if(!isset($_SESSION['copies'])) {
            header("location: BookSelection.php");
        }
    ?>
    <div class="container">
        <h3 class="text-center">Thank you, please review your selection:</h3>
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Copies</th>
                <th>Total</th>
            </tr>
            <?php
                $i = 0;
                $copies = $_SESSION['copies'];
                $bookList = $_SESSION["displayList"];
                $total = 0;
                foreach($bookList as $book):
            ?>
            <tr>
                <?php
                    if ($copies[$i] > 0) {
                        $subTotal = $book->getPrice() * $copies[$i];
                        echo "<tr><td>".$book->getTitle()."</td><td>".$book->getPrice()."</td><td>$copies[$i]</td><td>\$$subTotal</td></tr>";
                        $total += $subTotal;
                    }
                    $i++; 
                ?>    
            </tr>
            <?php endforeach;
                echo "<tr><th colspan='3' style='text-align: right'>Grand Total: </th><td>\$$total</td></tr>";
            ?>
        </table><br /><br />
        <form action="BookSelection.php" method="post">
            <input type='submit' class='btn btn-success btn-lg' name='back' value='Back' />
        </form>
    </div>
</body>
</html>    
    