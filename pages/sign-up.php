<?php 
if(session_status() === PHP_SESSION_NONE){
   session_start();
}


 ?>
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


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

if(isset($_SESSION['verified']) && $_SESSION['verified'] != ""){
  header("Location: sign-in.php");
}else{
}

            include("../database/config.php");
            
              if($_SERVER['REQUEST_METHOD'] == "POST"){

                $usernameError = $passwordError = $emptyError = $emailError = "";

                if(isset($_POST['submit'])){
                $fName = $_POST['first-name'];
                $lName = $_POST['last-name'];
                $username = $_POST['username'];
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $password = $_POST['password'];
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\w\d\s]).{8,}$/';
                $otp = random_int(100000, 999999);

                  


                  if(empty($_POST['first-name']) || empty($_POST['last-name']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])){
                    $emptyError = "Please enter all the details !";
                  
                  
                  }else{

                          if(preg_match('/[^A-Za-z0-9]/', $username)){
                                $usernameError = "Username must not contain any spaces or special characters !";
                            }
                          
                            $passwordGood = preg_match($pattern, $password);
                              if(!$passwordGood){
                               $passwordError = "Password must have one uppercase letter, one lowercase letter, one number and one special character !";
                              }
                            }


                            if(!($usernameError) && !($passwordError) && !($emptyError)){
                               
                              $email = isset($_POST['email']) ? $_POST['email'] : "";




                              
                                $fetch_query = "SELECT * FROM users WHERE email = '$email'";
    
                                  $fetch_query_run = mysqli_query($conn, $fetch_query);
    
                                  if($fetch_query_run){
                                    
                                    $result = mysqli_fetch_array($fetch_query_run, MYSQLI_ASSOC);

                                    if($result){

                                      $emailRow = $result['email'];
                                    

                                      if($emailRow){

                                       $emailError = "Email Already Exists !";

                                    }else{

                                    }
                                    
                                    }else{

                                      // header("Location: sign-up.php");

                                      include('../database/register.php');
                                    
                                      include('../send-mail.php');
                                    
                                      $_SESSION['user_email'] = $email;

                                      
                                    }
                                    
                                    
                                  }else{
                                    echo "Failed to fetch Data";
                                    
                                  }
                              
                            }
                          }
                            // unset($_POST['submit']);
                          }

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
                <?php if(isset($usernameError)){echo "<div class='text-danger small'>$usernameError</div>";}?>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email" name="email" aria-label="Email">
                </div>
                <?php if(isset($emailError)){echo "<div class='text-danger small' role='alert'>$emailError</div>";}?>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Password" id="password" name="password" aria-label="Password">
                  <i class="bi bi-eye-slash" id="togglePasswordd"></i>
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

<!-- otp container -->

<div class="otp-container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="otp-wrapper z-index-0" id="otp-wrapper">

            <div class="otp-body">

            <!-- Form Validation -->

            <?php 
              include_once('../database/config.php');
              $eror = "";
              if(isset($_POST['verify'])){

                  $userOtp = $_POST['otp'];

                  $sql = "SELECT * FROM users WHERE otp = '$userOtp'";
                
                  $sql_query = mysqli_query($conn, $sql);

                  if($sql_query){
                    $result = mysqli_fetch_array($sql_query, MYSQLI_ASSOC);

                    $eror = print_r($result);

                    if (isset($result) && is_array($result) && array_key_exists('otp', $result)) {
                      if ($result['otp'] == $userOtp) {
                          $verify = "UPDATE users SET verification = 1 WHERE otp = '$userOtp'";
                          $verify_query = mysqli_query($conn, $verify);
                  
                          if ($verify_query) {
                              $_SESSION['verified'] = 'You are successfully Verified !';
                              
                          } else {
                              $_SESSION['unverified'] = 'Failed to verify OTP';
                              header("Location: sign-in.php");
                              exit(); // Exit here as well
                          }
                      } else {
                          
                      }
                  } else {
                    $_SESSION['unverified'] = 'Failed to verify OTP';
                  }
                  
              }else{
                // $verificationError = "OTP didnot match !";
              }
            }

            if(isset($_POST['resend'])){
              $otp = random_int(100000, 999999);
              $email = $_SESSION['user_email'];
              $sql = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
              $sql_query = mysqli_query($conn, $sql);

              if($sql_query){
                $_SESSION['resendOk'] = 'OTP Resent !'; 
              }else{
                $_SESSION['resendError'] = 'OTP Resend Failed !';
              }

              include('../send-mail.php');
            }
            ?>


           


              <form role="form" action="sign-up.php" method="post">

              <div class="mb-3">
                  <label for="otp">Please Enter your OTP from your email.</label>
                  <input type="text" class="form-control" name="otp" placeholder="Enter your OTP" aria-label="otp">
                </div>
                <a id="expiry-div"> Resend another code in : <div id="timer"></div></a>
                  <button type="submit" name="resend" id = "resendBtn" class="btn btn-link">Resend</button>
                   
                  <button type="submit" name="verify" class="btn btn-primary w-100 my-4 mb-2" onclick="otpPopup();">Verify</button>
                  <button type="button" class="btn btn-outline-danger w-100 my-4 mb-2" onclick="cancelHandle()">Cancel</button>
                </div>

              </form>
            
              <!-- Main Form End -->

            </div>
          </div>
        </div>
      </div>
     
    </div>


  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></>
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
  <script>
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<script>
  

    function otpPopup(){
    var otpBox = document.getElementById('otp-wrapper');
    otpBox.style.display = 'flex';  
  }

  function cancelHandle(){
    var otpBox = document.getElementById('otp-wrapper');
    otpBox.style.display = 'none';
  }
