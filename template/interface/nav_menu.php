<?php
if (isset($_SESSION['userrole']) && $_SESSION['userrole'] === "admin") {
    $username = $_SESSION['username'];
    $sql = "SELECT admin_username, admin_password FROM administrator WHERE admin_username = ?";
} elseif (isset($_SESSION['userrole']) && $_SESSION['userrole'] === "instructor") {
    $username = $_SESSION['username'];
    $sql = "SELECT i_username, i_password FROM instructor WHERE i_username = ?";
} else {
    $username = "Guest";
    $sql = "";
}

if(isset($_SESSION['userrole'])){
  if($_SESSION['userrole'] === "admin"){
?>

<nav class="navbar navbar-expand-lg" style="background-color: #FF9933;">
  <div class="container-fluid">
    <a class="navbar-brand nav-text" href="/home/">Natadee School</a>
    <p class="nav-text mb-lg-0 me-2">
    <?php
    if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] === "admin") {
        echo "(Admin)";
    } elseif (isset($_SESSION["userrole"]) && $_SESSION["userrole"] === "instructor") {
        echo "(Instructor)";
    } else {
        echo "(Guest)";
    }
    ?></p>
    <a href="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?&enablejsapi=1&autoplay=1">
            <div class="marquee-container">
                <marquee scrollamount="3" behavior="scroll" direction="left">
                    <span id="quoteOfTheDay" style="display: inline-block;">Loading...</span>
                </marquee>
            </div>
        </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/department/">Departments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/position/">Positions</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/instructor/">Insturctors</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/award/">Awards</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/classroom/">Classrooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/student/">Students</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $username; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="#">Preference</a></li>
            <li>
              <a class="dropdown-item" href="#" id="btn-logout">Logout</a>
              <form id="logout-form" action="/php/sql/sql_authen.php" method="POST" style="display: none;">
                <input type="hidden" name="operation" value="logout">
              </form>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="quote_update">What are you looking at?</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>
<script>
  ajaxFormButton("logout-form", "btn-logout");
</script>

<?php
  }else if ($_SESSION['userrole'] === "instructor"){
?>

<nav class="navbar navbar-expand-lg" style="background-color: #FF9933;">
  <div class="container-fluid">
    <a class="navbar-brand nav-text" href="/home/">Natadee School</a>
    <p class="nav-text mb-lg-0 me-2">
    <?php
    if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] === "admin") {
        echo "(Admin)";
    } elseif (isset($_SESSION["userrole"]) && $_SESSION["userrole"] === "instructor") {
        echo "(Instructor)";
    } else {
        echo "(Guest)";
    }
    ?></p>
    <a href="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?&enablejsapi=1&autoplay=1">
            <div class="marquee-container">
                <marquee scrollamount="3" behavior="scroll" direction="left">
                    <span id="quoteOfTheDay" style="display: inline-block;">Loading...</span>
                </marquee>
            </div>
        </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/user/award/">Awards</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php $sql_usr = "SELECT i_name FROM instructor WHERE i_username = '$username'";
            $result_usr = mysqli_execute_query($conn ,$sql_usr);
            $rs_usr = mysqli_fetch_array($result_usr);
            echo $rs_usr['i_name']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="/user/edit/">Preference</a></li>
            <li>
              <a class="dropdown-item" href="#" id="btn-logout">Logout</a>
              <form id="logout-form" action="/php/sql/sql_authen.php" method="POST" style="display: none;">
                <input type="hidden" name="operation" value="logout">
              </form>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="quote_update">What are you looking at?</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>
<script>
  ajaxFormButton("logout-form", "btn-logout");
</script>
<?php
  }
} else {
?>

<nav class="navbar navbar-expand-lg" style="background-color: #FF9933;">
  <div class="container-fluid">
    <a class="navbar-brand nav-text" href="/">Natadee School</a>
    <p class="nav-text mb-lg-0">(Guest)&ensp;</p>
    <a href="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?&enablejsapi=1&autoplay=1">
            <div class="marquee-container">
                <marquee scrollamount="3" behavior="scroll" direction="left">
                    <span id="quoteOfTheDay" style="display: inline-block;">Loading...</span>
                </marquee>
            </div>
        </a>
    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-text rainbow-text" aria-current="page" href="/home/">Free&nbsp;Robux</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/guest/instructor/">Instructor</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/guest/student/">Student</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Guest
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="/login/">Login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="quote_update">What are you looking at?</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>

<?php
}
?>

<!-- JavaScript (AJAX) -->
<script>
    function fetchLatestQuote() {
        // Send an AJAX request to fetch the latest quote from the PHP script
        fetch('/php/ajax/quote_ajax.php')
            .then(response => response.json())
            .then(data => {
                const quote = data.quote;
                document.getElementById('quoteOfTheDay').textContent = quote;
            })
            .catch(error => {
                console.error('Error fetching the latest quote:', error);
            });
    }

    // Function to be called when the marquee animation has finished one loop
    function onMarqueeLoopEnd() {
        // Fetch the latest quote when the marquee loop ends
        fetchLatestQuote();
    }

    // Fetch the latest quote initially when the page loads
    fetchLatestQuote();

    // Fetch the latest quote when the marquee loop ends
    const marquee = document.getElementById('quoteOfTheDay');
    marquee.addEventListener('animationiteration', onMarqueeLoopEnd);

    // Fetch the latest quote every 30 seconds (adjust the interval as needed)
    setInterval(fetchLatestQuote, 30000);
    
document.getElementById("quote_update").addEventListener("click", function(event) {
    event.preventDefault();
    <?php if (isset($_SESSION["userrole"]) && $_SESSION["userrole"] === "admin"): ?>
        try {
            swal_input("Quote Update", "Update quote of the day", "New quote", "Update", "Cancel", (confirmed, value) => {
                if (confirmed) {
                    const dataToSend = {
                        operation: "update",
                        quote: value
                    };

                    ajaxData("/php/sql/sql_quote.php", dataToSend, (data) => {
                        if (data.status === "success") {
                            console.log(data);
                        } else {
                            console.error(data);
                        }
                    });
                }
            });
        } catch (error) {
            console.error("Error in swal_input:", error);
        }
    <?php else: ?>
        swal_alert("Tf are you doing?", "yOu aRe nOt eliGiBle tO uSe tHis fEaTuRe dUmBAsS", "error", "Sorry, I'm an idiot sandwich.");
    <?php endif; ?>
});
</script>
