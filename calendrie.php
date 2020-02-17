<?php
$currentMonth =  !empty ($_POST['month'])? $_POST['month']: date('m') ; //mois choisi sinon mois courant
$selectedYear = !empty ($_POST['year'])? $_POST['year']: date('Y') ; //année choisie sinon année courante
$daysinMont = date('t', mktime(0,0,0,$currentMonth,1,$selectedYear));// nombre de jour dans le mois
$firstDayinMonthinWeek = date('N', mktime(0,0,0,$currentMonth,1,$selectedYear));//position du jour dans la semaine
//tableau des jours
$weekDays = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'] ;
//tableau des mois
$yearMonths = ['Janvier','février','mars','avril','mai','juin','juillet','aôut','septembre','octobre','novembre','décembre'] ;
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Calendrier</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
        .card-show{
            display: flex;
            align-content: space-around;
            align-items: stretch;
            border-radius:  30px;
            width: 150px;
            height: 100px;
        }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <form method="post">
                <select name="month">
                    <?php
                    //affichage de liste des mois
                    foreach ($yearMonths as $monthsNumber => $yearMonth): ?>
                    <option value="<?= $monthsNumber+1 ?>" <?php  if(!empty($_POST['month'])){if($_POST['month']==$monthsNumber+1){echo "selected";}else{echo'';}}?> ?><?= $yearMonth ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="year">
                    <?php
                    //affichage de la liste des années
                    for($year = 1900; $year <= 2100; $year ++): ?>
                    <option value="<?= $year ?>" <?=  ($selectedYear == $year) ? 'selected' : '' ?>><?= $year ?></option>
                    <?php endfor; ?>
                </select>
                <input type="submit" />
            </form>
            <h1><?php if(!empty($_POST['month'])){echo $yearMonths[$_POST['month']-1];}else{echo"";}?> <?= $selectedYear ?></h1>
            <table class="table table-bordered">
                <thead>
                <?php
                //affichage de l'entête du tableau avec les jours de la semaine contenu dans la table $weekDays
                    foreach($weekDays as $weekDay): ?>
                <th><?= $weekDay ?></th>
                <?php endforeach; ?>
                </thead>
                <tbody>
                    <tr>
                    <?php
                        //bloucle initialisé à true
                        $loop = true;
                        //compteur de cellule(s)
                        $cell = 1;
                        //compteur de jour(s)
                        $day = 1;
                        //nombre de cellules requises pour le tableau
                        $requiredCells = $daysinMont + $firstDayinMonthinWeek -1;
                        while($loop){
                           //si le jour ne commence pas un lundi ou si le nombre de cellules est supérieur au nombre de jours dans le mois, on fait des cellules vides
                            if($firstDayinMonthinWeek > $cell || $cell > $requiredCells){ ?>
                        <td class="bg-primary"></td>
                            <?php
                            }
                            //sinon on écrit le numéro du jour dans la cellule
                            else{ ?>
                                <td><?= $day ?></td>
                            <?php
                                $day++;
                            }
                            if($cell % 7 == 0){  //si le nombre de cellules est divisible par 7 (corresponodant au nb de jour de la semaine), 7, 14, 21, 28
                                  //si le nombre de cellule est supérieur au nombre de cellules requises, on arrête la boucleet on fait une nouvelle ligne
                                 if($cell >= $requiredCells){
                                    break;
                                }
                                ?>
                                </tr><tr>
                            <?php
                            }
                            //on incrémente le nombre de cellules
                            $cell++;

                        }
                    ?>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </body>
</html>
