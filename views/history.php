<!DOCTYPE html>
<html lang="en">
<?php include "template/header.php"; ?>

<body>
    <div class="container">
        <?php include "template/nav.php"; ?>
        <div class="jumbotron">
            <h1>Purchase History</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Order#</th>
                        <th scope="col">Start</th>
                        <th scope="col">Destination</th>
                        <th scope="col">DepartTime</th>
                        <th scope="col">ArriveTime</th>
                        <th scope="col">Price</th>
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
                            "SELECT * from tbl_route where id IN (SELECT routeId from tbl_order where userId= :user AND complete=1 AND deleted=0)";
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
                            echo "<td>" . $val['price'] . "</td>";
                            echo "</tr>";
                        }
                        $pdo = null;
                    } catch (PDOException $e) {
                        die($e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>