<?php
$db="";
require_once 'db.php';


$result=$db->query("SELECT * FROM darbuotojai");
$employees=$result->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['delete'])){
    $stm=$db->prepare("DELETE FROM `darbuotojai` WHERE id=?");
    $stm->execute([$_GET['delete']]);
}

$result2=$db->query("SELECT * FROM positions");
$employees2=$result2->fetchAll(PDO::FETCH_ASSOC);
$counter = 1;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="text-center m-5">Informacija apie įmonės darbuotojus</h1>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header">Darbuotojų sąrašas</div>
                <div class="card-body">
                    <table class="table">

                        <thead>
                    <tr>
                        <th>Nr.</th>
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>Išsilavinimas</th>
                        <th>Alga</th>
                        <th>Tel. nr.</th>
                        <th></th>

                     </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($employees as $darbuotojas){ ?>
                    <tr>

                        <td><strong><?=$counter?></strong></td>
                        <td><?=$darbuotojas['name']?></td>
                        <td><?=$darbuotojas['surname']?></td>
                        <td><?=$darbuotojas['education']?></td>
                        <td><?=$darbuotojas['salary']?> Eur</td>
                        <td><?=$darbuotojas['phone']?></td>

                        <td><a class="btn btn-success" href="darbuotojas.php?id=<?=$darbuotojas['id']?>">Plačiau</a> </td>
                        <td><a class="btn btn-primary text-white" href="update.php?id=<?=$darbuotojas['id']?>">Redaguoti</a> </td>

                        <td><a class="btn btn-danger" href="index.php?delete=<?=$darbuotojas['id']?>">Ištrinti</a> </td>

                        <?php $counter++;} ?>

                    </tr>
                        </tbody>
                </table>
                    <td><a class="btn btn-secondary" href="new.php?"=<?=$darbuotojas['id']?>>Pridėti naują darbuotoją</a> </td>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">Baziniai darbo užmokesčiai pagal pareigybes</div>
                    <div class="card-body">
                        <table class="table">

                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pareigos</th>
                                <th>Bazinis atlyginimas</th>
                                <th></th>

                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($employees2 as $pareigos){ ?>
                            <tr>

                                <td><strong><?=$pareigos['id']?></strong></td>
                                <td><?=$pareigos['pareigos']?></td>
                                <td><?=$pareigos['bazinis_atlyginimas']?></td>
                                <td><a class="btn btn-success" href="darbuotojas.php?id=<?=$pareigos['id']?>">Rodyti darbuotojus</a> </td>
                                <?php } ?>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





</div>
</body>
</html>