</script>
  
<script>
  let resendButton = document.getElementById('resendBtn');
  resendButton.style.display = 'none';
function startCountdown(durationInSeconds) {
  let timerElement = document.getElementById('timer');
  let timerDiv = document.getElementById('expiry-div');

  function updateTimerDisplay(timeRemaining) {
    let minutes = Math.floor(timeRemaining / 60);
    let seconds = timeRemaining % 60;
    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
  }

  function countdown() {
    if (durationInSeconds > 0) {
      updateTimerDisplay(durationInSeconds);
      durationInSeconds--;
    } else {
      clearInterval(timerInterval);
      timerDiv.style.display = 'none';
      resendButton.style.display = 'flex';
    }
  }

  countdown(); // Initial call to display the timer immediately

  let timerInterval = setInterval(countdown, 1000); // Update every second
}

// Example: Start a countdown for 5 minutes (300 seconds)
startCountdown(5);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
        if(isset($_SESSION['otp']) && $_SESSION['otp'] != ""){

          ?>

      <script>
      Swal.fire({
      text: "An OTP verification code has been sent to your email address. Please enter your OTP code for verification",
      icon: "success"
    });
      </script>



          <?php
          unset($_SESSION['otp']);
        }


        if(isset($_SESSION['verified']) && $_SESSION['verified'] != ""){

          ?>

        <script>
        Swal.fire({
        text: "Successfully Verified",
        icon: "success"
        });

        window.location.href = "sign-in.php";

        </script>
          <?php
          // unset($_SESSION['verified']);
        }
        



        if(isset($_SESSION['unverified']) && $_SESSION['unverified'] != ""){

          ?>

      <script>
      Swal.fire({
      text: "Wrong OTP Code !",
      icon: "error"
    });

    document.addEventListener("DOMContentLoaded", function() {

      otpPopup();
    });
      </script>



          <?php
          unset($_SESSION['unverified']);
        }


        if(isset($_SESSION['resendOk']) && $_SESSION['resendOk'] != ""){

          ?>

      <script>
      Swal.fire({
      text: "Resend Successful !",
      icon: "success"
    });

    document.addEventListener("DOMContentLoaded", function() {

      otpPopup();
    });
      </script>



          <?php
          unset($_SESSION['resendOk']);
        }
        if(isset($_SESSION['resendError']) && $_SESSION['resendError'] != ""){

          ?>

      <script>
      Swal.fire({
      text: "Resend Failed !",
      icon: "error"
    });

    document.addEventListener("DOMContentLoaded", function() {

      otpPopup();
    });
      </script>



          <?php
          unset($_SESSION['resendError']);
        }

        ?>



<script>
        const togglePassword = document
            .querySelector('#togglePasswordd');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            this.classList.toggle('bi-eye');
        });
    </script>
</body>

</html>