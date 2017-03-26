var numLinesAdded = 1;
//Funcion para asignar el foco
function focusNext(tBox){
    var name = tBox.name;
    var index = name.substring(name.indexOf('_')+1);
	var cont = tBox.value;
	//document.all.preoculto.value=cont;
  }

//Funcion para escribir una fila
function generateRow() {
      var d       = document.getElementById("div");
      var sujetos = document.getElementById("cansujetos");
      
      var nomvaltipoim = '';
      var nomvalsujeto = 0;
      var susotisi     ='00';
      var susosuim     = '0';
      
      if (sujetos.value > 0 )
      {
         nomvaltipoim = "susotisi_" + sujetos.value;
	 nomvalsujeto = "susosuim_" + sujetos.value;
         //alert (nomvalsujeto);        
         susotisi = document.getElementById(nomvaltipoim);
         //alert (nomvaltipoim);
         susosuim = document.getElementById(nomvalsujeto);
      }
      

      if (sujetos.value >= 0 )
      { 
        if ((susotisi != '00' &&  susosuim > 0)|| (sujetos.value > 0))
        {
	    if(numLinesAdded <=10)
	    {
 	     d.innerHTML+="<SELECT  name='susotisi_"+numLinesAdded+"'"+
                       " width=15% id='susotisi_"+numLinesAdded+"' class='detailedViewTextBox' >"+
                       " <option value='00'>-- Seleccione --</option> "+
                       " <option value='01'>Predio</option> "+
                       " <option value='02'>Establecimiento</option> "+
                       " <option value='03'>Rentas Varias</option> "+
                       " <option value='04'>Plaza de Mercado</option> "+
                       "</SELECT> "+
                       "<input type='string' class=detailedViewTextBox size='20' maxlength='20' name='susosuim_" + numLinesAdded +"'"+
                       " id='susosuim_" + numLinesAdded+"' onkeypress='focusNext(this)'><br>";
            numLinesAdded++;
          
      
           sujetos.value = (sujetos.value)+1;
          } 
        }
        else 
        {
         alert("Debe ingresar un sujeto de impuesto 1");
        }
     }
     else
     {
         alert("Debe ingresar un sujeto de impuesto 2");
     }

}