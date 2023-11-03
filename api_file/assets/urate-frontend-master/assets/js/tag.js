$('.urate-tag.urate-profile-tag').append('<div class="close-tag"><div class="close-mark"></div></div>');

$('.urate-tag.urate-favorite-tag').append('<div class="favorite-tag"><div class="favorite-mark"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></div></div>');


$('.close-tag').click(function() {
  $(this).closest('.urate-tag').remove();
});
