var BitCoin={calculator:{calculate:function(){var t=window.event||arguments.callee.caller.arguments[0],n=$(t.target),e=n.data("url");$.get(e,{units:$("#units option:selected").text()},function(t){console.log(t);var n=$("#result"),e="<table><tr><td>Month</td><td>BTC Coins</td><td>Monthly Revenue</td><td>Monthly Costs</td><td>Profit</td></tr>";n.empty(),n.append("<span>Bitcoin cost: $"+t.cost+"</span>");for(var o in t.grid){e+="<tr>";for(var a in t.grid[o])e+="<td>"+t.grid[o][a]+"</ td>";e+="</tr>"}e+="</table>",n.append(e)},"json")}}};
//# sourceMappingURL=engine.js.map
