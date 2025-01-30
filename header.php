<header>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Linking Correctly -->
  <link rel="stylesheet" href="assets/css/main.css"> <!-- Ensure the correct path -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="C:\wamp64\www\Fruit\main.js"></script> <!-- Correct path for JS -->

  <style>
    .signup-btn {
        display: inline-block;
        text-decoration: none;
        padding: 12px 20px;
        background: #27ae60;
        color: white;
        border-radius: 5px;
        transition: 0.3s;
    }

    .signup-btn:hover {
        background: #219150;
    }
  </style>
</header>

<body id="sec-home">
  <section>
    <nav class="navbar navbar-expand-lg bg-light mt-2 mx-3 rounded">
      <div class="container-lg bg-light">
        <a class="navbar-brand text-primary fw-semibold fs-3" href="index.php">
          <img src="assets/images/logo.png" alt="Logo" width="50" height="50"
            class="d-inline-block align-text-center">
          Food Delivery
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-primary active fw-bold smooth-scroll" href="index.php">🏠 Home</a>
            </li>
            <li class="nav-item">
              <a href="cart.php" class="nav-link smooth-scroll">🛒 Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link smooth-scroll" href="tracker.php">📦 Order Tracker</a>
            </li>
            <li class="nav-item">
              <a class="nav-link smooth-scroll" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link smooth-scroll" href="profile.php">Profile</a>
            </li>
          </ul>
          <form class="d-flex ms-lg-5 ms-0" role="search">
            <a href="logout.php" class="signup-btn">🚪 Logout</a>
          </form>
        </div>
      </div>
    </nav>
  </section>

  <script>
    // Add event listener for logout confirmation
    document.addEventListener("DOMContentLoaded", function() {
        const logoutBtn = document.querySelector(".signup-btn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", function(e) {
                const confirmLogout = confirm("Are you sure you want to log out?");
                if (!confirmLogout) {
                    e.preventDefault();
                }
            });
        }
    });
  </script>
</body>
</html>
