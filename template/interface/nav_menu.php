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
          <a class="nav-link nav-text" aria-current="page" href="/department/">Departments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-text" aria-current="page" href="/position/">Positions</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-text" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Guest
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end">
            <li><a class="dropdown-item" href="#">Login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">What are you looking at?</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br>

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
</script>
