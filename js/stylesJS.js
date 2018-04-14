function slideBodyCard(e){
  e.preventDefault();
  var idObj = $(this).attr('id').replace('imgTxtCard-', '');
  var bodyCard= "#bodyCard-"+idObj;
  $(".bodyCard").not($(bodyCard)).slideUp(520);
  $(bodyCard).slideDown(420);
};

// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
  if (Notification.permission !== "granted")
    Notification.requestPermission();
});

function notifyMe() {
  //If notification is not valid in your browser show the alert
  if (!Notification) {
    alert('Desktop notifications not available in your browser. Try Chromium.');
    return;
  }
  //If you haven't permission for the notification this request the permission
  if (Notification.permission !== "granted")
    Notification.requestPermission();
  else {
    //Create the notification in var "notification"
    var notification = new Notification('Notification title', {
      icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
      body: "Hey there! You've been notified!",
      image: "https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&h=350"
    })
    //After four seconds the notification will be close
    setTimeout(notification.close.bind(notification), 4000);
    ;
    //If you click in the notification you will be redirected to the page
    notification.onclick = function () {
      var page = "https://stackoverflow.com/a/13328397/1269037"
      window.open(page);
    };

  }

}
