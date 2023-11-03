var data1 = [{
  "id": "W",
  "text": "World",
  "state": { "opened": true },
  "children": [
                {"text": "Asia", "state": { "opened": false }, "children": [
                  {"id": "china", "text":"China"},
                  {"id" : "korea", "text":"Korea"},
                  {"id":"japan", "text":"Japan"}
                  ]
                },
                {"text": "Africa",  "state": { "opened": false }, "children": [
                  {"id":"somalia", "text":"Somalia"},
                  {"id":"mali", "text":"Mali"},
                  {"id":"ghana", "text": "Ghana"}
                  ]
                },
                {"text": "America",  "state": { "opened": false }, "children": [
                  {"id":"usa", "text":"USA"},
                  {"id":"mexico", "text":"Mexico"},
                  {"id":"canada", "text": "Canada"}
                  ]
                },
                {"id":"australia", "text": "Australia"},
                {"text": "Europe", "state": { "opened": false }, "children": [
                  {"id":"france", "text":"France"},
                  {"id":"germany", "text":"Germany"},
                  {"id":"uk", "text": "UK"}
                  ]
                }
              ]
}];
var listChecked=[];
$('#Tree').jstree({
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
        checkAllChild(getNode(node, data.node.text));
    }
    else{
        unCheckAllChild(getNode(node, data.node.text));
    }
})

$(document).ready(function() {
});

var to = false;
$('#search').keyup(function () {
  if(to) { clearTimeout(to); }
  to = setTimeout(function () {
    var v = $('#search').val();
    $('#Tree').jstree(true).search(v);
  }, 250);
});

function hasChildren(node) {
  if (node.children !== undefined) {
    return true;
  } else {
    return false;
  }
}

function getNode(data, nodeText) {
  var result;
  if (data.text === nodeText) {
    return data;
  } else {
    if (hasChildren(data)) {
      var i=0;
      for (i=0; i<data.children.length; i++) {
        result = getNode(data.children[i], nodeText);
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

function checkAllChild(node) {
  if (!hasChildren(node)) {
    var div =$('<div class="urate-tag urate-profile-tag urate-favorite-tag" title="node_'+node.id+'">'+node.text+'<div class="close-tag"><div class="close-mark"></div></div><div class="favorite-tag"><div class="favorite-mark"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></div></div></div>');
    listChecked.push("node_"+node.id)

    div.find('.close-tag').on('click',function(){
        $("#Tree").jstree("uncheck_node", node.id);
        $(this).closest('.urate-tag').remove();
    });
    $("#parameter-result").append(div);

    var $this = div;
    favFunct($this, $('#parameter-result'), $('#favoritePanel'));
    removeFunct($this, $('#parameter-result'), $('#favoritePanel'));

  } else {
    for (var i=0; i<node.children.length; i++) {
      checkAllChild(node.children[i]);
    }
  }

}

function unCheckAllChild(node) {
  if (!hasChildren(node)) {
    if (listChecked.indexOf("node_"+node.id) !== -1) {
      listChecked.splice(listChecked.indexOf("node_"+node.id), 1);
      $("[title='node_"+node.id+"']").remove();
    }
  } else {
    for (var i=0; i<node.children.length; i++) {
      unCheckAllChild(node.children[i]);
    }
  }
}

function favFunct($this, $parent, $targetParent) {
  $this.find('.favorite-mark').click(function() {
    //console.log('clicked');
    if (!($(this).hasClass('favorited'))) {
      $(this).addClass('favorited');
      var $tag = $(this).closest('.urate-tag')[0].innerHTML;
      var $tagTitle = $(this).closest('.urate-tag').attr('title');
      $targetParent.append('<div class="urate-tag urate-favorite-tag" title="'+$tagTitle+'">'+$tag+'</div>');
      $targetParent.find('.close-tag').remove();
      removeFavFunct($targetParent, $parent);
    }
    else {
      var $tagTitle = $(this).closest('.urate-tag').attr('title');
      $parent.find('.urate-tag[title="'+$tagTitle+'"] .favorite-mark').removeClass('favorited');
      $targetParent.find('.urate-tag[title="'+$tagTitle+'"]').remove();
    }
  });

}

function removeFunct($this, $parent, $targetParent) {
  $this.find('close-tag').click(function() {
    var $tagTitle = $(this).closest('.urate-tag').attr('title');
    $('#parameter-result').find('.urate-tag[title="'+$tagTitle+'"]').find('.favorite-mark').removeClass('favorited');
    $('#favoritePanel').find('.urate-tag[title="'+$tagTitle+'"]').remove();
  });
}

function removeFavFunct($parent, $targetParent) {
  $parent.find('.urate-tag .favorited').click(function() {
    var $tagTitle = $(this).closest('.urate-tag').attr('title');
    $targetParent.find('.urate-tag[title="'+$tagTitle+'"] .favorite-mark').removeClass('favorited');
    $parent.find('.urate-tag[title="'+$tagTitle+'"]').remove();
  })
}
