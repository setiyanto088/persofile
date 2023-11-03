var data =
[
  {
    "id": "48",
    "name": "Female 30-34",
    "people": "140407",
    "grouping": "[[{\"Tag\":\"MAJOR CITIES\",\"Operation\":{\"CITIES\":[\"CJAKAR\"]},\"Data\":[\"Jakarta\"],\"ANDOR\":\"AND\"},{\"Tag\":\"SEX\",\"Operation\":{\"TSEX\":[\"FEMALE\"]},\"Data\":[\"Female\"],\"ANDOR\":\"AND\"}],[{\"Tag\":\"AGE - detailed\",\"Operation\":{\"D_AGE\":[\"AGE-30-34\"]},\"Data\":[\"30-34\"],\"ANDOR\":\"AND\"},{\"Tag\":\"MAJOR CITIES\",\"Operation\":{\"CITIES\":[\"CJAKAR\"]},\"Data\":[\"Jakarta\"],\"ANDOR\":\"AND\"}]]",
    "status": "1",
    "flag": "1"
  },
  {
    "id": "9007199254741003",
    "name": "haibar",
    "people": "10486195",
    "grouping": "[[[{\"Tag\":\"MAJOR CITIES\",\"Operation\":{\"CITIES\":[\"CJAKAR\"]},\"Data\":[\"Jakarta\"],\"ANDOR\":\"AND\"},{\"Tag\":\"SEX\",\"Operation\":{\"TSEX\":[\"FEMALE\"]},\"Data\":[\"Female\"],\"ANDOR\":\"AND\"}],[{\"Tag\":\"AGE - detailed\",\"Operation\":{\"D_AGE\":[\"AGE-30-34\"]},\"Data\":[\"30-34\"],\"ANDOR\":\"AND\"},{\"Tag\":\"MAJOR CITIES\",\"Operation\":{\"CITIES\":[\"CJAKAR\"]},\"Data\":[\"Jakarta\"],\"ANDOR\":\"AND\"}]],[{\"Tag\":\"AGE - detailed\",\"Operation\":{\"D_AGE\":[\"AGE-30-34\"]},\"Data\":[\"30-34\"]},{\"Tag\":\"MAJOR CITIES\",\"Operation\":{\"CITIES\":[\"CJAKAR\"]},\"Data\":[\"Jakarta\"]}]]",
    "status": "3",
    "flag": null
  }
]

$(document).ready(function() {
	var div = "";
	var tags;
	//write all data
	for (var i=0; i<data.length; i++) {
		var arrTag = JSON.parse(data[i].grouping);
		var tags = getAllTag(arrTag);
		console.log(tags);
		div = '<div class="tag col-xs-12 col-sm-6 col-md-4" id="'+data[i].id+'">'+
				'<div class="urate-box-profile">'+
					'<div class="header">'+
						'<div>'+
							'<span class="title">'+data[i].name+'</span>'+
							'<span class="caption">'+data[i].people+' Population</span>'+
						'</div>'+
						'<div class="pull-right">'+
							'<button class="btn urate-icon-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn">'+
	                            '<span class="ion-android-more-horizontal"></span>'+
	                        '</button>'+
							'<ul class="dropdown-menu urate-action-dropdown">'+
								'<h4 class="action-title">Actions</h4>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalEditProfile">Edit</a></li>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalDeleteProfile">Delete</a></li>'+
							'</ul>'+
						'</div>'+
					'</div>'+
				'<div class="body">';
		for (var j=0; j<tags.length; j++) {
			div = div+'<div class="urate-tag urate-profile-tag">'+
						'<p>'+tags[j]+'</p>'+
					'</div>';
		}
		div = div+'</div>'+
			'</div>'+
		'</div>';
		$("#result-tag").append($(div));
	}
});

$('#search-tag').keyup(function () {
	$(".tag").each (function(){
		//remove
		$(this).remove();
	});
	var v = $('#search-tag').val();
	var div = "";
	var tags = "";
	if (v === "") {
		//write all data
		for (var i=0; i<data.length; i++) {
			var arrTag = JSON.parse(data[i].grouping);
			var tags = getAllTag(arrTag);
			console.log(tags);
			div = '<div class="tag col-xs-12 col-sm-6 col-md-4" id="'+data[i].id+'">'+
				'<div class="urate-box-profile">'+
					'<div class="header">'+
						'<div>'+
							'<span class="title">'+data[i].name+'</span>'+
							'<span class="caption">'+data[i].people+' Population</span>'+
						'</div>'+
						'<div class="pull-right">'+
							'<button class="btn urate-icon-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn">'+
	                            '<span class="ion-android-more-horizontal"></span>'+
	                        '</button>'+
							'<ul class="dropdown-menu urate-action-dropdown">'+
								'<h4 class="action-title">Actions</h4>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalEditProfile">Edit</a></li>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalDeleteProfile">Delete</a></li>'+
							'</ul>'+
						'</div>'+
					'</div>'+
					'<div class="body">';
			for (var j=0; j<tags.length; j++) {
				div = div+'<div class="urate-tag urate-profile-tag">'+
							'<p>'+tags[j]+'</p>'+
						'</div>';
			}
			div = div+'</div>'+
				'</div>'+
			'</div>';
			$("#result-tag").append($(div));
		}
	} else {
		//write matches data
		var count = 0;
		var tags;
		for (var i=0; i<data.length; i++) {
			if (data[i].name.toLowerCase().indexOf(v.toLowerCase()) !== -1) {
				count++;
				arrTag = JSON.parse(data[i].grouping);
				tags = getAllTag(arrTag);
				div = '<div class="tag col-xs-12 col-sm-6 col-md-4" id="'+data[i].id+'">'+
				'<div class="urate-box-profile">'+
					'<div class="header">'+
						'<div>'+
							'<span class="title">'+data[i].name+'</span>'+
							'<span class="caption">'+data[i].people+' Population</span>'+
						'</div>'+
						'<div class="pull-right">'+
							'<button class="btn urate-icon-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="action-btn">'+
	                            '<span class="ion-android-more-horizontal"></span>'+
	                        '</button>'+
							'<ul class="dropdown-menu urate-action-dropdown">'+
								'<h4 class="action-title">Actions</h4>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalEditProfile">Edit</a></li>'+
								'<li><a href="#" data-toggle="modal" data-target="#modalDeleteProfile">Delete</a></li>'+
							'</ul>'+
						'</div>'+
					'</div>'+
					'<div class="body">';
			for (var j=0; j<tags.length; j++) {
				div = div+'<div class="urate-tag urate-profile-tag">'+
							'<p>'+tags[j]+'</p>'+
						'</div>';
			}
			div = div+'</div>'+
				'</div>'+
			'</div>';
			$("#result-tag").append($(div));
			}
		}
		if (count === 0) {
			div = $('<div class="tag col-xs-12 col-sm-6 col-md-4"><div class="tag">No matches</div></div>');
			$("#result-tag").append(div);
		}
	}
});

// function getArrTag(data, id) {
// 	var found = false;
// 	var i=0;
// 	while (!found && i<data.length) {
// 		if (data[i].id === id) {
// 			found = true;
// 		} else {
// 			i++;
// 		}
// 	}

// 	if (found) {
// 		return data[i].grouping;
// 	} else {
// 		return [];
// 	}
// }

function getAllTag(arrTag) {
	var result = [];
	if (arrTag.Tag !== undefined) {
		result = result.concat(arrTag.Tag);
		return result;
	} else {
		for (var i=0; i<arrTag.length; i++) {
			result = result.concat(getAllTag(arrTag[i]));
		}
		return result;
	}
}