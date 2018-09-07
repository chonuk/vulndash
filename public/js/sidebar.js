// Click handler can be added latter, after jQuery is loaded...
$('.sidebar-toggle').click(function(event) {
  event.preventDefault();
  if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
    sessionStorage.setItem('sidebar-toggle-collapsed', '');
  } else {
    sessionStorage.setItem('sidebar-toggle-collapsed', '1');
  }
});
  