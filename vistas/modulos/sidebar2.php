<!--========== HEADER ==========-->
<header class="header">
    <div class="header__container">
        <img src="assets/img/perfil.jpg" alt="" class="header__img">
        
        <!-- <a href="#" class="header__logo">CURSOS UPA</a> -->

        <div class="header__search">
            <input type="search" placeholder="Search" class="header__input">
            <i class='fas fa-search header__icon'></i>
        </div>

        <div class="header__toggle">
            <i class='fas fa-bars' id="header-toggle"></i>
        </div>
    </div>
</header>

<!--========== NAV ==========-->
<div class="nav" id="navbar">
    <nav class="nav__container">
        <div>
            <a href="#" class="nav__link nav__logo">
                <img src="<?php echo $dominio; ?>vistas/img/rsc/logo UPA.svg" class='nav__icon mt-2' style="min-width: 40px;max-width:40px;margin-left:0rem">
                <!-- <i class='nav__icon'></i> -->
                <span class="nav__logo-name overflow-hidden" style="height: 24px;">Cursos UPA</span>
            </a>

            <div class="nav__list">
                <div class="nav__items">
                    <h3 class="nav__subtitle">Perfil</h3>

                    <!-- <a href="#" class="nav__link active">
                        <i class='fas fa-home nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a> -->

                    <div class="nav__dropdown">
                        <a class="nav__link">
                            <i class='fas fa-user nav__icon'></i>
                            <span class="nav__name">Inscritos</span>
                            <i class='fas fa-caret-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a class="nav__dropdown-item">Passwords</a>
                                <a class="nav__dropdown-item">Mail</a>
                                <a class="nav__dropdown-item">Accounts</a>
                            </div>
                        </div>
                    </div>

                    <a class="nav__link">
                        <i class='bx bx-message-rounded nav__icon'></i>
                        <span class="nav__name">Messages</span>
                    </a>
                </div>

                <div class="nav__items">
                    <h3 class="nav__subtitle">Menu</h3>

                    <div class="nav__dropdown">
                        <a href="#" class="nav__link">
                            <i class='bx bx-bell nav__icon'></i>
                            <span class="nav__name">Notifications</span>
                            <i class='bx bx-chevron-down nav__icon nav__dropdown-icon'></i>
                        </a>

                        <div class="nav__dropdown-collapse">
                            <div class="nav__dropdown-content">
                                <a href="#" class="nav__dropdown-item">Blocked</a>
                                <a href="#" class="nav__dropdown-item">Silenced</a>
                                <a href="#" class="nav__dropdown-item">Publish</a>
                                <a href="#" class="nav__dropdown-item">Program</a>
                            </div>
                        </div>

                    </div>

                    <a href="#" class="nav__link">
                        <i class='bx bx-compass nav__icon'></i>
                        <span class="nav__name">Explore</span>
                    </a>
                    <a href="#" class="nav__link">
                        <i class='bx bx-bookmark nav__icon'></i>
                        <span class="nav__name">Saved</span>
                    </a>
                </div>
            </div>
        </div>

        <a href="#" class="nav__link nav__logout">
            <i class='bx bx-log-out nav__icon'></i>
            <span class="nav__name">Log Out</span>
        </a>
    </nav>
</div>

<script src="<?php echo $dominio;?>vistas/js/sidebar2.js"></script>