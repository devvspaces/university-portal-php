<!-- Side bar -->
<nav>
    <!-- image -->
    <div class="logo">
        <img src="../assets/images/techu_logo.png" alt="logo" class="img-fluid">
    </div>

    <!-- nav box -->
    <div class="nav-box">

        <!-- nav list -->
        <ul class="nav-list">

            <?php foreach ($nav_items as $item) { ?>
                <li class="nav-item">
                    <a href="<?= $item['link'] ?>" class="nav-link <?= $item['name'] == $title ? 'active' : '' ?>">
                        <span class="icon"><i data-feather="<?= $item['icon'] ?>"></i></span>
                        <span><?= $item['name'] ?></span>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </div>
</nav>
