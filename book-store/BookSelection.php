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
        if(!isset($_SESSION['ascPrice'])) $_SESSION['ascPrice'] = true;
        if(!isset($_SESSION['ascTitle'])) $_SESSION['ascTitle'] = true;
        $selectionErrorClass = "hidden";
        extract($_POST);
        $bookList = BookFile::getAllBooks(); 
        if(isset($buy)){
            for ($i = 0; $i < sizeof($copies); $i++) {
                if ($copies[$i] > 0) {
                    $_SESSION['copies'] = $copies;
                    header("location: Confirmation.php");
                    exit();
                }
            }
            $selectionErrorClass = 'error';
        }
        if($_GET['sort']=='title') {        
            usort($bookList, "Book::cmp_title");        
            if($_SESSION['ascTitle']) $bookList = array_reverse ($bookList);
            $_SESSION['ascTitle'] = !$_SESSION['ascTitle']; // SESSION = FALSE!
        }
        if($_GET['sort']=='price') {        
            usort($bookList, "Book::cmp_price"); 
            if($_SESSION['ascPrice']) $bookList = array_reverse($bookList);
            $_SESSION['ascPrice'] = !$_SESSION['ascPrice']; // SESSION = FALSE!
        }
        $_SESSION["displayList"] = $bookList;
    ?>
    <div class="container">
        <h3 class="text-center">Select the number of copies for books you want to buy and click Buy button:</h3>
        <form action="BookSelection.php" method="post"><br/>
            <span class='<?php echo $selectionErrorClass ?>'>
                At least one book's number of copy should be greater than 0!
            </span>
            <table class="table">
                <tr>
                    <th><a href=BookSelection.php?sort=title>Title</a></th>
                    <th><a href=BookSelection.php?sort=price>Price</a></th>
                    <th>Copies</th>
                </tr>
                <?php    
                    $i=0;
                    foreach($bookList as $book):
                ?>
                <tr>
                    <td><?php echo $book->getTitle(); ?></td>
                    <td><?php echo $book->getPrice(); ?></td>
                    <?php echo "<td><input class='form-control' size='2' type='text' name='copies[]' value='".(isset($copies) ? $copies[$i] : '')."' /></td>"; ?>
                </tr>
                <?php endforeach; ?>          
            </table>
            <div class="text-center">
                <input type='submit'  class='btn btn-success btn-lg' name='buy' value='BUY'/>
            </div>
        </form>
    </div><br /><br />
</body>
</html>
   