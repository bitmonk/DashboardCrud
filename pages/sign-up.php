<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Admin Dashboard
  </title>
  <!--     Fonts and icons  -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->

  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">


  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Welcome!</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            
            <div class="row px-xl-5 px-sm-4 px-3">
                            
              
            </div>
            <div class="card-body">

            <!-- Form Validation -->

            <?php

            include("../database/config.php");
            
              if($_SERVER['REQUEST_METHOD'] == "POST"){

                if(isset($_POST['submit'])){
                $fName = $_POST['first-name'];
                $lName = $_POST['last-name'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s]).{8,}$/';



                  $usernameError = $passwordError = $emptyError = "";


                  if(empty($_POST['first-name']) || empty($_POST['last-name']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])){
                    $emptyError = "Please enter all the details !";
                  }else{

                     $sql = "SELECT * FROM users WHERE email = '$email'";
                     $result = mysqli_query($conn, $sql);
                     $user = mysqli_fetch_assoc($result);

                        if ($user) {
                          $emailError = "Email already exists!";
                              header("Location: \dashboard\pages\sign-up.php");
                          } else {

                          if(preg_match('/[^A-Za-z0-9]/', $username)){
                                $usernameError = "Username must not contain any spaces or special characters !";
                            }
                          
                            $passwordGood = preg_match($pattern, $password);
                              if(!$passwordGood){
                               $passwordError = "Password must have one uppercase letter, one lowercase letter, one number and one special character !";
                              }
                            }
                            
                            
                            if(!($usernameError) && !($passwordError) && !($emptyError)){

                                include('../database/register.php');
             
                                // include('../database/register.php');
                               
                             }else{
                             echo "Data could'nt be inserted !";
                           }
                          }
                        }

                        

                }
                  
                // else{
                   
                //   include('../database/config.php');

                //   include('../database/register.php');

                // }

            ?>

              <form role="form" action="sign-up.php" method="post">
              <div class="mb-3">
                  <input type="text" class="form-control" name="first-name" placeholder="First Name" aria-label="Name">
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control" name="last-name" placeholder="Last Name" aria-label="Name">
                </div>
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Username" name="username" aria-label="Name">
                </div>
                <?php if(isset($usernameError)){echo "<div class='text-danger small'>$usernameError</div>";} ?>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" aria-label="Email">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Password" name="password" aria-label="Password">
                </div>
                <?php if(isset($passwordError)){echo "<div class='text-danger text-center small'>$passwordError</div>";} ?>
                <?php if(isset($emptyError)){echo "<div class='text-danger small' role='alert'>$emptyError</div>";}?>
                <div class="form-check form-check-info text-start">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                  </label>
                </div>
                <div class="text-center">
                  <button type="submit" name="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                </div>
                <p class="text-sm mt-3 mb-0">Already have an account? <a href="\dashboard\pages\sign-in.php" class="text-dark font-weight-bolder">Sign in</a></p>

              </form>
            
              <!-- Main Form End -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mb-4 mx-auto text-center">
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Company
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            About Us
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Team
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Products
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Blog
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
            Pricing
          </a>
        </div>
        <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-dribbble"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-twitter"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-instagram"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-pinterest"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-secondary me-xl-4 me-4">
            <span class="text-lg fab fa-github"></span>
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> Soft by Creative Tim.
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
  


</body>

</html>