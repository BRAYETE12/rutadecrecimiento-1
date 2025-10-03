<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX: true,
  paddingLeft:0,
  paddingRight:1
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, { 
  minGridDistance: 30, 
  minorGridEnabled: true
});

xRenderer.labels.template.setAll({
  rotation: -90,
  centerY: am5.p50,
  centerX: am5.p100,
  paddingRight: 15
});

xRenderer.grid.template.setAll({
  location: 1
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  maxDeviation: 0.3,
  categoryField: "country",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yRenderer = am5xy.AxisRendererY.new(root, {
  strokeOpacity: 0.1
})

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: yRenderer,
  min: 0, // Mínimo del eje Y
  max: 100 // Máximo del eje Y
}));

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  
  yAxis: yAxis,
  valueYField: "value",
  
  xAxis: xAxis,
  sequencedInterpolation: true,
  categoryXField: "country",  
  
  tooltip: am5.Tooltip.new(root, {
    labelText: "{etapa}: {valueY}"
  }), 
  
  
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
series.columns.template.adapters.add("fill", function (fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

series.columns.template.adapters.add("stroke", function (stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});


// Set data
var data = [

<?php $__currentLoopData = $company->diagnosticos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
{
  etapa: "<?php echo e($Diag->etapa?->name ?? ''); ?>",
  country: "<?php echo e($Diag->fecha_creacion->format('M - Y')); ?>",
  fecha: "<?php echo e($Diag->fecha_creacion); ?>",
  value: <?php echo e($Diag->resultado_puntaje); ?>

}, 
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
];

xAxis.data.setAll(data);
series.data.setAll(data);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>
<?php /**PATH D:\PROYECTOS\CamaraComercio\rutadecrecimiento\resources\views/website/company/barra_historicos_diagnosticos.blade.php ENDPATH**/ ?>