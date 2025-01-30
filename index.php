<!-- index.php - Homepage -->
<?php
include 'includes/../db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="../Fruit/main.js"></script>
  <link rel="stylesheet" href="./main.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'includes/../header.php'; ?>
    
    <div class="container">
        <h1>Fresh Fruits & Vegetables</h1>

        <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade show active" id="nav-main-courses" role="tabpanel"
          aria-labelledby="nav-main-courses-tab">
          <div class="container-fluid">
            <div class="row justify-content-center">
              <div class="col">
        <div class="products">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card-body' style='width: 24rem;'>
                        <img src='./images/" . $row['image'] . "' alt='" . $row['name'] . "' class='card-img-top'>
                        <div class='card-title'>
                            <h2>" . $row['name'] . "</h2>
                            <p>$" . $row['price'] . "</p>
                            <a href='cart.php?add=" . $row['id'] . "' class='btn btn-primary'>Add to Cart</a>
                        </div>
                        </div>
                      </div>";
            }
            ?>
            </div>
        </div>
        </div>
    </div>
    </div>
    <?php include 'includes/../footer.php'; ?>
</body>
</html>