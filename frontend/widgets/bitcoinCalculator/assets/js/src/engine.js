var BitCoin = {
    calculator: {
        calculate: function () {
            var e = window.event || arguments.callee.caller.arguments[0];
            var self = $(e.target);
            var url = self.data('url');

            $.get(url, {units: $('#units option:selected').text()}, function (result) {
                console.log(result);
                var container = $('#result');
                var html = '<table><tr><td>Month</td><td>BTC Coins</td><td>Monthly Revenue</td><td>Monthly Costs</td><td>Profit</td></tr>';
                container.empty();
                container.append('<span>Bitcoin cost: $'+result.cost+'</span>');
                for(var row in result.grid){
                    html += '<tr>';
                    for(var col in result.grid[row]){
                        html += '<td>'+result.grid[row][col]+'</ td>';
                    }
                    html += '</tr>';
                }
                html += '</table>';
                container.append(html);
            }, 'json');
        }
    }
};
