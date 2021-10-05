    <script type="text/javascript">
      const currlocation = location.href;
      const navLinks = document.getElementsByClassName("side-link");
      for(let i = 0; i < navLinks.length; i++) {
        if(navLinks[i].href === currlocation) {
          navLinks[i].classList.add("active");
          if(navLinks[i].classList.contains("dropdown-item")) {
            navLinks[i].parentElement.parentElement.parentElement.children[0].classList.add("bg-primary", "text-white");
          }
        } 
      }
    </script>
    <!-- bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </body>
</html>