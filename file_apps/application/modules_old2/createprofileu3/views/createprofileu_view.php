
<!-- Multi Select Css -->
<link href="<?php echo $path;?>plugins/multi-select/css/multi-select.css" rel="stylesheet"> 
<link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet"> 
  
    <!-- Multi Select Plugin Js -->
    <script src="<?php echo $path;?>plugins/multi-select/js/jquery.multi-select.js"></script>
    <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
    <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/src/jstree.search.js"></script>
<style>
.jstree-themeicon{
   display: none !important;
}

    
    
    .dropdown-menu{
        margin-top: 0px !important;
    }
</style>
<script>
    var optVal1 = [];
    var tempVal1 = [];
    var optVal = [];
    var tempVal = [];
    var favdata = [];
    var star = 0;
  var newdata = [];
$( document ).ready(function() {
    
    user_id = $.cookie(window.cookie_prefix + "user_id");
    token = $.cookie(window.cookie_prefix + "token");
    
    $(".preloader").hide();
    
    var form_data = {
        user_id      : user_id
    }
     $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>createprofileu3/searchfav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(form_data),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
    }).done(function(response) {
        console.log(response);
        if (response.success) {
            var dda = response.data.hasil;
            dda.forEach(function(entry, index) {
                $("#facs").append( '<button class="btn btn-link waves-effect" id="btn_'+index+'" href="javascript:void(0)" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><i class="material-icons">star</i></button>');
            });

        } else {

        }
    }).fail(function(xhr, status, message) {

        console.log('ajax create error:' + message);
    });
    
    
    
    
     $('#searchjtree').typeahead({
        source: function (query, process) {
            return $.get('listsearch?q=' + query, function (data) {
                return process(data);
            });
        },
        updater: function(selection){
             $('#jstree2').jstree('search', selection.name);
            
        }
    });
    
    $('#searchjtree').on('typeahead:select', function (e, datum) {
        console.log(datum);
    });
    
    
    
    
    
    
    
    
    
    
    
    
    
  var dass = '';
              $('#jstree2').jstree({'plugins':["checkbox","search"], 'core' : {
                                "themes" : { "stripes" : true },
                'data' : [
                      <?php 
                $html = '';
                $htmls = '';
 
                $html .=  '{ "text" : "GEOGRAFI", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['GEOGRAFI'] as $k2 => $v2) {
                        $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=GEOGRAFI" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';

                    }
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }

                $html .=  '{ "text" : "HELIX PERSONAS", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['HELIX PERSONAS'] as $k2 => $v2) {
                        $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=HELIX PERSONAS" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';

                    } 
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }
				
				$html .=  '{ "text" : "DEMOGRAFI", "state" : { "opened" : false }, "children" : [';
                foreach ($listparent[0] as $k1 => $v1) {
                    foreach ($v1['DEMOGRAFI'] as $k2 => $v2) {
                         $html .=  ' { "text" : "'.$v2['ANAK1'].'", "state" : { "opened" : false },  "children" : [';
                            foreach ($v2['ANAK2'] as $k3 => $v3) {
                                $html .=  ' { "text" : "'.$v3['ANAK2'].'", id:"'.$v3['ANAK2'].'='.$v2['ANAK1'].'=DEMOGRAFI" },';
                            }
                            $html = substr($html, 0, -1);

                            $html .= '] },';
  
                    }
                    $html = substr($html, 0, -1);
                    $html .=  '] }';

                }
				
                $htmls.=str_replace("}{","},{",$html); 
                echo $htmls; 
                ?> 
                ]
              },
                            "search": {



                            }});
    

    
              $('#jstree2').on("changed.jstree", function (e, data) {
                
				console.log(data);
				
              $('#list').empty();
                var newdata = data.selected;
                var dd = [];
                var ddf = [];
                var ddsh = [];
                var text = '';
                for(var i = 0; i < newdata.length; i++){
                 var ss = newdata[i].split("_");
                                  
                                  if(ss[0] != 'j1'){
                                      var ssa = newdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
                                  
                };
                                
                dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var tempVal1 = $("#profile_"+index).val();

                                                if(tempVal1.indexOf(val) >= 0 && optVal1.indexOf(val) < 0) {
                                                    optVal1.push(val);
                                                } else if(tempVal1.indexOf(val) < 0 && optVal1.indexOf(val) >= 0) {
                                                    optVal1.splice(optVal1.indexOf(val) , 1);
                                                }

                                            })

                                        });
                              });      
                                
                            var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                
                                var texta;
                                
                uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="star_'+datas+'">'+datas+' <a href="javascript:void(0)"  onclick="favorite(1,&#34;'+datas+'&#34;)" ><i class="material-icons">star_border</i></a></h3><span id="anak_'+index+'"></span>';
                                      $('#list').append(text);
                                      ddf.forEach(function(entry, index) {

                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                              $('#anak_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
                });
                
                                
                                
                                
                  
                arraypush(data.selected);
                
              });
              
              
});
Array.prototype.inArray = function(comparer) { 
    for(var i=0; i < this.length; i++) { 
        if(comparer(this[i])) return true; 
    }
    return false; 
}; 

