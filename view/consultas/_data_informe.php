<script type="text/javascript" src="js/jquery.min.js"></script>
<!--
<style type="text/css">
    ${demo.css}
</style>
-->
<script type="text/javascript">
    $(function () {
        Highcharts.data({
            csv: document.getElementById('tsv').innerHTML,
            itemDelimiter: '\t',
            parsed: function (columns) {

                var brands = {},
                        brandsData = [],
                        versions = {},
                        drilldownSeries = [];

                // Parse percentage strings
                columns[1] = $.map(columns[1], function (value) {
                    if (value.indexOf('%') === value.length - 1) {
                        value = parseFloat(value);
                    }
                    return value;
                });

                $.each(columns[0], function (i, name) {
                    var brand,
                            version;

                    if (i > 0) {

                        // Remove special edition notes
                        name = name.split(' -')[0];

                        // Split into brand and version
                        version = name.match(/([0-9]+[\.0-9x]*)/);
                        if (version) {
                            version = version[0];
                        }
                        brand = name.replace(version, '');

                        // Create the main data
                        if (!brands[brand]) {
                            brands[brand] = columns[1][i];
                        } else {
                            brands[brand] += columns[1][i];
                        }

                        // Create the version data
                        if (version !== null) {
                            if (!versions[brand]) {
                                versions[brand] = [];
                            }
                            versions[brand].push(['v' + version, columns[1][i]]);
                        }
                    }

                });

                $.each(brands, function (name, y) {
                    brandsData.push({
                        name: name,
                        y: y,
                        drilldown: versions[name] ? name : null
                    });
                });
                $.each(versions, function (key, value) {
                    drilldownSeries.push({
                        name: key,
                        id: key,
                        data: value
                    });
                });

                // Create the chart
                $('#container').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Browser market shares. November, 2013'
                    },
                    subtitle: {
                        text: 'Click the columns to view versions. Source: netmarketshare.com.'
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'Total percent market share'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.1f}%'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                    },
                    series: [{
                            name: 'Brands',
                            colorByPoint: true,
                            data: brandsData
                        }],
                    drilldown: {
                        series: drilldownSeries
                    }
                });
            }
        });
    });

</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"
<fieldset class="resport">
    <legend>Resultados de la Consulta</legend>
    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:900px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="50">Codigo</th>                
                <th align="center" width="220">Tema</th>
                <th align="center" width="60">Fecha</th>
                <th align="center" width="200">Expositor</th>
                <th align="center" width="60">Estado</th>                
            </tr>
        </thead>  
        <tbody>
            <?php
            if (count($rows) > 0) {
                $tc = count($rows);

                foreach ($rows as $i => $r) {

                    $fec = split('-', $r['fecha']);

                    switch ($r['estado']) {
                        case 0:
                            $est = '<p style="color:orange;font-weight: bold;">Falta Asignar</p>';
                            break;
                        //$e1++;
                        case 1:
                            $est = '<p style="color:red;font-weight: bold;">En Proceso</p>';
                            break;
                        //$e2++;
                        case 2:
                            $est = '<p style="color:green;font-weight: bold;">Finalizado</p>';
                            break;
                        //$e3++;                      
                    }
                    ?>
                    <tr class="tr-detalle" style="height: 21px;">
                        <td align="center"><?php echo (strtoupper($r['codigo'])); ?></td>
                        <td align="left"><?php echo (strtoupper($r['tema'])); ?></td>
                        <td align="center"><?php echo $fec[2] . "/" . $fec[1] . "/" . $fec[0]; ?></td>
                        <td><?php echo (strtoupper($r['expositor'])); ?></td> 
                        <td align="left">
                            <?php echo $est; ?>
                        </td>                                                       
                    </tr>                        
                    <?php
                }
                ?>

                <tr>
                    <td colspan="5">
                        <?php
                        $es1 = 0;
                        $es2 = 0;
                        $es3 = 0;
                        foreach ($rows as $i => $rs) {
                            if ($rs['estado'] == 0) {
                                $es1++;
                            }
                            if ($rs['estado'] == 1) {
                                $es2++;
                            }
                            if ($rs['estado'] == 2) {
                                $es3++;
                            }
                            /* switch ($rs['estado']) {
                              case 0:
                              $es1++;
                              case 1:
                              $es2++;
                              case 2:
                              $es3++;
                              } */
                        }
                        ?>
                        <label for="dni" class="labeless">Total de cap.:</label><?php echo $tc; ?><br/>
                        <label for="dni" class="labeless">Cap. Asignada:</label><?php echo $es1; ?><br/>
                        <label for="dni" class="labeless">Cap. en Proc.:</label><?php echo $es2; ?><br/>
                        <label for="dni" class="labeless">Cap. Finaliz.:</label><?php echo $es3; ?><br/>
                    </td>
                </tr>                     
                <?php
            }
            ?>                      
        </tbody>
        <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

        </tfoot>
    </table>

</fieldset>
<br />
<br />