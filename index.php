<!doctypehtml>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Directorio - Personal</title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h1>Directorio - Personal</h1>
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="directorio";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
die("Conexión fallida: ".$conn->connect_error);
}
$results_per_page=5;
if(!isset($_GET['page'])){$page=1;}else{$page=$_GET['page'];}
$starting_limit_number=($page-1)*$results_per_page;
$where="activo='no' || activo='si'";
if(isset($_GET['search'])){
$search=$_GET['search'];
$where.=" AND (nombre LIKE '%$search%' OR correo LIKE '%$search%' OR dni LIKE '%$search%')";
}
$order_by="ID_user";
if(isset($_GET['order_by'])){$order_by=$_GET['order_by'];}
$order="ASC";
if(isset($_GET['order'])){$order=$_GET['order'];}
$sql_total="SELECT COUNT(*) as total FROM personal WHERE $where";
$result_total=$conn->query($sql_total);
$row_total=$result_total->fetch_assoc();
$total_results=$row_total['total'];
$total_pages=ceil($total_results/$results_per_page);
$sql_limit="SELECT ID_user, nombre, correo, dni, estado, ciudad, telefono, tipo, clasificacion, id_refe, activo FROM personal WHERE $where ORDER BY $order_by $order LIMIT $starting_limit_number, $results_per_page";
$result_limit=$conn->query($sql_limit);
if($result_limit->num_rows>0){
echo "<form method='get'>";
echo "<div class='form-group'>";
echo "<label for='search'>Buscar:</label>";
echo "<input type='text' name='search' id='search' value='".(isset($_GET['search'])?$_GET['search']:'')."' class='form-control'>";
echo "</div>";
echo "<button type='submit' class='btn btn-primary'>Buscar</button>";
echo "<a href='index.php' class='btn btn-secondary'>Volver</a>";
echo "</form>";
echo "<br>";
echo "<table class='table'>";
echo "<thead>";
echo "<tr>";
echo "<th><a href='index.php?order_by=ID_user&order=".($order_by=='ID_user'&&$order=='ASC'?'DESC':'ASC')."'>ID_user</a></th>";
echo "<th><a href='index.php?order_by=nombre&order=".($order_by=='nombre'&&$order=='ASC'?'DESC':'ASC')."'>Nombre</a></th>";
echo "<th><a href='index.php?order_by=correo&order=".($order_by=='correo'&&$order=='ASC'?'DESC':'ASC')."'>Correo</a></th>";
echo "<th><a href='index.php?order_by=dni&order=".($order_by=='dni'&&$order=='ASC'?'DESC':'ASC')."'>DNI</a></th>";
echo "<th><a href='index.php?order_by=$order_by'>Estado</a></th>";
echo "<th><a href='index.php?order_by=ciudad&order=".($order_by=='ciudad'&&$order=='ASC'?'DESC':'ASC')."'>Ciudad</a></th>";
echo "<th><a href='index.php?order_by=telefono&order=".($order_by=='telefono'&&$order=='ASC'?'DESC':'ASC')."'>Teléfono</a></th>";
echo "<th><a href='index.php?order_by=tipo&order=".($order_by=='tipo'&&$order=='ASC'?'DESC':'ASC')."'>Tipo</a></th>";
echo "<th><a href='index.php?order_by=clasificacion&order=".($order_by=='clasificacion'&&$order=='ASC'?'DESC':'ASC')."'>Clasificación</a></th>";
echo "<th>Referente</th>";
echo "<th>Activo</th>";
echo "<th>Acción</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
while($row_limit=$result_limit->fetch_assoc()){
echo "<tr>";
echo "<td>".$row_limit['ID_user']."</td>";
echo "<td>".$row_limit['nombre']."</td>";
echo "<td>".$row_limit['correo']."</td>";
echo "<td>".$row_limit['dni']."</td>";
echo "<td>".$row_limit['estado']."</td>";
echo "<td>".$row_limit['ciudad']."</td>";
echo "<td>".$row_limit['telefono']."</td>";
echo "<td>".$row_limit['tipo']."</td>";
echo "<td>".$row_limit['clasificacion']."</td>";
echo "<td>".$row_limit['id_refe']."</td>";
echo "<td>";
if($row_limit['activo']=='si'){
echo "<span class='badge badge-success'>Activo</span>";
}else{
echo "<span class='badge badge-danger'>Inactivo</span>";
}
echo "</td>";
echo "<td>";
echo "<button type='button' class='btn btn-danger'>Eliminar</button>";
echo "<button type='button' class='btn btn-primary'>Editar</button>";

echo "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "<nav aria-label='Page navigation example'>";
echo "<ul class='pagination'>";
echo "<li class='page-item ".($page==1?'disabled':'')."'><a class='page-link' href='index.php?page=".($page-1)."&search=".(isset($_GET['search'])?$_GET['search']:'')."&order_by=$order_by&order=$order'>Anterior</a></li>";
for($i=1;$i<=$total_pages;$i++){
echo "<li class='page-item ".($page==$i?'active':'')."'><a class='page-link' href='index.php?page=$i&search=".(isset($_GET['search'])?$_GET['search']:'')."&order_by=$order_by&order=$order'>$i</a></li>";
}
echo "<li class='page-item ".($page==$total_pages?'disabled':'')."'><a class='page-link' href='index.php?page=".($page+1)."&search=".(isset($_GET['search'])?$_GET['search']:'')."&order_by=$order_by&order=$order'>Siguiente</a></li>";
echo "</ul>";
echo "</nav>";
}else{
echo "<form method='get'>";
echo "<div class='form-group'>";
echo "<label for='search'>Buscar:</label>";
echo "<input type='text' name='search' id='search' value='".(isset($_GET['search'])?$_GET['search']:'')."' class='form-control'>";
echo "</div>";
echo "<button type='submit' class='btn btn-primary'>Buscar</button>";
echo "<a href='index.php' class='btn btn-secondary'>Volver</a>";
echo "</form>";
echo"<div class='alert alert-info' role='alert'>No se encontraron resultados.</div>";
}
$conn->close();
?></div></body></html>