function clear(){
    $("#slec option:selected").removeAttr("selected");
}    
function addleft(id, dex, val){
    console.log(dex);
     var bn = document.getElementById('btn_'+dex);
    if(bn.disabled == false) { 
          $("#btn_"+dex).attr('disabled', 'disabled');
    }else{
        alert('gagal');
    }
    var selection = {
            name     : val
        }
    
     $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>createprofileu3/searchopval" + "?sess_user_id=" + user_id + "&sess_token=" + token,
        data: JSON.stringify(selection),
        dataType: 'json',
        contentType: 'application/json; charset=utf-8'
      }).done(function(response) {
                console.log(response);
        if (response.success) {
                var data = response.data;
          data.forEach(function(entry, index) {
                       
                        
                        $('#list').empty();
                var sc =  JSON.parse(entry.child);
                        sc.forEach(function(entry, index) {
                            newdata.push(entry);
                        
                        });
                         console.log(newdata);
                var dd = [];
                var ddf = [];
                var ddsh = [];
                var text = '';
                for(var i = 0; i < newdata.length; i++){
                 var ss = newdata[i].split("=");
                                  
                                  if(ss[0] != 'j1'){
                                       dd.push(ss);
                                       ddf.push(ss);
                                  }
                                  
                };
                                
                dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var tempVal1 = $("#profile_"+index).val();

                                                if(tempVal1.indexOf(val) >= 0 && optVal1.indexOf(val) < 0) {
                                                    optVal1.push(val);
                                                } else if(tempVal1.indexOf(val) < 0 && optVal1.indexOf(val) >= 0) {
                                                    optVal1.splice(optVal1.indexOf(val) , 1);
                                                }

                                            })

                                        });
                              });      
                        
                            var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
                                console.log(uniqueNames);
                                
                                var texta;
                                
                uniqueNames.forEach(function(datas, index) {
                                  
                                  if(datas){
                                       var ix = index;
                                  text ='<h3 id="star_'+datas+'">'+datas+' <a href="javascript:void(0)"  onclick="favorite(1,&#34;'+datas+'&#34;)" ><i class="material-icons">star_border</i></a></h3><span id="anak_'+index+'"></span>';
                                     $('#list').append(text);
                                  ddf.forEach(function(entry, index) {
                                      
                                      if(datas == entry[1]){
                                         texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                          $('#anak_'+ix).append(texta);
                                      }
                                        

                                  });
                                  }
                                 
                                  
                });
                
                        
                        
                        
                        
                        
                    });
        } else {
          
        }
      }).fail(function(xhr, status, message) {
        
        console.log('ajax create error:' + message);
      });
        
}
function favorite(id, val){
    var databawa = [];
    for(var i = 0; i < newdata.length; i++){
         var ss = newdata[i].split("=");
         var newss = ss.length;
          if(ss[0] != 'j1'){
              if(ss[1] == val){
                  databawa.push(ss[0]+'='+ss[1]+'='+ss[2]);
                  
              }
          }

      };
    
    var valuedata = JSON.stringify(databawa);
    console.log(valuedata);
 
    user_id = $.cookie(window.cookie_prefix + "user_id");
    token = $.cookie(window.cookie_prefix + "token");
    star = id;
    if(star == 1){
        
        $("#facs").empty();
        
        var form_data = {
            status       : star,
            user_id      : user_id,
            name     : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>createprofileu3/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            console.log(response.data.hasil);
            if (response.success) {
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    console.log(entry);
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><i class="material-icons">star</i></button>');
                });
                    
            } else {

            }
        }).fail(function(xhr, status, message) {

            console.log('ajax create error:' + message);
        });
        
        
    }else{
         $("#facs").empty();
         var form_data = {
            status       : star,
            user_id      : user_id,
            name     : val,
            child : valuedata
        }
         $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>createprofileu3/create_pav" + "?sess_user_id=" + user_id + "&sess_token=" + token,
            data: JSON.stringify(form_data),
            dataType: 'json',
            contentType: 'application/json; charset=utf-8'
        }).done(function(response) {
            console.log(response);
                var dda = response.data.hasil;
                dda.forEach(function(entry, index) {
                    $("#facs").append( '<button class="btn btn-link waves-effect" href="javascript:void(0)" id="btn_'+index+'" onclick="addleft(1,'+index+',&#34;'+entry['id_single_source']+'&#34;)" >'+entry['id_single_source']+'</a> <a href="javascript:void(0)"  onclick="favorite(0,&#34;'+entry['id_single_source']+'&#34;)" ><i class="material-icons">star</i></button>');
                });

        }).fail(function(xhr, status, message) {

            console.log('ajax create error:' + message);
        });
    }
    
    
         
}    
    
