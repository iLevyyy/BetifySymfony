<?php 

$cancion1vd3 = $_POST["cancion1vd3"];
$cancion1vd2 = $_POST["cancion1vd2"];
$cancion1vd1 = $_POST["cancion1vd1"];
$cancion1vd0 = $_POST["cancion1vd0"];

$cancion2vd3 = $_POST["cancion2vd3"];
$cancion2vd2 = $_POST["cancion2vd2"];
$cancion2vd1 = $_POST["cancion2vd1"];
$cancion2vd0 = $_POST["cancion2vd0"];

$diferenciaVisitasDia3 = $cancion1vd3 - $cancion2vd3;
$diferenciaVisitasDia2 = $cancion1vd2 - $cancion2vd2;
$diferenciaVisitasDia1 = $cancion1vd1 - $cancion2vd1;
$diferenciaVisitasDia0 = $cancion1vd0 - $cancion2vd0;

$dvt = $diferenciaVisitasDia3 + $diferenciaVisitasDia2 + $diferenciaVisitasDia1 + $diferenciaVisitasDia0;


//Pendiente == Tasa de crecimiento

$pendientePonderadaCancion1 = pendiente($cancion1vd2,$cancion1vd3)*0.6 + pendiente($cancion1vd1,$cancion1vd2)*0.75 +pendiente($cancion1vd0,$cancion1vd1)*0.9;
$pendientePonderadaCancion2 = pendiente($cancion2vd2,$cancion2vd3)*0.6 + pendiente($cancion2vd1,$cancion2vd2)*0.75 +pendiente($cancion2vd0,$cancion2vd1)*0.9;

$pendienteSinPonderarCancion1 =  pendiente($cancion1vd2,$cancion1vd3) + pendiente($cancion1vd1,$cancion1vd2) +pendiente($cancion1vd0,$cancion1vd1);
$pendienteSinPonderarCancion2 = pendiente($cancion2vd2,$cancion2vd3) + pendiente($cancion2vd1,$cancion2vd2) +pendiente($cancion2vd0,$cancion2vd1);

$relacionSinPonderarEntrePendientes = $pendienteSinPonderarCancion1/$pendienteSinPonderarCancion2;
$relacionPonderadaEntrePendientes = $pendientePonderadaCancion1/$pendientePonderadaCancion2;

$relacionCrecimientoDia3 = $cancion1vd3/$cancion2vd3;
$relacionCrecimientoDia2 = $cancion1vd2/$cancion2vd2;
$relacionCrecimientoDia1 = $cancion1vd1/$cancion2vd1;
$relacionCrecimientoDia0 = $cancion1vd0/$cancion2vd0;


echo("La cancion A ha crecido ponderadamente sobre la cancion B un: ".$relacionPonderadaEntrePendientes."<br>");
echo("La cancion A ha crecido sin ponderar (crecimiento real) sobre la cancion B un: ".$relacionSinPonderarEntrePendientes."<br>");

//La variable de arriba nace de las 4 siguientes
echo("El dia -3, la cancion A tuvo ".$relacionCrecimientoDia3." visitas"." por cada visita de la cancion B". "<br>");
echo("El dia -2, la cancion A tuvo ".$relacionCrecimientoDia2." visitas"." por cada visita de la cancion B". "<br>");
echo("El dia -1, la cancion A tuvo ".$relacionCrecimientoDia1." visitas"." por cada visita de la cancion B". "<br>");
echo("El dia -0, la cancion A tuvo ".$relacionCrecimientoDia0." visitas"." por cada visita de la cancion B". "<br>");

$relacionCrecimientoTotalCancion1 = $cancion1vd0/$cancion1vd3;
$relacionCrecimientoTotalCancion2 = $cancion2vd0/$cancion2vd3;

echo("La cancion 1/A ha ha tenido una tasa de crecimiento de: ".$relacionCrecimientoTotalCancion1."<br>");
echo("La cancion 2/B ha ha tenido una tasa de crecimiento de: ".$relacionCrecimientoTotalCancion2."<br>");

//Si este numero es negativo, significa que la cancion B ha tenido mas visitas en los ultimos 3 dias
$diferenciaVisitasTotal = $diferenciaVisitasDia0 - $diferenciaVisitasDia3; 

echo("En total, la diferencia de visitas de la cancion A respecto a la cancion B se ha visto alterada en: ".$diferenciaVisitasTotal."<br>");
echo("La diferencia de visitas restante/actual es de: ".$diferenciaVisitasDia0."<br>");
//$cuota = $relacionPonderadaEntrePendientes

$cuota =  $diferenciaVisitasDia0/ $diferenciaVisitasTotal * $relacionPonderadaEntrePendientes;

echo("Cuota de que la cancion A es superada por la cancion B: ".$cuota);

//Esta funcion es especifica a este contexto, ya que de ser un punto real, debería ser un array con dos valores
//Sin embargo, como la diferencia en el eje X siempre es de 1 dia, la operacion se puede simplificar a una sencilla resta
//La función no es necesaria, pero esta implementada para genera unas formulas mas legibles
function pendiente($punto1, $punto2 ){ 
    return($punto2-$punto1);
}
function isPositive($num1, $num2) {
    return ($num1 - $num2 < 0) ? true : false;
}