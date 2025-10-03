
<?php $__env->startSection('title','Ruta C Dashboard'); ?>
<?php $__env->startSection('description',''); ?>

<?php $__env->startSection('content'); ?>

<div class="c-dashboard">
    <?php echo $__env->make('website.layouts.header_company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main>
        <div id="dashboard" class="container">

            <div class="p-3 shadow bg-white mt-3">
                <div class="row">
                    <div class="col col-md">

                        <div class="company-card text-center p-3">
                            <div class="card-body">
                                <img height="100" style="margin: 0 auto;"
                                    src="
                                        <?php if(!empty($unidadProductiva->logo)): ?>
                                           <?php echo e(asset( $unidadProductiva->logo)); ?>

                                        <?php else: ?>
                                            <?php if($unidadProductiva->unidadtipo_id == 1): ?>
                                                https://rutadecrecimiento.com/img/registro/idea_negocio.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 2): ?>
                                                https://rutadecrecimiento.com/img/registro/informal_negocio_en_casa.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 3): ?>
                                                https://rutadecrecimiento.com/img/registro/registrado_fuera_ccsm.png
                                            <?php elseif($unidadProductiva->unidadtipo_id == 4): ?>
                                                https://rutadecrecimiento.com/img/registro/registrado_ccsm.png
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    " 
                                    class="company-image" alt="Imagen de la empresa">
                        
                            
                                <h5 class="card-title pt-4"> <b><?php echo e($unidadProductiva->business_name); ?></b> </h5>
                                <p class="card-text">NIT: <?php echo e($unidadProductiva->nit); ?></p>
                            </div>
                        </div>

                    </div>
                    <div class="col col-md-8 d-flex align-items-center">
                        <div class="w-100" >

                            <div audio-tag="info_program_info" >
                                <h3>
                                    <b>Tablero de indicadores</b>
                                </h3>
    
                                <hr class="my-4" >
                                <p class="desc">
                                    
                                </p>
    
                            </div>

                            <?php echo $__env->make('website.layouts.button_audio', ['target' => 'info_program_info'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
                    </div>
                </div>
            </div>

            <?php for($i = 0; $i < count($datasets); $i++): ?>
            <div class="p-3 shadow bg-white mt-3">

                <div class="row d-flex ">
                    <div class="col col-md-8">
                        <h3 class="text-start fw-bold p-2" style="font-size: 1.3rem;">
                            <?php echo e($datasets[$i]['label']); ?>

                        </h3>
                    </div>
                    <div class="col col-md-4">
                        <div class="form-group">
                            <select onchange="cambiarGrafica(<?php echo e($i); ?>)" id="selectorChart<?php echo e($i); ?>" class="form-control">
                                <option value="bar">Tipo de gráfico: Barras</option>
                                <option value="horizontalBar">Tipo de gráfico: Barras Horizontales</option>
                                <option value="line">Tipo de gráfico: Líneas</option>
                                <option value="area">Tipo de gráfico: Área</option>
                                <option value="pie">Tipo de gráfico: Pastel</option>
                                <option value="doughnut">Tipo de gráfico: Dona</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr class="my-2">

                <div class="d-flex justify-content-center">
                    <div class="w-75 mt-5">
                        <canvas id="myChart<?php echo e($i); ?>" width="400" height="300"></canvas>
                    </div>
                </div>

            </div>
            <?php endfor; ?>

        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>

    Chart.register(ChartDataLabels);

    const colors = [
        { fill: 'rgba(52,152,219,0.5)', border: 'rgb(52,152,219)' },   // Azul
        { fill: 'rgba(46,204,113,0.5)', border: 'rgb(46,204,113)' },   // Verde
        { fill: 'rgba(231,76,60,0.5)', border: 'rgb(231,76,60)' },     // Rojo
        { fill: 'rgba(241,207,119,0.5)', border: 'rgb(241,207,119)' }, // Amarillo claro
        { fill: 'rgba(240,188,108,0.5)', border: 'rgb(240,188,108)' }, // Naranja suave
        { fill: 'rgba(236,144,103,0.5)', border: 'rgb(236,144,103)' }, // Salmón
        { fill: 'rgba(233,111,137,0.5)', border: 'rgb(233,111,137)' }, // Rosa intenso
        { fill: 'rgba(215,167,87,0.5)', border: 'rgb(215,167,87)' },   // Mostaza
        { fill: 'rgba(199,203,212,0.5)', border: 'rgb(199,203,212)' }   // Gris claro
    ];

    // Datos iniciales
    const data = {
        labels: <?php echo json_encode($labels); ?>,
        datasets: <?php echo json_encode($datasets); ?>

    };

    let configInit = {
        type: 'bar',
        data: [],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            elements: { bar: { borderWidth: 2 } },
            layout: { padding: 20 },
            plugins: {
                legend: { display: false, position: 'top' },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 11
                    },
                    formatter: (value) => value // Muestra el valor tal cual
                }
            },
            scales: {
                x: { title: { display: true, text: 'Fechas' } },
                y: { title: { display: true, text: 'Valores' }, beginAtZero: true },
            }
        }
    };

    let charts = {};

    // Función para cambiar el tipo de gráfico
    function cambiarGrafica(index) {

        const selectedType = $("#selectorChart"+index).val();
        const config = JSON.parse(JSON.stringify(configInit));

        data.datasets[index].backgroundColor = data.datasets[index].data.map((_, i) => colors[i % colors.length].fill);
        data.datasets[index].borderColor = data.datasets[index].data.map((_, i) => colors[i % colors.length].border);
        data.datasets[index].borderWidth = 2;

        data.datasets[index]

        config.data = {
            labels: data.labels,
            datasets: [JSON.parse(JSON.stringify(data.datasets[index]))]
        };

        if(charts[index] != null)
        {
            charts[index].destroy();
            charts[index] = null;
        }
      
        delete config.options.indexAxis;
        config.data.datasets.forEach(dataset => delete dataset.fill);

        config.options.scales.y.suggestedMax = Math.max(...config.data.datasets[0].data) * 1.2;

        if (selectedType === 'horizontalBar') {
            config.type = 'bar';
            let x = config.options.scales.x.title.text;
            config.options.scales.x.title.text = config.options.scales.y.title.text;
            config.options.scales.y.title.text = x;
            config.options.indexAxis = 'y';
        } else if (selectedType === 'area') {
            config.type = 'line';
            config.data.datasets.forEach(dataset => dataset.fill = true);
        } else {
            config.type = selectedType;
        }

        if(charts[index] == null)
        {
            charts[index] = new Chart($("#myChart"+index), config);
        }
    }

    <?php for($i = 0; $i < count($datasets); $i++): ?>
        cambiarGrafica(<?php echo e($i); ?>);
    <?php endfor; ?>
</script>

<style>
    #myChart { margin: 0 auto; }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('website.layouts.main_dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/indicadores.blade.php ENDPATH**/ ?>