

// Use Morris.Area instead of Morris.Line
Morris.Donut({
    element: 'graph-services',
    data: [
        {label: "General Services", value: 70 },
        {label: "PX Coating Program", value: 15},
        {label: "Treatment Services", value: 10},
        {label: "PPF Program", value: 5}
    ],
    backgroundColor: '#fff',
    labelColor: '#000',
    colors: [
        '#ed1d24','#bb1117','#801e21','#451a1b'
    ],
    // formatter: function (x, data) { return data.formatted; }


});
 
// Use Morris.Area instead of Morris.Line
Morris.Donut({
    element: 'graph-payment',
    data: [
        {label: "Cheque", value: 0 },
        {label: "Cash", value: 35},
        {label: "Credit Card", value: 50},
        {label: "Online Transfer", value: 10} 
    ],
    backgroundColor: '#fff',
    labelColor: '#000',
    colors: [
        '#ed1d24','#bb1117','#801e21','#451a1b'
    ],
    // formatter: function (x, data) { return data.formatted; }
 
});

     $(window).on('resize', function() {
       if (!window.recentResize) {
          Morris.Donut.redraw();
          window.recentResize = true;
          setTimeout(function(){ window.recentResize = false; }, 200);
       }
    });