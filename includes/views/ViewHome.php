<?php require_once 'ViewHeaderPart.php' ?>
<section class="section has-background-light" style="height: calc(100vh - 305px);">
    <div class="columns">
        <div class="column is-half is-offset-one-quarter has-background-white">
            <div class="content">
                <p>Wybierz plik <code>.csv</code> na podstawie którego chcesz stworzyć wykres.</p>
            </div>

            <form action="upload" method="post" enctype="multipart/form-data">
                <div class="field is-grouped">
                    <div class="control file">
                        <label class="file-label">
                            <input class="file-input" type="file" name="file" id="file" required>
                            <span class="file-cta">
                              <span class="file-icon">
                                <i class="fas fa-upload"></i>
                              </span>
                              <span class="file-label" id="filename">
                                Wybierz plik
                              </span>
                            </span>
                        </label>
                    </div>
                    <div class="control">
                        <input type="submit" class="button is-info">
                    </div>

                </div>
            </form>
        </div>
    </div>

</section>
<script>
    (function () {
        let file = document.getElementById("file");
        file.onchange = function() {
            if(file.files.length > 0) {
                document.getElementById('filename').innerHTML = file.files[0].name;
            }
        };
    })();
</script>
<?php require_once 'ViewFooterPart.php' ?>
