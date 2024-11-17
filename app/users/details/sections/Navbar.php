<ul class="contact-info">
    <?php foreach (MENU as $Menu) {
        $Active = IfRequested("GET", "get", "Main Dashboard", false);
        if ($Active == $Menu) {
            $Active = "active";
        } else {
            $Active = "";
        } ?>
        <li class="text-left <?php echo $Active; ?>">
            <a href="?get=<?php echo $Menu; ?>"><?php echo $Menu; ?></a>
        </li>
    <?php } ?>
</ul>