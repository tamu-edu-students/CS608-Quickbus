<!DOCTYPE html>
<html lang="en">
<?php include "template/header.php"; ?>

<body>
    <div class="container">
        <?php include "template/nav.php"; ?>
        <div class="jumbotron">
            <h1>Search for routes</h1>
            <form action="/userHome.php" method="post">
                <div class="row">
                    <div class="col">
                        <input type="text" name="inputStart" id="inputStart" class="form-control" placeholder="Start" required autofocus>
                    </div>
                    <div class="col">
                        <input type="text" name="inputDestination" id="inputDestination" class="form-control" placeholder="Destination" required autofocus>
                    </div>
                    <div class="col">
                        <input type="date" name="inputTime" id="inputTime" class="form-control" placeholder="Time">
                    </div>
                    <div class="col">
                        <button id="btnSignUp" class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
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
                    require_once('config.php');
                    try {
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = 'SELECT * from tbl_route WHERE start=:start AND dest=:dest AND (departTime>=CASE WHEN :departTime="" THEN departTime ELSE :departTime END) ORDER BY departTime ASC';
                            $start = $_POST["inputStart"];
                            $dest = $_POST["inputDestination"];
                            $departTime = $_POST["inputTime"];

                            $statement = $pdo->prepare($sql);
                            $statement->bindValue(':start', $start);
                            $statement->bindValue(':dest', $dest);
                            $statement->bindValue(':departTime', $departTime);
                            $statement->execute();

                            $row = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($row as $key => $val) {
                                $keys = array_keys($val);
                                echo "<tr>";
                                for ($x = 1; $x < sizeof($val); $x++) {
                                    echo ("<td>" . $val[$keys[$x]] . "</td>");
                                }
                                echo '<td><form action="/addItem.php" method="post"><input name="inputRoute" value="' . $val["id"] . '" hidden><button type="submit" class="btn btn-primary mb-2">order</button></form></td></tr>';
                            }
                            $pdo = null;
                        }
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