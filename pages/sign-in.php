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
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body class="">


  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">

                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">

                <!-- Main Form -->
                <?php
include_once('../database/config.php');

$emailError = $passwordError = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['s_email'] = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user = mysqli_fetch_array($result);

        if ($user !== null) {
            $user_id = $user['id'];

            if ($user) {
                if ($user['verification'] == 1) {
                    if (password_verify($password, $user["password"])) {
                        $_SESSION['currentid'] = $user_id;

                        if ($user['user_type'] == 'admin') {
                            header("Location: admin-dashboard.php");
                            die();
                        } else {
                            header("Location: dashboard.php");
                        }
                    } else {
                        $passwordError = "Password Does not Match!";
                    }
                } else {
                  $_SESSION['u_email'] = $email; 
                  $_SESSION['notVerified'] = 'true';

                  $otp = random_int(100000, 999999);
                  $email = $_SESSION['u_email'];
                  $sql = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
                  $sql_query = mysqli_query($conn, $sql);
                  if($sql_query){
                    include('../send-mail.php');
                  }else{
                    $_SESSION['error'] = 'Error';
                  }
                  

                  echo '<script>';
                  echo '    document.addEventListener("DOMContentLoaded", function() {';
                  echo 'otpPopup();';
                  echo '    });';
                  echo '</script>';

                }
            } else {
                echo "Email Empty!";
            }
        } else {
            $emailError = "Email Does not Match!";
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($conn);
    }
    }
  }
    ?>

                
                
                  <form role="form" action="" method="post">
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email">
                    </div>

                    <p style="color: red;"><?php if(!empty($emailError)){echo $emailError;}?><p>
                    <div class="mb-3">
                      <input type="password" name="password" id = "password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                      <i class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                    
                    <p style="color: red;"><?php if(!empty($passwordError)){echo $passwordError;}?><p>
                  
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>

                  <!-- Main Form -->
                </div>

                
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="\dashboard\pages\sign-up.php" class="text-primary text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="otp-container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="otp-wrapper z-index-9" id="otp-wrapper">

            <div class="otp-body">

            <!-- Form Validation -->

            <?php 
              include_once('../database/config.php');
              $eror = "";
              $u_email = $_SESSION['u_email'];

              if (isset($_POST['verify'])) {
                $userOtp = $_POST['otp'];
            
                $sql = "SELECT * FROM users WHERE otp = '$userOtp'";
                
                $sql_query = mysqli_query($conn, $sql);
            
                if ($sql_query) {
                    $result = mysqli_fetch_array($sql_query, MYSQLI_ASSOC);
            
                    if ($result !== null && $result['otp'] == $userOtp) {
                        $verify = "UPDATE users SET verification = 1 WHERE otp = '$userOtp'";
                        $verify_query = mysqli_query($conn, $verify);
            
                        if ($verify_query) {
                            $_SESSION['verified'] = 'You are successfully Verified !';
                        } else {
                            $_SESSION['unverified'] = 'Failed to update verification status';
                            header("Location: sign-in.php");
                            exit();
                        }
                    } else {
                        $_SESSION['unverified'] = 'Failed to verify OTP';
                    }
                } else {
                    $_SESSION['unverified'] = 'Failed to execute the query';
                }
            }

            if(isset($_POST['resend'])){
              $otp = random_int(100000, 999999);
              $email = $_SESSION['s_email'];
              $sql = "UPDATE users SET otp = '$otp' WHERE email = '$email'";
              $sql_query = mysqli_query($conn, $sql);

              if($sql_query){
                include('../send-mail.php');
                $_SESSION['resendOk'] = 'OTP Resent !'; 
              }else{
                $_SESSION['resendError'] = 'OTP Resend Failed !';
              }

              
            }
            ?>


           


              <form role="form" action="sign-in.php" method="post">

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

  </main>







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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<?php
if(isset($_SESSION['verified']) && $_SESSION['verified'] != ""){

?>

<script>
Swal.fire({
text: "Successfully Verified",
icon: "success"
});

</script>
<?php
unset($_SESSION['verified']);
}







// var_dump($_SESSION['unverified']);
if(isset($_SESSION['unverified']) && $_SESSION['unverified'] != ""){

?>

<script>
Swal.fire({
text: "OTP Code doesnot match !",
icon: "error"
});
document.addEventListener("DOMContentLoaded", function() {

otpPopup();
});
</script>
<?php
unset($_SESSION['unverified']);
}



if(isset($_SESSION['notVerified']) && $_SESSION['notVerified'] != ""){

?>

<script>
Swal.fire({
text: "You are not verified yet. An OTP has been sent to your Email. Please verify to login !",
icon: "error"
});

</script>
<?php
unset($_SESSION['notVerified']);
}




if(isset($_SESSION['resendOk']) && $_SESSION['resendOk'] != ""){

?>

<script>
Swal.fire({
text: "An OTP has been sent to your Email !",
icon: "success"
});
// window.location.href = "sign-in.php";
document.addEventListener("DOMContentLoaded", function() {

otpPopup();
});

</script>
<?php
unset($_SESSION['resendOk']);
}





?>

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


<script>
        const togglePassword = document
            .querySelector('#togglePassword');
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