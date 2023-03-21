<!DOCTYPE html>
<html lang="en">
<?php include "template/header.php"; ?>

<body>
    <div class="container">
        <?php include "template/nav.php"; ?>
        <div class="jumbotron">
            <h1>Shopping Cart</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Order#</th>
                        <th scope="col">Start</th>
                        <th scope="col">Destination</th>
                        <th scope="col">DepartTime</th>
                        <th scope="col">ArriveTime</th>
                        <th scope="col">Passenger</th>
                        <th scope="col">Price</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="list">
                    <?php
                    require_once "config.php";
                    try {
                        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql =
                            "SELECT * from tbl_route INNER JOIN tbl_order ON tbl_order.userId=:user AND tbl_order.routeId=tbl_route.id AND complete=0 AND deleted=0";
                        $user = $_SESSION["user"];
                        $statement = $pdo->prepare($sql);
                        $statement->bindValue(":user", $user);
                        $statement->execute();
                        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($row as $key => $val) {
                            $keys = array_keys($val);
                            echo "<tr>";
                            for ($x = 0; $x < 5; $x++) {
                                echo "<td>" . $val[$keys[$x]] . "</td>";
                            }
                            echo "<td>" . $val["passenger"] . "</td>";
                            echo "<td>" . $val['price'] * $val['passenger'] . "</td>";
                            echo '<td><form action="/removeItem.php" method="post"><input name="inputId" value="' .
                                $val["id"] .
                                '" hidden><button type="submit" class="btn btn-danger">Remove</button></form>';
                            echo '<form action="/addPassenger.php" method="post"><input name="inputId" value="' .
                                $val["id"] .
                                '" hidden><input name="inputCnt" value="' .
                                $val["passenger"] .
                                '" hidden><button type="submit" class="btn btn-primary">Add Passenger</button></form></td>';
                            echo "</tr>";
                        }
                        $pdo = null;
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
            <a class="nav-link" href="/checkoutItem.php">Proceed to checkout</a>
        </div>
    </div>
</body>

</html>