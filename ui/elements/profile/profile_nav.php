<header class="nav-wrapper" style=";">
        <span class="left-shit" style="color: #757575; font-size: 24px; font-weight: bold; ">
            <a id="menu-icon" class="sidenav-trigger" style="cursor: pointer;"><i class="material-icons" style="vertical-align: middle; margin-bottom: 2px; color: black;">menu</i></a>
            &nbsp;&nbsp; Loogle+  <?php if (isset($_GET['username'])) { echo "| " . htmlspecialchars($_GET['username']); } ?>
        </span>
        <span class="current-user">Username: <?php echo $_SESSION['username']; ?></span>
</header>
