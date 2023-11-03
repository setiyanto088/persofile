var elementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

    // $("#exportWidget").click(function () {
      $("#exportWidget").click(function () {
          var doc = new jsPDF();
          var countPage = 0;

          // Widget-1
          if($("#checkOne").is(':checked')){

            doc.text(105, 30, 'Spot by Time', null, null, 'center');

            var canvasWidget1 = document.getElementById('widget-spot-time');
            var imgData = canvasWidget1.toDataURL("image/png", 1.0);  
            doc.setFillColor(203, 51, 39);
            doc.roundedRect(83, 46, 15.9*2.7, 12.2*3+5, 3, 3, "F");    
            doc.addImage(imgData, 'PNG', 83, 50, 15.9*2.7, 12.2*2.7);
            countPage++;
          }

          // Widget-2
          if($("#checkTwo").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Spot by Chanel', null, null, 'center');

            var canvasWidget2 = document.getElementById('widget-spot-channel');
            var chartWidget2 = canvasWidget2.toDataURL("image/png", 1.0); 
            
            doc.addImage(chartWidget2, 'PNG', 50, 50); 
            countPage++;
          }

          // Widget-3
          if($("#checkThree").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Rating', null, null, 'center');

            // doc.addImage(canvasWidget2.toDataURL("image/png", 1.0), 'PNG', 15, 30); 
            countPage++;
          }

          // Widget-4
          if($("#checkFour").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }
            doc.text(105, 30, 'Daypart', null, null, 'center');
            // doc.addImage(canvasWidget2.toDataURL("image/png", 1.0), 'PNG', 15, 30); 
            countPage++;
          }

          // Widget-5
          if($("#checkFive").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Spot by Day', null, null, 'center');
            var canvasWidget5 = document.getElementById('widget-spot-day');
            doc.addImage(canvasWidget5.toDataURL("image/png", 1.0), 'PNG', 45, 50); 
            countPage++;
          }

          // Widget-6
          if($("#checkSix").is(':checked')){
            if (countPage != 0){
              doc.addPage();
            }

            doc.text(105, 30, 'Table', null, null, 'center');
           
            var elem = document.getElementById("example3");
            var res = doc.autoTableHtmlToJson(elem);
            doc.autoTable(res.columns, res.data, {
                theme: 'plain',
                margin: {
                  top: 50,
                  left: 50,
                  right: 50
                },
                headerStyles: {
                  fontStyle: 'bold'
                },
                bodyStyles: {
                  bottomLineColor: [0, 0, 0],
                },
                styles: {
                  // columnWidth: 'auto',
                  // bottomLineColor: [44, 62, 80],
                  // lineWidth: 0.1
                },
                columnStyles: {
                  text: {
                    // columnWidth: 'auto'
                  }
                }
            });
            countPage++;
          }

          // Save into pdf
          if(countPage > 0){
            doc.save('sample-file.pdf');
          }
      });
    // });