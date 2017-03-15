<?php $this->beginContent('//patient/event_container'); ?>

<div style="padding-left: 25px;">

<h1><i class="fa fa-exclamation-triangle" style="color: #eb5911;"></i> Reason required</h1>
<p>
    This prescription has been printed. Changes to printed prescriptions must
    only be made under specific circumstances. Please select a reason from the list below:
</p>

<?php

$reasons = OphDrPrescriptionEditReasons::model()->findAll(array('order'=>'display_order', 'condition'=>'active = 1'));

?>
<?php echo CHtml::form('/OphDrPrescription/default/update/'.$id.'?reason=selected', 'post'); ?>
    <input type="hidden" name="do_not_save" value="1" />
    <input type="hidden" name="reason" id="reason" />
    <?php foreach ($reasons as $key=>$reason): ?>
        <div>
            <button class="secondary small submit" data-value="<?php echo $reason->id; ?>" id="reason_<?php echo $reason->id; ?>" style="margin-bottom: 5px;"><?php echo htmlentities($reason->caption); ?></button>

        </div>
    <?php endforeach; ?>
    <div class="row">
        <div class="column large-6 medium-6">
            <textarea rows="5" cols="25" readonly type="text" id="reason_other_text" name="reason_other"></textarea>
        </div>
        <div class="column large-6 medium-6">
            <div id="other_reason_controls" style="display: none;">
                <a href="javascript:void(-1);" id="submit_other" style="color: #3fa522;"><i class="fa fa-check fa-2x"></i></a>
                <br/>
                <a href="javascript:void(-1);" id="cancel_other" style="color: #eb5911;"><i class="fa fa-times fa-2x"></i></a>
            </div>
        </div>
    </div>

<?php echo CHtml::endForm() ?>
<br/>
<p style="color: red;">Any old paper copies of this prescription MUST BE DESTROYED.</p>

</div>


<?php $this->endContent();?>



<script type="text/javascript">
    $(function(){
        window.onbeforeunload = null;
        $(document).on("click","button.submit", function(e){
            e.preventDefault();
            var value = $(this).data('value');
            if(value=='1')
            {
                $('#reason').val(1);
                $('#reason_other_text').removeAttr("readonly").focus();
                $('#other_reason_controls').show();
            }
            else
            {
                $('#reason_other_text').val("").attr("readonly", "readonly");
                $('#other_reason_controls').hide();
                $('#reason').val(value);
                $(this).closest('form').submit();
            }
        });

        $("#cancel_other").click(function(e){
            $('#reason_other_text').val("").attr("readonly", "readonly");
            $('#other_reason_controls').hide();
            $('#reason').val('');
        });

        $("#submit_other").click(function(e){
            $(this).closest('form').submit();
        });

    });
</script>