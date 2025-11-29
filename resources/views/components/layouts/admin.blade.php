<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/assets/img/favicon.png" rel="icon">
  <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <style>
  /* Mode gelap */
body[data-bs-theme="dark"] {
  background-color: #121212;
  color: #f1f1f1;
}

/* Navbar dan sidebar */
body[data-bs-theme="dark"] .header,
body[data-bs-theme="dark"] .sidebar {
  background-color: #1e1e1e;
}

body[data-bs-theme="dark"] .card,
body[data-bs-theme="dark"] .dropdown-menu {
  background-color: #222;
  color: #fff;
}
</style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block fa-solid fa-masks-theater">IslamIQ</span>
        </a>
        <li class="nav-item">
            <button id="themeToggle" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-moon"></i>
            </button>
        </li>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- Avatar dynamic admin -->
                    <img src="{{ Auth::user()->avatar_url }}" 
                         alt="Profile" 
                         class="rounded-circle"
                         style="width: 36px; height: 36px; object-fit: cover;">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>Administrator</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-admin">
                            @csrf
                        </form>
                        <a class="dropdown-item d-flex align-items-center" href="#" 
                           onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

  </header>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

     <!-- End Dashboard Nav -->
<li class="nav-item">
  <a wire:navigate class="nav-link collapsed" href="/admin/dashboard">
    <i class="bi bi-speedometer2"></i>
    <span>Dashboard</span>
  </a>
</li>

<li class="nav-item">
  <a wire:navigate class="nav-link collapsed" href="/admin/daftar-kuis">
    <i class="bi bi-question-circle"></i>
    <span>Daftar Kuis</span>
  </a>
</li>

<li class="nav-item">
    <a wire:navigate class="nav-link collapsed" href="/admin/learning-contents">
        <i class="bi bi-journal-text"></i>
        <span>Materi</span>
    </a>
</li>

<li class="nav-item">
  <a wire:navigate class="nav-link collapsed" href="/admin/tentang">
    <i class="bi bi-info-circle"></i>
    <span>Tentang</span>
  </a>
</li>

      
      </li><!-- End Icons Nav -->

     

  </aside><!-- End Sidebar-->

    <main id="main" class="main-content">
    {{ $slot }}
</main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>IslamIQ</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      <a class="fa-solid fa-masks-theater">Design by Ibad</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor/chart.js/chart.min.js"></script>
  <script src="/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/assets/vendor/quill/quill.min.js"></script>
  <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="/assets/js/main.js"></script>

  <!-- mode gelap dan mode terang -->
   <script>
  // Cek tema yang tersimpan
  const currentTheme = localStorage.getItem("theme") || "light";
  document.body.dataset.bsTheme = currentTheme;

  const toggleBtn = document.getElementById("themeToggle");
  const icon = toggleBtn.querySelector("i");

  // Ubah ikon sesuai tema saat ini
  if (currentTheme === "dark") {
    icon.classList.remove("bi-moon");
    icon.classList.add("bi-sun");
  }

  toggleBtn.addEventListener("click", () => {
    const isDark = document.body.dataset.bsTheme === "dark";
    document.body.dataset.bsTheme = isDark ? "light" : "dark";
    localStorage.setItem("theme", isDark ? "light" : "dark");

    // Ubah ikon
    icon.classList.toggle("bi-moon", isDark);
    icon.classList.toggle("bi-sun", !isDark);
  });
</script>

</body>

</html>