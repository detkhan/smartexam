$$(document).on("click", ".testpage_choice li", function() {
  $$( ".testpage_choice li" ).removeClass('select');
  $$(this).addClass('select');
});
