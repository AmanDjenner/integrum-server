System alarmowy: {[ $name ]}<br />
Raport z dnia: {[ $rep_date ]}<br />
<br />
Aktualny odczyt : {[ $rd_date ]}<br />
Poprzedni odczyt: {[ $prev_date ]}<br />
<br />
<?php
if ($autoinc) {
    $url = Request::url();
    ?>
    Pobierz plik z danymi: <a href="{[$url]}:8000/getstructurereportxcx/{[$autoinc]}" >ID: {[$autoinc]}</a>
    <?php
}
?>
<br />
<?php
print ($report) ? 'Zmiany w danych:<br />' : '';
$i = 1;
foreach ($report as $value) {
    print $i++.". ".$value." <br />";
}
print "--- <br />";
if ($usr_report) {
    print $usr_report;
}

if ($rep_code) {
    print $rep_code;
}
