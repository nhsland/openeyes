
<div id="js-hs-chart-analytics-clinical-diagnosis" style="" class="js-hs-chart-analytics-clinical">
    <button id="js-back-to-common-disorder" class="selected" style="display: none">Back to common disorders</button>
    <div id="js-hs-chart-analytics-clinical"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var clinical_layout = JSON.parse(JSON.stringify(analytics_layout));
        var clinical_data = JSON.parse(<?= json_encode($clinical_data); ?>);

        var max_name_length = Math.max(...clinical_data['text'].map(function (item) {
            return item.length;
        }));
        window.csv_data_for_report['clinical_data'] = clinical_data['csv_data'];
        var data = [{
            name: clinical_data['title'],
            x: clinical_data['x'],
            y: clinical_data['y'],
            customdata: clinical_data['customdata'],
            type: 'bar',
            hoverinfo:'x+y',
            orientation: 'h'
        }];
        clinical_layout['margin']['l'] = max_name_length*7;
        clinical_layout['xaxis']['showticksuffix'] = 'none';
        clinical_layout['xaxis']['title'] = 'Number of Patient';
        clinical_layout['xaxis']['tick0'] = 0;
        clinical_layout['xaxis']['dtick'] = Math.round((Math.max(...clinical_data['x'])+10)/50)*5;
        clinical_layout['yaxis']['showgrid'] = false;
        clinical_layout['yaxis']['tickvals'] = clinical_data['y'];
        clinical_layout['yaxis']['ticktext'] = clinical_data['text'];
        clinical_layout['clickmode'] = 'event';
        Plotly.newPlot(
            'js-hs-chart-analytics-clinical', data ,clinical_layout, analytics_options
        );
        var clinical_plot = document.getElementById('js-hs-chart-analytics-clinical');
        clinical_plot.on('plotly_click', function(data){
            var custom_data = data.points[0].customdata;
            if (!Array.isArray(custom_data)){
                if ('text' in custom_data && 'customdata' in custom_data){
                    clinical_data['y'] = $('#js-hs-chart-analytics-clinical')[0].layout['yaxis']['tickvals'];
                    clinical_data['text'] = $('#js-hs-chart-analytics-clinical')[0].layout['yaxis']['ticktext'];
                    $('#js-back-to-common-disorder').show();
                    //click on "other" bar, redraw the chart show details of other disorders.
                    custom_data['type'] = 'bar';
                    custom_data['orientation'] = 'h';
                    custom_data['hoverinfo'] = 'x+y';
                    clinical_layout['yaxis']['tickvals'] = custom_data['y'];
                    clinical_layout['yaxis']['ticktext'] = custom_data['text'];
                    clinical_layout['xaxis']['dtick'] = Math.round((Math.max(...custom_data['x'])+10)/50)*5;

                    Plotly.react(
                        'js-hs-chart-analytics-clinical', [custom_data], clinical_layout, analytics_options
                    );
                }
            }
            else{
                //redirect to drill down patient list
                if (data.points[0].x > 0){
                    $('.analytics-charts').hide();
                    $('.analytics-patient-list').show();
                    $('.analytics-patient-list-row').hide();
                    var patient_show_list = custom_data;
                    for (var j=0; j< patient_show_list.length; j++){
                        $('#'+patient_show_list[j]).show();
                    }
                }
            }
        });
        $('#js-back-to-common-disorder').click(function () {
            $(this).hide();
            clinical_layout['yaxis']['tickvals'] = clinical_data['y'];
            clinical_layout['yaxis']['ticktext'] = clinical_data['text'];
            Plotly.react(
                'js-hs-chart-analytics-clinical', data, clinical_layout, analytics_options
            );
        });

    });
</script>