<?php
require_once 'db.php';
$id = $_GET['id'];
$stm = $db->prepare("SELECT * FROM darbuotojai WHERE id=?");
$stm->execute([$id]);
$darbuotojas = $stm->fetch(PDO::FETCH_ASSOC);

$lent2=$db->prepare("SELECT * FROM positions WHERE id=?");
$lent2->execute([$id]);
$pareigos=$lent2->fetch(PDO::FETCH_ASSOC);

$NPD = 0;
if ($darbuotojas['salary'] < 840) {
    $NPD = 625;
}
if ($darbuotojas['salary'] > 840 && $darbuotojas['salary'] < 1926) {
    $NPD = 625 - 0.42 * ($darbuotojas['salary'] - 840);
}
if ($darbuotojas['salary'] > 1926) {
    $NPD = 400 - 0.18 * ($darbuotojas['salary'] - 642);
}

$GPM = ($darbuotojas['salary']) * 0.2;
$PSD = ($darbuotojas['salary']) * 0.0698;
$VSD = ($darbuotojas['salary']) * 0.1252;
$sdi = ($darbuotojas['salary']) * 0.0145;
$garantinis = ($darbuotojas['salary']) * 0.0016;
$idif = ($darbuotojas['salary']) * 0.0016;
?>

<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid mx-auto">
    <a class="btn btn-secondary text-decoration-none mt-2" href="javascript:history.go(-1)" title="Grįžti atgal">« Grįžti atgal</a>
    <a class="btn btn-primary mt-2" href="update.php?id=<?= $darbuotojas['id'] ?>">Redaguoti</a>
    <h1 class="text-center mt-5 mb-5 ">Informacija apie darbuotoją</h1>
     <div class="d-flex justify-content-center gap-5 mt-5">

            <div class="row">
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-header bg-primary opacity-75 fw-bold text-white">Darbuotojo id:
                            <?php $darbuotojas['id'] ?></div>
                        <table class="table">
                            <tbody class="mt-2">
                            <tr>
                                <td class="fw-bold">Pareigos:</td>
                                <td><?= $pareigos['pareigos'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Vardas:</td>
                                <td><?= $darbuotojas['name'] ?>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-bold">Pavardė:</td>
                                <td><?= $darbuotojas['surname'] ?></td>
                            </tr>

                            <tr>
                                <td class="fw-bold">Gimimo data:</td>
                                <td><?= $darbuotojas['birthday'] ?></td>
                            </tr>

                            <tr>
                                <td class="fw-bold">Išsilavinimas:</td>
                                <td><?= $darbuotojas['education'] ?></td>
                            </tr>

                            <tr>
                                <td class="fw-bold">Atlyginimas:</td>
                                <td><?= $darbuotojas['salary'] ?></td>
                            </tr>


                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

                <div class="row ">
                    <div class="col-md-12 mt-5">
                        <div class="card">
                            <div class="card-header">
                                <h4>GAUTAS REZULTATAS</h4>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td class="fw-bold bg-primary-subtle">Darbuotojo sumokami mokesčiai:</td>
                                        <td class="fw-bold"><?= round($NPD + $GPM + $PSD + $VSD, 2) ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Apskaičiuotas NPD:</td>
                                        <td><?= $NPD ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Pajamų mokestis(GPM) 20%:</td>
                                        <td><?= $GPM ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Privalomas veikatos draudimas (PSD) 6.98%:</td>
                                        <td><?= $PSD ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Valstybinis socialisnis draudimas (VSD) 12.52%:</td>
                                        <td><?= $VSD ?> Eur</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold bg-primary-subtle">Darbdavio mokesčiai:</td>
                                        <td class="fw-bold"><?= $sdi + $garantinis + $idif ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Socialinio draudimo įmoka 1.45%:</td>
                                        <td><?= $sdi ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Įmokos į garantinį fondą 0.016%:</td>
                                        <td><?= $garantinis ?> Eur</td>
                                    </tr>
                                    <tr>
                                        <td>Ilgalaikio darbo išmokų fondui 0.016%:</td>
                                        <td><?= $idif ?> Eur</td>
                                    </tr>
                                    <!--                    <tr>-->
                                    <!--                        <td><b>Visi mokesčiai:</b></td>-->
                                    <!--                        <td><b>-->
                                    <?php //= ($darbuotojas['salary'] / 100) + $sdi + $garantinis ?><!--</b></td>-->
                                    <!--                    </tr>-->
                                    <tr>
                                        <td class="fw-bold bg-primary text-white">Užmokestis į rankas:</b></td>
                                        <td><b><?= ($darbuotojas['salary']) - $GPM - $PSD - $VSD ?> Eur</b></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold bg-danger text-white"
                                        ">Visos darbdavio išlaidos:</b></td>
                                        <td><b><?= ($darbuotojas['salary']) + $sdi + $garantinis + $idif ?> Eur</b></td>
                                    </tr>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>

     </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>
</html>
