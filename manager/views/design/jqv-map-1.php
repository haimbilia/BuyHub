
 <!--START MAP-->

<link href="dist/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="dist/jquery.vmap.js"></script>
<script type="text/javascript" src="dist/maps/jquery.vmap.world.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.vmap.sampledata.js"></script>



<script>
      jQuery(document).ready(function () {
        jQuery('#vmap').vectorMap({
          map: 'world_en',
          backgroundColor: '#fff',
          color: '#ffffff', 
          hoverOpacity: 0.7,
          selectedColor: '#666666',
          enableZoom: true,
          showTooltip: true,
          scaleColors: ['#C8EEFF', '#006491'],
          values: sample_data,
          normalizeFunction: 'polynomial'
        });
      });
    </script>




    <div id="vmap" style="width: 600px; height: 400px;"></div>

    <!--END MAP--->

    