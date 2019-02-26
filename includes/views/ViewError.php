<?php require_once 'ViewHeaderPart.php' ?>
    <section class="section has-background-light" style="height: calc(100vh - 305px);">
        <div class="columns">
            <div class="column is-half is-offset-one-quarter has-background-white">
                <h3 class="title">
                    Error
                </h3>
                <div class="content">
                    <p><?php echo params['data'] ?></p>
                    <a href="<?php echo BASEDIR ?>" class="button">Wróć</a>
                </div>
            </div>
        </div>
    </section>
<?php require_once 'ViewFooterPart.php' ?>