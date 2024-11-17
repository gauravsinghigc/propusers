<div class="col-md-9">
    <?php if (isset($_GET['get'])) {
        $Views = $_GET['get'];

        //load relative views
        foreach (MENU as $key => $Values) {
            if ($Values == $Views) {
                include "views/$key";
            }
        }

        //load default views or dashboard
    } else {
        include "views/dashboard.php";
    } ?>
</div>