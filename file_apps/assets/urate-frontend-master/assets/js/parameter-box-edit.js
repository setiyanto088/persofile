var data1 = [{
  "id": "W",
  "text": "World",
  "state": { "opened": true },
  "children": [
                {"text": "Asia", "state": { "opened": false }, "children": [
                  {"text":"China", "id": "china"},
                  {"text":"Korea", "id" : "korea"},
                  {"text":"Japan", "id":"japan"}
                  ]
                },
                {"text": "Africa",  "state": { "opened": false }, "children": [
                  {"text":"Somalia", "id":"somalia"},
                  {"text":"Mali", "id":"mali"},
                  {"text": "Ghana", "id":"ghana"}
                  ]
                },
                {"text": "America",  "state": { "opened": false }, "children": [
                  {"text":"USA", "id":"usa"},
                  {"text":"Mexico", "id":"mexico"},
                  {"text": "Canada", "id":"canada"}
                  ]
                },
                {"text": "Australia", "id":"australia"},
                {"text": "Europe", "state": { "opened": false }, "children": [
                  {"text":"France", "id":"france"},
                  {"text":"Germany", "id":"germany"},
                  {"text": "UK", "id":"uk"}
                  ]
                }
              ]
}];
var listCheckedEdit=[];
$('#Tree-edit').jstree({
    "core": {
      "data": data1,
      "check_callback": false
    },
    "checkbox": {
      // "three_state" : false, // to avoid that fact that checking a node also check others
      "whole_node" : false,  // to avoid checking the box just clicking the node
      "tie_selection" : false, // for checking without selecting and selecting without checking
      "keep_selected_style": false
    },
    "search": { 
        "show_only_matches": true,
        "show_only_matches_children": true
    },
    "plugins": ["checkbox", "search"]
})
.on("check_node.jstree  uncheck_node.jstree", function(e, data) {
    var node = data1[0];
    if(data.node.state.checked)
    {
        checkAllChildEdit(getNodeEdit(node, data.node.text));
    }
    else{
        unCheckAllChildEdit(getNodeEdit(node, data.node.text));
    }
})

$(document).ready(function() {
  $('#parameter-result-edit').hover(function() {
    $(this).find('.urate-tag .favorite-mark').click(function() {
      if (!($(this).hasClass('favorited'))) {
        console.log('favorited');
        $(this).addClass('favorited');
        var $tag = $(this).closest('.urate-tag')[0].innerHTML;
        var $tagTitle = $(this).closest('.urate-tag').attr('title');
        $('#favoritePanelEdit').append('<div class="urate-tag urate-favorite-tag" title="'+$tagTitle+'">'+$tag+'</div>');
        $('#favoritePanelEdit').find('.close-tag').remove();
      }
      else {
        console.log('not favorite');
        var $tagTitle = $(this).closest('.urate-tag').attr('title');
        $('#parameter-result-edit').find('.urate-tag[title="'+$tagTitle+'"] .favorite-mark').removeClass('favorited');
        $('#favoritePanelEdit').find('.urate-tag[title="'+$tagTitle+'"]').remove();
      }
    });

    $(this).find('.urate-tag .close-tag').click(function() {
      var $tagTitle = $(this).closest('.urate-tag').attr('title');
      $('#parameter-result-edit').find('.urate-tag[title="'+$tagTitle+'"]').find('.favorite-mark').removeClass('favorited');
      $('#favoritePanelEdit').find('.urate-tag[title="'+$tagTitle+'"]').remove();
    });
  })

  $('#favoritePanelEdit').hover(function() {
    $(this).find('.urate-tag .favorited').click(function() {
      var $tagTitle = $(this).closest('.urate-tag').attr('title');
      $('#parameter-result-edit').find('.urate-tag[title="'+$tagTitle+'"] .favorite-mark').removeClass('favorited');
      $('#favoritePanelEdit').find('.urate-tag[title="'+$tagTitle+'"]').remove();
    })
  })
})
var to = false;
$('#search-edit').keyup(function () {
  if(to) { clearTimeout(to); }
  to = setTimeout(function () {
    var v = $('#search-edit').val();
    $('#Tree-edit').jstree(true).search(v);
  }, 250);
});


function hasChildrenEdit(node) {
  if (node.children !== undefined) {
    return true;
  } else {
    return false;
  }
}

function getNodeEdit(data, nodeText) {
  var result;
  if (data.text === nodeText) {
    return data;
  } else {
    if (hasChildren(data)) {
      var i=0;
      for (i=0; i<data.children.length; i++) {
        result = getNodeEdit(data.children[i], nodeText);
        if (result.length !== 0) {
          return result;
        }
      }
      return [];
    } else {
      return [];
    }
  }
}

function checkAllChildEdit(node) {
  if (!hasChildrenEdit(node)) {
    var div =$('<div class="urate-tag urate-profile-tag urate-favorite-tag" title="node_'+node.id+'">'+node.text+'<div class="close-tag"><div class="close-mark"></div></div><div class="favorite-tag"><div class="favorite-mark"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></div></div></div>');
    listCheckedEdit.push("node_"+node.id)

    div.find('.close-tag').on('click',function(){
        $("#Tree-edit").jstree("uncheck_node", node.id);
        $(this).closest('.urate-tag').remove();
    });
    $("#parameter-result-edit").append(div)
  } else {
    for (var i=0; i<node.children.length; i++) {
      checkAllChildEdit(node.children[i]);
    }
  }
}

function unCheckAllChildEdit(node) {
  if (!hasChildrenEdit(node)) {
    if (listCheckedEdit.indexOf("node_"+node.id) !== -1) {
      listCheckedEdit.splice(listCheckedEdit.indexOf("node_"+node.id), 1);
      $("[title='node_"+node.id+"']").remove();
    }
  } else {
    for (var i=0; i<node.children.length; i++) {
      unCheckAllChildEdit(node.children[i]);
    }
  }
}