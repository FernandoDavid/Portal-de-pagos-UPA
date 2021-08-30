<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!--<title> Responsive Sidebar Menu  | CodingLab </title>-->
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="upa-btn"><img src="<?php echo $dominio; ?>vistas/img/rsc/logo UPA.svg"></i>
            <!-- <i class='fas fa-home'></i> -->
            <span class="logo_name ms-3">Cursos UPA</span>
        </div>
        <!-- <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">Cursos UPA</div>
            <i class='bx bx-menu' id="btn"></i>
        </div> -->
        <ul class="nav-list p-0">
            <li>
                <a href="#">
                    <i class='fas fa-user-clock'></i>
                    <span class="links_name">Pendientes</span>
                </a>
                <span class="tooltip">Pendientes</span>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-user-check'></i>
                    <span class="links_name">Inscritos</span>
                </a>
                <span class="tooltip">Inscritos</span>
            </li>
            <li>
                <a href="#">
                    <i class='fas fa-bookmark'></i>
                    <span class="links_name">Cursos</span>
                </a>
                <span class="tooltip">Cursos</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="profile.jpg" alt="profileImg">
                    <div class="name_job">
                        <div class="name fw-bold">Fernando Arévalo</div>
                        <div class="job">Educación continua</div>
                    </div>
                </div>
                <i class='fas fa-sign-out-alt' id="log_out"></i>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <div class="text">Dashboard</div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".upa-btn");

        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();
        });

        // following are the code to change sidebar button(optional)
        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
            }
        }
    </script>
</body>

</html>