<?php $coreAPI = new CoreAPI();
      $operation_API = new OphTrOperationnote_API();?>
<div class="analytics-patient-list" style="display: none;" >
    <div class="flex-layout">
        <h3 id="js-list-title">Patient List</h3>
        <button id="js-back-to-chart" class="selected" >Back to chart</button>
    </div>
    <table>
        <colgroup>
            <col style="width: 100px;">
            <col style="width: 200px;">
            <col style="width: 100px;">
            <col style="width: 50px;">
            <col style="width: 50px;">
            <col style="width: 450px;">
            <col style="width: 450px;">
        </colgroup>
        <thead>
        <tr>
            <th class="drill_down_patient_list">Hospital No</th>
            <th class="drill_down_patient_list">Name</th>
            <th>DOB</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Diagnoses</th>
            <th>Procedures</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($patient_list as $patient) { ?>
            <tr id="<?=$patient->id?>" class="analytics-patient-list-row clickable" data-link="<?=$coreAPI->generateEpisodeLink($patient)?>" style="display: none">
                <td class="drill_down_patient_list js-csv-data"><?= $patient->hos_num; ?></td>
                <td class="drill_down_patient_list"><?= $patient->getFullName(); ?></td>
                <td><?=$patient->dob?></td>
                <td class="js-anonymise js-csv-data"><?= $patient->getAge(); ?></td>
                <td class="js-anonymise js-csv-data"><?= $patient->gender; ?></td>
                <td><?= $patient->getUniqueDiagnosesString();?></td>
                <?php
                    $operations = $operation_API->getOperationsSummaryData($patient);
                    $procedure_lists = "";
                    foreach ($operations as $operation){
                        $procedure_lists = $procedure_lists.$operation['operation'].",";
                    }
                    $procedure_lists = substr($procedure_lists,0,-1);
                ?>
                <td><?=$procedure_lists; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="<?= Yii::app()->assetManager->createUrl('js/analytics/analytics_csv.js')?>"></script>
<script type="text/javascript">
    $('.clickable').click(function () {
        var link = $(this).data('link');
        window.location.href = link;
    });
    $('#js-back-to-chart').click(function () {
        $('.analytics-charts').show();
        $('.analytics-patient-list').hide();
        $('.analytics-patient-list-row').hide();
    });
</script>