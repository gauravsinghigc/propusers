<div id='MainLoader'>
    <div class="preloader flex-column justify-content-center align-items-center" id="loader">
        <i class="fa fa-spinner fa-spin fs-100" id='loaderICON'></i>
    </div>
</div>
<script>
    window.onload = function() {
        document.getElementById("MainLoader").style.display = "none";
        document.getElementById("loaderICON").style.display = "none";
    }
</script>