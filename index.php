<?php
$conn = mysqli_connect('localhost', 'root', '', 'short_link');

if (isset($_GET["url"])) {
  $short = $_GET["url"];
  $query = "SELECT * FROM links WHERE short = '$short'";
  $result = mysqli_query($conn, $query);

  $data = mysqli_fetch_assoc($result);

  if (isset($data)) {
    echo "
      <script>
        window.open('{$data['link']}');
      </script>
    ";
  }
}

if (isset($_POST["submit"])) {
  $url = $_POST["url"];
  $short = strtotime('now');
  $query = "INSERT INTO links VALUES ('', '$short', '$url')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    $resultUrl = "?url=" . $short;
    $url = $_SERVER["SERVER_NAME"] . "/short_link/index.php" . $resultUrl;
    echo "<a href='$resultUrl' target='_blank'>$url</a>";
  } else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ShortLink</title>
</head>

<body>
  <form action="" method="post">
    <input type="text" name="url" placeholder="Enter URL" style="width: 500px;">
    <input type="submit" name="submit" value="Shorten">
  </form>

  <script>
    window.close();
  </script>
</body>

</html>