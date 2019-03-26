<div class="container">
    <ul class="pagination justify-content-center pagination-sm">
        <?php for($x=1; $x<=$numPages; $x++): ?>
            <li class="page-item <?php if(
                    (isset($_GET['page']) && $x == $_GET['page']) ||
                    (!isset($_GET['page']) && $x == 1)){
                    echo "active";
                } ?>">
                <a class="page-link" href="?page=<?php echo $x; ?>">
                    <?php echo $x; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</div>