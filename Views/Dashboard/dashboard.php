<?php headerAdmin($data); ?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i><?= TITLE_ADMIN ?> - <?= $data['rol-personal'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/dashboard/"> Panel Administrativo</a></li>
        </ul>
    </div>
    <div class="row">
        <?php if ($data['rol-personal'] == "Jefa" || ($data['rol-personal'] == "Contador Auditor" || $data['rol-personal'] == "Administrador de Empresas")) { ?>
            <div class="col-md-6 col-lg-3">
                <div class="linkw">
                    <div class="widget-small primary coloured-icon"><i class="icon fas fa-money-bill-wave fa-3x"></i>
                        <div class="info">
                            <h4>Ganancias</h4>
                            <p><b><?= SMONEY . formatMoney($data["ganancias"]) ?></b></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($data['rol-personal'] == "Jefa") { ?>
            <div class="col-md-6 col-lg-3">
                <div class="linkw">
                    <div class="widget-small info coloured-icon"><i class="icon fa fa fa-user fa-3x"></i>
                        <div class="info">
                            <h4>Clientes</h4>
                            <p><b><?= $data["clientes"] ?></b></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($data['rol-personal'] == "Jefa" || $data['rol-personal'] == "Analista-financiero") { ?>
            <div class="col-md-6 col-lg-3">
                <div class="linkw">
                    <div class="widget-small warning coloured-icon"><i class="icon fa fa fa-archive fa-3x"></i>
                        <div class="info">
                            <h4>Productos</h4>
                            <p><b><?= $data["productos"] ?></b></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-6 col-lg-3">
            <div class="linkw">
                <div class="widget-small danger coloured-icon"><i class="icon fa fa-shopping-cart fa-3x"></i>
                    <div class="info">
                        <h4>Pedidos</h4>
                        <p><b><?= $data["pedidos"] ?></b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Productos mas preferidos</h3>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($data['preferidos']) > 0) {
                            foreach ($data['preferidos'] as $prod) {
                                $rutaProducto = $prod["rutaPro"];
                                ?>
                                <tr>
                                    <td><?= $prod['nombrePro'] ?></td>
                                    <td><?= $prod['categoria'] ?></td>
                                    <td><?= SMONEY . formatMoney($prod['precioPro']) ?></td>
                                    <td><a href="<?= base_url() . '/tienda/producto/' . $prod['idproducto'] . '/' . $rutaProducto; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Tipo de pagos</h3>
                    <div class="dflex">
                        <input class="date-picker pagoMes" name="pagoMes" placeholder="Mes y Año"/>
                        <button type="button" class="btnTipoVentaMes btn btn-info btn-sm" onclick="fntSearchPagos()"> <i class="fas fa-search"></i> </button>
                    </div>
                </div>
                <div id="pagosMesAnio"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title"><?= $data["titleGrafica01"] ?></h3>
                </div>
                <div id="<?= $data["idGrafica01"] ?>"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title"><?= $data["titleGrafica02"] ?></h3>
                </div>
                <div id="<?= $data["idGrafica02"] ?>"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Ultimas Ventas facturadas en el Mes</h3>
                    <div class="dflex">
                        <input class="date-picker ventasMes" name="ventasMes" placeholder="Mes y Año">
                        <button type="button" class="btnVentasMes btn btn-info btn-sm" onclick="fntSearchVMes()"> <i class="fas fa-search"></i> </button>
                    </div>
                </div>
                <div id="graficaMes"></div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <div class="container-title">
                    <h3 class="tile-title">Ventas Acumuladas por año</h3>
                    <div class="dflex">
                        <input class="ventasAnio" name="ventasAnio" placeholder="Año" minlength="4" maxlength="4" onkeypress="return controlTag(event);">
                        <button type="button" class="btnVentasAnio btn btn-info btn-sm" onclick="fntSearchVAnio()"> <i class="fas fa-search"></i> </button>
                    </div>
                </div>
                <div id="graficaAnio"></div>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>

<script>
    Highcharts.chart('pagosMesAnio', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Tipos de pago usados en <?= $data['pagosMes']['mes'] . ' del ' . $data['pagosMes']['anio'] ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
                name: 'Porcentaje',
                colorByPoint: true,
                data: [
<?php
foreach ($data['pagosMes']['tipospago'] as $pagos) {
    echo "{name:'" . $pagos['nombrePago'] . "',y:" . $pagos['total'] . "},";
}
?>
                ]
            }]
    });

    Highcharts.chart('graficaMes', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Ventas de <?= $data['ventasMDia']['mes'] . ' del ' . $data['ventasMDia']['anio'] ?>'
        },
        subtitle: {
            text: 'Total de las Ventas <?= SMONEY . '. ' . formatMoney($data['ventasMDia']['total']) ?> '
        },
        xAxis: {
            categories: [
<?php
foreach ($data['ventasMDia']['ventas'] as $dia) {
    echo $dia['dia'] . ",";
}
?>
            ]
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
                name: 'Ventas Acumuladas',
                data: [
<?php
foreach ($data['ventasMDia']['ventas'] as $dia) {
    echo $dia['total'] . ",";
}
?>
                ]
            }]
    });

    Highcharts.chart('graficaAnio', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Ventas del año <?= $data['ventasAnio']['anio'] ?> '
        },
        subtitle: {
            text: 'Estadística de las ventas por mes'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Ventas de este mes : <b>${point.y:.1f}</b>'
        },
        series: [{
                name: 'Ventas',
                data: [
<?php
foreach ($data['ventasAnio']['meses'] as $mes) {
    echo "['" . $mes['mes'] . "'," . $mes['venta'] . "],";
}
?>
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
    });

</script>