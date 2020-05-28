function filtrar_tabela() {
   // Declara variáveis 
   var input, filter, table, tr, td, i;
   input = document.getElementById("filtro");
   filter = input.value.toUpperCase();
   table = document.getElementById("tabela");
   tr = table.getElementsByTagName("tr");

   // Loop through all table rows, and hide those who don't match the search query
   for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[0];
      if (td) {
         if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
         } else {
            tr[i].style.display = "none";
         }
      } 
   }
}

var contador = 0

function redefinir_fonte() {
   document.getElementById("topo-pagina").style.fontSize = "medium"
   contador = 0
   localStorage.setItem('contador',0)
}

function aumentar_fonte() {
   switch(contador){
      case -3:
         document.getElementById("topo-pagina").style.fontSize = "x-small"
         contador++
         localStorage.setItem('contador',-2)
         break;
      case -2:
         document.getElementById("topo-pagina").style.fontSize = "small"
         contador++
         localStorage.setItem('contador',-1)
         break;
      case -1:
         document.getElementById("topo-pagina").style.fontSize = "medium"
         contador++
         localStorage.setItem('contador',0)
         break;
      case 0:
         document.getElementById("topo-pagina").style.fontSize = "large"
         contador++
         localStorage.setItem('contador',1)
         break;
      case 1:
         document.getElementById("topo-pagina").style.fontSize = "x-large"
         contador++
         localStorage.setItem('contador',2)
         break;
      case 2:
         document.getElementById("topo-pagina").style.fontSize = "xx-large"
         contador++
         localStorage.setItem('contador',3)
         break;
   }
}

function diminuir_fonte() {
   switch(contador){
      case -2:
         document.getElementById("topo-pagina").style.fontSize = "xx-small"
         contador--
         localStorage.setItem('contador',-3)
         break;
      case -1:
         document.getElementById("topo-pagina").style.fontSize = "x-small"
         contador--
         localStorage.setItem('contador',-2)
         break;
      case 0:
         document.getElementById("topo-pagina").style.fontSize = "small"
         contador--
         localStorage.setItem('contador',-1)
         break;
      case 1:
         document.getElementById("topo-pagina").style.fontSize = "medium"
         contador--
         localStorage.setItem('contador',0)
         break;
      case 2:
         document.getElementById("topo-pagina").style.fontSize = "large"
         contador--
         localStorage.setItem('contador',1)
         break;
      case 3:
         document.getElementById("topo-pagina").style.fontSize = "x-large"
         contador--
         localStorage.setItem('contador',2)
         break;
   }
}