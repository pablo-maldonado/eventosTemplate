function slideBodyCard(e){
  e.preventDefault();
  var idObj = $(this).attr('id').replace('imgTxtCard-', '');
  var bodyCard= "#bodyCard-"+idObj;
  $(".bodyCard").not($(bodyCard)).slideUp(520);
  $(bodyCard).slideDown(120);
};
