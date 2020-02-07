<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="assets/img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Register</title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Register Content -->
  <div class="container-register">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">REGISTER</h1>
                  </div>
                  <form>
                    <div class="form-group">
                      <input type="text" class="form-control" id="firstname" placeholder="Firstname">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" id="lastname" placeholder="Lastname">
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control" id="email" 
                        placeholder="Email Address">
                    </div>
                    <div class="form-group">
                      <select id="department" class="form-control mb-3">
                        <option value="0" selected disabled>Please select a Department</option>
                        <option value="2">Accounts Payable</option>
                        <option value="3">Purchasing</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control username" id="username" placeholder="Username" disabled>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password2" placeholder="Repeat Password">
                      <label id="pass_alert" style="display: none"></label>
                    </div>
                    <div class="form-group">
                      <button id="register" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- Registration ALERT -->
                    <div class="form-group">
                      <div id="reg-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                      <div id="reg-success" class="alert alert-success" role="alert" style="display: none"></div>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="index.php">Already have an account?</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Register Content -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/ruang-admin.min.js"></script>
  <script src="assets/js/jquery.toast.js"></script>
  <?php include 'index-js.php'; ?>
</body>

</html>