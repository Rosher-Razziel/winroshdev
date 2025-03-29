// FUNCION PARA OCULTAR O MOSTRAR EL MENU.
function desplegarMenu(){
  // console.log($("#menu").hasClass("sb-sidenav-toggled"));
  //Con hasClass sabemos si exite la clase o no
  if($("#menu").hasClass("sb-sidenav-toggled")){
    $('#menu').removeClass('sb-sidenav-toggled');
  }else{
    $('#menu').addClass('sb-sidenav-toggled');
  }
}
