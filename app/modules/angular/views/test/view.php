<?php
use dee\angular\Angular;

/* @var $this yii\web\View */
/* @var $angular Angular */
?>

<a href="#/">List</a><br>
<pre>
Id = {{id}}
Item = {{item | json}}
</pre>

<?php Angular::beginScript() ?>
<script>
$location = $injector.get('$location');
$routeParams = $injector.get('$routeParams');
Rest = $injector.get('Rest');

$scope.id = $routeParams.id;

$scope.item = Rest.get($scope.id);

</script>
<?php Angular::endScript();