<?php require_once 'ViewHeaderPart.php' ?>
<section class="section has-background-light" style="min-height: calc(100vh - 305px);">
    <div class="columns is-centered">
        <div class="column is-full-tablet is-two-thirds-desktop has-background-white">
            <div class="ct-chart ct-perfect-fourth"></div>
        </div>
    </div>

</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/chartist/0.11.0/chartist.min.js"></script>
<script>
    let data = {
        labels: <?php echo json_encode(params['array']['labels'], JSON_NUMERIC_CHECK); ?>,
        series: <?php echo json_encode(params['array']['series'], JSON_NUMERIC_CHECK); ?>
    };
    let options = {
        labelInterpolationFnc: function(value) {
            return value[0]
        }
    };

    let responsiveOptions = [
        ['screen and (min-width: 640px)', {
            chartPadding: 30,
            labelOffset: 100,
            labelDirection: 'explode',
            labelInterpolationFnc: function(value) {
                return value;
            }
        }],
        ['screen and (min-width: 1024px)', {
            labelOffset: 80,
            chartPadding: 20
        }]
    ];
    new Chartist.Pie('.ct-chart', data, options, responsiveOptions);
</script>
<?php require_once 'ViewFooterPart.php' ?>
