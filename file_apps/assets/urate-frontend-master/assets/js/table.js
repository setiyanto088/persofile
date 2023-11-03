function sortTable(startIndex, n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;

  //Set the sorting direction to ascending:
  dir = "asc";

  /*Make a loop that will continue until
    no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("tr");

    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = startIndex; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("td")[n];
      y = rows[i + 1].getElementsByTagName("td")[n];

      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }

    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function compare() {

  var oTable = document.getElementById("myTable");
  var oRows = oTable.getElementsByTagName("tr");

  for (var i = 0; i < oRows.length; i++) {
    var oInputs = oRows[i].getElementsByTagName("input");
    for (var j = 0; j < oInputs.length; j++) {
      if (oInputs[j].name == "showHide") {
        if (oInputs[j].checked) {
          oRows[i].style.display = "";
        } else {
          oRows[i].style.display = "none";
        }

        break;
      }
    }
  }
}

function updateTableView($selector, $table) {
  var $ind = [];

  $selector.each(function() {
    if (!($(this).hasClass('selected'))) {
      $ind.push($(this).text().trim().toLowerCase());
    }
  });

  $table.find('th').show();
  $table.find('td').css('display', 'table-cell');

  $table.find("th").each(function() {
    for (var i = 0; i < $ind.length; i++) {
      if ($(this).text().trim().toLowerCase() == $ind[i]) {
        $(this).hide();
        $table.find('td:nth-child(' + ($(this).index() + 1) + ')').hide();
      }
    }
  })
}

// $('#export').click(function() {
//   $('#export').css('display', 'none');
//   $('#export-now').css('display', 'inline-block');
//   $('#export-cancel').css('display', 'inline-block');
// });

// $('#export-cancel').click(function() {
//   $('#export').css('display', 'inline-block');
//   $('#export-now').css('display', 'none');
//   $('#export-cancel').css('display', 'none');
// });

// $('#export2').click(function() {
//   $('#export2').css('display', 'none');
//   $('#export-now2').css('display', 'inline-block');
//   $('#export-cancel2').css('display', 'inline-block');
// });

// $('#export-cancel2').click(function() {
//   $('#export2').css('display', 'inline-block');
//   $('#export-now2').css('display', 'none');
//   $('#export-cancel2').css('display', 'none');
// });

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace('', function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})() 