function masuk(val){
   
    $('#list').empty();
    var sc = [];
    sc.push(val);
    console.log(val); 
    console.log(sc); 
    return false;
      var newdata = sc;
      var dd = [];
        var text = '';
                            for(var i = 0; i < newdata.length; i++){
                 
                  
                 var ss = newdata[i].split("=");
                 
                    dd.push(ss);
                  
                  
                };
 console.log(dd);
      dd.forEach(function(entry, index) {

            if(entry[0] != "j1"){


                    text = "<h4 id='"+entry[1]+"'><span class='label label-success'>"+entry[0]+"</span></h4>";
            $('#list').append(text);
            }



            $("#profile_"+index).change(function() {
                $("#profile_"+index+" option").each(function() {
                    var val = $(this).val();
                    var tempVal1 = $("#profile_"+index).val();

                    if(tempVal1.indexOf(val) >= 0 && optVal1.indexOf(val) < 0) {
                        optVal1.push(val);
                    } else if(tempVal1.indexOf(val) < 0 && optVal1.indexOf(val) >= 0) {
                        optVal1.splice(optVal1.indexOf(val) , 1);
                    }

                })

            });
      });




}    
    
function arraypush(datas){
  newdata = [];
   newdata = datas;
}
function getCreate(){
    $(".alert").hide();
    user_id = $.cookie(window.cookie_prefix + "user_id");
    token = $.cookie(window.cookie_prefix + "token");
       document.getElementById('toggler').style.visibility = 'hidden';
    
    $(".preloader").show();
      
      $("#btn_submit").attr('disabled', 'disabled');
    
        var nas = $("#name").val() ;  
    if(nas){
                $("#dang").empty();
                var form_data = {
                        list     : newdata,
                        isi      : optVal1,
						user_id	 : user_id,
                        name     : $("#name").val()
                    }

                    console.log(form_data);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url();?>createprofileu3/create_profiling" + "?sess_user_id=" + user_id + "&sess_token=" + token,
                        data: JSON.stringify(form_data),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
                        $(".alert").hide();
                        $(".preloader").hide();
                         document.getElementById('toggler').style.visibility = 'visible';

                        if (response.success) {
                            $(".alert-success").show();
                            $(".alert-success .content").html(response.message);
                        } else {
                            $("#btn_submit").removeAttr('disabled');
                            $(".alert-danger").show();
                            $(".alert-danger .content").html(response.message);
                        }
                    }).fail(function(xhr, status, message) {
                        document.getElementById('toggler').style.visibility = 'visible';
                         $(".preloader").hide();
                        $("#btn_submit").removeAttr('disabled');
                        console.log('ajax create error:' + message);
                    });
        }else{
              document.getElementById('toggler').style.visibility = 'visible';
               $(".preloader").hide();
             $('#dang').append("Name not be empty!");
        }
      
  }
  
</script>
  <div class="container-fluid">
      <div class="block-header">
        <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <h5>CREATE YOUR OWN MENU</h5>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
          
                  <!--button type="button" class="btn btn-default waves-effect">New</button>
                  <button type="button" class="btn btn-primary waves-effect">Open</button-->
                  
                  <!--button type="button" class="btn btn-info waves-effect">Save As</button-->
          </div>
          
        </div>
      </div>
      
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <div class="card" >
                        <div class="header bg-blue-grey">
                            <h2>
                                 Favorite Profiling
                            </h2>
                        </div>
                <div class="body" >
                                <span id="facs"></span>
                        </div>
                    </div>
                </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                    <div class="card" >
                        <div class="header bg-blue-grey">
                            <h2>
                                Group
                            </h2>
                        </div>
               <div class="body" >

                                  <p>
                                        <strong>Search Group: </strong>
                                    </p>
                                      
                                   <div class="form-line" >
                                        <input type="text" class="search-input form-control"  id="searchjtree" placeholder="Search">
<!--                                        <input type="text" class="form-control" data-provide="typeahead"  id="mytextquery" placeholder="Search">-->
                                    </div>


                                 
                                 
                         <div class="menu " style="height:400px;overflow-y: scroll;">
              
                <div id="jstree2" class="demo" style="margin-top:2em;"></div>
                             
                              

        
              </div>
                             
                        </div>
                    </div>
                </div>    
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                    <div class="card" >
                        <div class="header bg-blue-grey">
                            <h2>
                                 Selection
                            </h2>
                        </div>
               <div class="body" >
                               

                <div class="menu " style="height:400px;overflow-y: scroll;">
                                   
                      <span id="list" name="list"></span>
                      <span id="option" name="option"></span>
                    
                  

                </div>
                <br>
                  <button type="button" class="btn btn-success waves-effect " data-toggle="modal" data-target="#defaultModal">Save</button>
                <br>
                        </div>
                    </div>
                </div>
        
      
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Save Profile</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" />
                                            <span id="dang" style="color: red"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                             <div class="preloader">
                                    <div class="spinner-layer pl-red-grey">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            <button type="button" class="btn btn-link waves-effect" id="toggler" onclick="getCreate()">SAVE</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>  
        
      
  </div>
  