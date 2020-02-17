<?php
include '../mySQLlogins.php';
include '../header.php';
include 'navbarHappyNono.php';
$day = '2020-02-15';
$collapseNumber = 1;
$minutes = 0;

// test fonction hour
function hour($a, $b) {
    $timestamp = strtotime('' . $a . ':' . $b . ':00');
    $aa = idate('H', $timestamp);
    $bb = idate('i', $timestamp);
    if ($bb == "0") {
        $cc = "00";
    } else {
        $cc = $bb;
    }
    $dd = $aa . ":" . $cc;
    return($dd);
}
?>
<div class="col-12 d-flex flex-row flex-wrap justify-content-around bg-success">
    <?php
    // connect and look for all appointments cooreponding to selected $day
    $db = connectToDatabase();
    $queryAppointment = 'SELECT * FROM `appointments` WHERE dateHour LIKE \'' . $day . '%\' ORDER BY dateHour';
    $appointmentVerification = $db->query($queryAppointment);
    $appointmentListing = $appointmentVerification->fetchAll(PDO::FETCH_ASSOC);
    // For each hours starting a 8 and under 20
    for ($hour = 8; $hour <= 19.5; $hour += 0.5) {
        // by interval of 30 minutes
        if (fmod($hour, 1) != 0) {
            $minutes = 30;
        } else {
            $minutes = 00;
        }
        $collapseNumber++;
        $time = hour((int) $hour, $minutes);
        ?>
        <div id="<?= $time ?>" class="col-5 m-2 p-2 rounded bg-dark">
            <p class="text-light"><?= $time ?></p>
            <?php
            $count = 1;
            // for each appointment
            foreach ($appointmentListing as $appointment) {
                $queryPatient = 'SELECT * FROM `patients` WHERE `patients`.`id`=' . $appointment['idPatients'] . '';
                $patientVerification = $db->query($queryPatient);
                $patientListing = $patientVerification->fetchAll(PDO::FETCH_ASSOC);
                foreach ($patientListing as $patient) {

                    // if the appointment dateHour corresponds to the day and time, verify if a patient has an appointment
                    if ($appointment['dateHour'] == $day . ' ' . $time . ':00') {
                        ?>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse<?= $collapseNumber ?>" aria-expanded="false" aria-controls="#collapse<?= $collapseNumber ?>">
                            <?= $patient['lastname'] . ' ' . $patient['firstname'] ?>
                        </button>
                        <div class="collapse" id="collapse<?= $collapseNumber ?>">
                            <div class="card card-body">
                                <form action="modifier-rendezvous.php" method="POST">
                                    <input type="text" name="patientID" value="<?= $patient['id'] ?>" hidden>
                                    <input type="text" name="rendezvousID" value="<?= $appointment['id'] ?>" hidden>
                                    <input class="btn btn-warning" type="submit" value="Modifier le rendez-vous">
                                </form>
                                <form action="supprimer-rendezvous.php" method="POST">
                                    <input type="text" name="patientID" value="<?= $patient['id'] ?>" hidden>
                                    <input type="text" name="rendezvousID" value="<?= $appointment['id'] ?>" hidden>
                                    <input class="btn btn-danger" type="submit" value="Supprimer le rendez-vous">
                                </form>
                            </div>
                        </div>
                        <?php
                        break;
                    } elseif ($count == count($appointmentListing)) {
                        ?>
                        <form action="ajout-rendezvous.php" method="POST">
                            <input type="text" name="dateHour" value="<?= $day . ' ' . $time . ':00' ?>" hidden>
                            <input class="btn btn-success" type="submit" value="Ajouter un rendez-vous">
                        </form>
                        <?php
                        break;
                    }
                    $count++;
                }
            }
            ?>
        </div>
        <?php
    }
    ?>
</div>
<?php
include '../footer.php';
