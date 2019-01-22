var analytics_layout = {
    title: '',
    titlefont: {
        color: '#fff',
    },
    autosize: false,
    height: 800,
    width:1000,
    margin:{
        l:50,
        t:30,
        b: 50,
        pad:4,
    },
    paper_bgcolor: '#141e2b',
    plot_bgcolor: '#141e2b',
    /* legend settings */
    showlegend: true,
    legend: {
        x: 0 ,
        y: 1.1,
        traceorder: 'normal',
        font: {
            family: 'sans-serif',
            size: 12,
            color: '#8c8c8c',
        },
    },
    xaxis: {
        showgrid: false,
        /*Ticks setting*/
        ticks: 'outside',
        showticklabels: true,
        showline: true,
        linecolor: '#fff',
        tickcolor: '#fff',
        tickfont: {
            color: '#fff',
        },
    },
    yaxis:{
        /*Ticks setting*/
        ticks: 'outside',
        showgrid: true,
        gridcolor: '#aaa',
        showticklabels: true,
        showline: true,
        linecolor: '#fff',
        tickcolor: '#fff',
        tickfont: {
            color: '#fff',
        },
    },
};

var analytics_options = {
    displayLogo: false,
    displayModeBar: false,
};