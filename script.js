function toggleMenu(){
  const nav = document.getElementById("navLinks");
  if(nav){ nav.classList.toggle("show"); }
}
function submitMessage(form, message){
  alert(message);
  form.reset();
  return false;
}
