<?php
session_start();
require_once('config.php');
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$request = $_SERVER['REQUEST_URI'];
//pages accessible for guests
switch ($request) {
	case '/':
		if (!isset($_SESSION['user']))
			require 'views/index.php';
		else header('Location: /userHome.php');
		exit;
	case '/index.php':
		if (!isset($_SESSION['user']))
			require 'views/index.php';
		else header('Location: /userHome.php');
		exit;
	case '/signin.php':
		require 'views/signin.php';
		exit;
	case '/validateLogin.php':
		validateLogin();
		exit;
	case '/signup.php':
		require 'views/signup.php';
		exit;
	case '/register.php':
		register();
		validateLogin();
		exit;
}
//session validation
if (!isset($_SESSION['user'])) {
	require 'views/index.php'; //maybe error.php
	exit;
}
//pages require sign-in
switch ($request) {
	case '/userHome.php':
		require 'views/userHome.php';
		exit;
	case '/logout.php':
		session_start();
		session_unset();
		session_destroy();
		header('Location: /index.php');
		exit;
	case '/history.php':
		require 'views/history.php';
		exit;
	case '/shoppingCart.php':
		require 'views/shoppingCart.php';
		exit;
	case '/checkoutItem.php':
		require 'views/checkoutItem.php';
		exit;
	case '/admin.php':
		require 'views/admin.php';
		exit;
	case '/addItem.php':
		addItem();
		exit;
	case '/removeItem.php':
		removeItem();
		exit();
	case '/addPassenger.php':
		addPassenger();
		exit;
	case '/addRoute.php':
		addRoute();
		exit;
	case '/editRoute.php':
		editRoute();
		exit;
	case '/checkout.php':
		checkout();
		exit;
	default:
		http_response_code(404);
		require 'views/error.php';
		exit;
}
//$pdo = null;
function validateLogin()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;

		$sql = 'SELECT * FROM tbl_user WHERE email = :email';
		$email = $_POST["inputEmail"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':email', $email);
		$statement->execute();

		$row = $statement->fetch(PDO::FETCH_ASSOC);
		if ($row["password"] === $_POST["inputPassword"]) {
			$_SESSION['valid'] = true;
			$_SESSION['timeout'] = time();
			$_SESSION['user'] = $row["userid"];
			header('Location: index.php');
		} else echo ("wrong password!");
	}
}
function register()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'INSERT INTO tbl_user(name, email, password) VALUES (:name, :email, :password)';
		$name = $_POST["inputName"];
		$email = $_POST["inputEmail"];
		$password = $_POST["inputPassword"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':name', $name);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':password', $password);
		$statement->execute();
		
		//echo ("User created successfully !");
		//header('Location: userHome.php');
	}
}
function addItem()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'INSERT INTO tbl_order(userId,routeId) VALUES (:user,:route)';
		$route = $_POST["inputRoute"];
		$user = $_SESSION['user'];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':route', $route);
		$statement->bindValue(':user', $user);
		$statement->execute();

		header('Location: userHome.php');
	}
}
function addPassenger()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'UPDATE tbl_order SET passenger=:count+1 WHERE id=:id';
		$id = $_POST["inputId"];
		$count = $_POST["inputCnt"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':id', $id);
		$statement->bindValue(':count', $count);
		$statement->execute();

		header('Location: shoppingCart.php');
	}
}
function addRoute()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'INSERT INTO tbl_route(start,dest,departTime,arriveTime,price) VALUES (:start, :destination,:depart,:arrive,:price)';
		$start = $_POST['Start'];
		$destination = $_POST["Destination"];
		$depart = $_POST["DepartTime"];
		$arrive = $_POST["ArriveTime"];
		$price = $_POST["Price"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':start', $start);
		$statement->bindValue(':destination', $destination);
		$statement->bindValue(':depart', $depart);
		$statement->bindValue(':arrive', $arrive);
		$statement->bindValue(':price', $price);
		$statement->execute();

		header('Location: admin.php');
	}
}
function removeItem()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'UPDATE tbl_order SET deleted=1 WHERE id=:id';
		$id = $_POST["inputId"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':id', $id);
		$statement->execute();

		header('Location: shoppingCart.php');
	}
}
function editRoute()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		global $pdo;
		$sql = 'UPDATE tbl_route SET start=:start, dest=:destination, departTime=departTime, arriveTime=arriveTime, price=:price WHERE id=:id';
		$start = $_POST["Start"];
		$destination = $_POST["Destination"];
		//depart
		//arrive
		$price = $_POST["Price"];
		$id = $_POST["inputid"];

		$statement = $pdo->prepare($sql);
		$statement->bindValue(':start', $start);
		$statement->bindValue(':destination', $destination);
		$statement->bindValue(':price', $price);
		$statement->bindValue(':id', $id);
		$statement->execute();

		header('Location: /admin.php');
	}
}
function checkout()
{
	//actually a get req...
	global $pdo;
	$sql = 'UPDATE tbl_order SET complete=1 WHERE userId=:user';
	$route = $_POST["inputRoute"];
	$user = $_SESSION['user'];

	$statement = $pdo->prepare($sql);
	$statement->bindValue(':user', $user);
	$statement->execute();
	echo "asdfadsf";
	header('Location: /checkoutItem.php');
}
