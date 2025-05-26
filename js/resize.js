//  Javascript - 20120305
// RESIZE WINDOW  - Altura e Largura da Janela (Pagina)

var w = screen.width
if(w>=1680){
  var Width = 1250
  var Height = 775 // 15px more height for Safari than with the other browsers

} else if(w=1024) {
  var Width = 1024
  var Height = 768 // 15px more height for Safari than with the other browsers    
} else if(w<1024) {   
  alert("A resolução da tela do seu monitor para esse site é\n RECOMENDÁVEL no mínimo  1024x768 ")
}    
/*
else if(w<=835){
var Width = screen.availWidth
var Height = screen.availHeight

}
else{
var Width = screen.availWidth
var Height = screen.availHeight

}
*/
var posX = (screen.availWidth - Width) / 2
var posY = (screen.availHeight - Height) / 2

self.moveTo(posX,posY);
self.resizeTo(Width,Height);