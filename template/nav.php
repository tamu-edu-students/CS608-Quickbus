<div class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/userHome.php") { ?>active<?php
                                    } ?>"> <a class="nav-link" href="/">Home</a> </li>
                <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/shoppingCart.php" || $_SERVER["SCRIPT_NAME"] == "/checkoutItem.php") { ?>active<?php
                                    } ?>"> <a class="nav-link" href="/shoppingCart.php">Shopping Cart</a> </li>
                <li class="nav-item <?php if ($_SERVER['REQUEST_URI'] == "/history.php") { ?>active<?php
                                    } ?>"> <a class="nav-link" href="/history.php">History</a> </li>
                <li class="nav-item <?php
                                    session_start();
                                    if ($_SERVER['REQUEST_URI'] == "/admin.php") {
                                        echo 'active ';
                                    }
                                    require_once('config.php');
                                    try {
                                        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $sql = 'SELECT admin FROM tbl_user WHERE userid = :user';
                                        $user = $_SESSION['user'];

                                        $statement = $pdo->prepare($sql);
                                        $statement->bindValue(':user', $user);
                                        $statement->execute();

                                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                                        if (!$row['admin']) {
                                            echo 'd-none';
                                        }
                                        $pdo = null;
                                    } catch (PDOException $e) {
                                        die($e->getMessage());
                                    }
                                    ?>"> <a class="nav-link" href="/admin.php">Admin</a> </li>
                <li class="nav-item"> <a class="nav-link" href="/logout.php">Logout</a> </li>
            </ul>
        </div>
    </nav>
    <h3 class="text-muted">Travel booking system</h3>
</div>