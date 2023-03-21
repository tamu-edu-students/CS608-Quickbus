<!DOCTYPE html>
<html lang="en">
<?php include "template/header.php"; ?>

<body>
    <div class="container">
        <?php include "template/nav.php"; ?>
        <div class="jumbotron">
            <h1>Admin Page</h1>
            <div class="row">
                <div class="col">
                    <h5>ID</h5>
                </div>
                <div class="col">
                    <h5>Start</h5>
                </div>
                <div class="col">
                    <h5>Destination</h5>
                </div>
                <div class="col">
                    <h5>DepartTime</h5>
                </div>
                <div class="col">
                    <h5>ArriveTime</h5>
                </div>
                <div class="col">
                    <h5>Price</h5>
                </div>
                <div class="col"></div>
            </div>
            <div class="list">
                <form action="/addRoute.php" method="post">
                    <div class="row">
                        <div class="col"><input name="Start" class="form-control"></div>
                        <div class="col"><input name="Destination" class="form-control"></div>
                        <div class="col"><input name="DepartTime" type="datetime-local" class="form-control"></div>
                        <div class="col"><input name="ArriveTime" type="datetime-local" class="form-control"></div>
                        <div class="col"><input name="Price" class="form-control"></div>
                        <div class="col"><button type="submit" class="btn btn-primary">Create</button></div>
                    </div>
                </form>
                <?php
                require_once "config.php";
                try {
                    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                    $pdo->setAttribute(
                        PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION
                    );
                    $sql = "SELECT * from tbl_route LIMIT 50";
                    $statement = $pdo->prepare($sql);
                    $statement->execute();

                    $row = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($row as $key => $val) {
                        echo '<form action="editRoute.php" method="post">';
                        echo '<input name="inputid" value="' .
                            $val["id"] .
                            '"hidden><div class="form-row">';
                        echo '<div class="col"><input name="Start" class="form-control" value="' .
                            $val["start"] .
                            '"></div>';
                        echo '<div class="col"><input name="Destination" class="form-control" value="' .
                            $val["dest"] .
                            '"></div>';
                        echo '<div class="col-3"><input name="DepartTime" class="form-control" value="' .
                            $val["departTime"] .
                            '"></div>';
                        echo '<div class="col-3"><input name="ArriveTime" class="form-control" value="' .
                            $val["arriveTime"] .
                            '"></div>';
                        echo '<div class="col-1"><input name="Price" class="form-control" value="' .
                            $val["price"] .
                            '"></div>';
                        echo '<div class="col-1"><button type="submit" class="btn btn-primary">Edit</button></div><div class="col-1"><button type="submit" class="btn btn-danger">Remove</button></div></div></form>';
                    }
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
            </div>
        </div>
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </div>
</body>

</html>