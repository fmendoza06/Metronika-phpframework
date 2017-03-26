

	function trabajosInit() {
        alert('Coti File:');
        coti=ap_getObj('trabajos__FILECOTI');
        alert('Coti File:'+coti.value);
                //Verifico si existe archivo de Cotizacion
		if (coti.value != "")
		{           alert('Entre 1');
			blocking('loadfilecoti');
			//visi('loadfilecotiicons');
                }
		else
		{       
			blocking('loadfilecotiicons');
			//visi('loadfilecoti');
        }

        //Verifico si existe archivo de Imagen
        img=ap_getObj('trabajos__FILEIMAGE');
		if (img.value != "")
		{
			blocking('loadfileimages');
			//visi('loadfileimagesicons');
        }
		else
		{
			blocking('loadfileimagesicons');
			//visi('loadfileimages');
        }
   }

	function popUpShowImage(forma) { 
		//if (forma.trabajos__FILEIMAGE.value != "") {
            alert('Esta es la imagen');
			var hori,vert,wid,hei;
			wid = (screen.width - 12);
			hei = (screen.height - 60);
			hori = 0;
			vert = 0; alert('Voy a abrrir la ventana');
			abr = window.open('index.php?action=gmserviceCmdViewTrabajosImage&file=' + document..trabajos__FILEIMAGE.value,'ShowImageREQUERIM','width=' + wid + ',height=' + hei + ',status=1,scrollbars=0,resizable=0,top=' + vert + ',left=' + hori);
		//}
	}
	
	function popUpShowCoti(forma) {
		if (forma.trabajos__FILECOTI.value != "") {
			var hori,vert,wid,hei;
			wid = (screen.width - 12);
			hei = (screen.height - 60);
			hori = 0;
			vert = 0;
			abr = window.open('index.php?action=gmserviceCmdViewTrabajosImage&file=' + forma.trabajos__FILECOTI.value,'ShowImageREQUERIM','width=' + wid + ',height=' + hei + ',status=1,scrollbars=0,resizable=0,top=' + vert + ',left=' + hori);
		}
	}
	
	
	/***************************************************************************************
		NOMBRE DE LA FUNCIÓN :	blocking(nr)
		ARGUMENTOS :			nr :	Cadena con el nombre del objeto que quiero 
										aparecer/desaparecer.
		RETORNO :				SR (sin retorno)
		FUNCIONALIDAD : 
		 Esta función aparece/desaparece un elemento/objeto de una forma.
		ANOTACIONES :
		- Esta función desaparece ese objeto como si quitara el objeto, aunque lo que 
		  este incluido dentro de el permanecera con las mismas propiedades para ser 
		  evaluadas.
		Creado Por :		José Fernando Mendoza
		Empresa :		Spyro Softlutions
		Fecha de Creación :	23 - 06 - 2006
	***************************************************************************************/
	function blocking(nr)
	{
		if (document.layers)
		{
			current = (document.layers[nr].display == 'none') ? 'block' : 'none';
			document.layers[nr].display = current;
		}
		else if (document.all)
		{
			current = (document.all[nr].style.display == 'none') ? 'block' : 'none';
			document.all[nr].style.display = current;
		}
		else if (document.getElementById)
		{
			vista = (document.getElementById(nr).style.display == 'none') ? 'block' : 'none';
			document.getElementById(nr).style.display = vista;
		}
	}
	
	/***************************************************************************************
		NOMBRE DE LA FUNCIÓN :	visi(nr)
		ARGUMENTOS :			nr : 	Cadena con el nombre del objeto que quiero
										visibilizar/invisibilizar.
		RETORNO :				SR (sin retorno)
		FUNCIONALIDAD : 
		 Esta función visibilizar/invisibilizar un elemento/objeto de una forma.
		ANOTACIONES :
		- Esta funcion desaparece el objeto pero el espacio en el que se encontraba seguira 
		  siendo ocupado aún si no se ve.
		Creado Por :		Jose Fernando Mendoza
		Empresa :			Spyro Softlutions
		Fecha de Creación :	23 - 06 - 2006
	***************************************************************************************/
	function visi(nr)
	{
		if (document.layers)
		{
			vista = (document.layers[nr].visibility == 'hide') ? 'show' : 'hide'
			document.layers[nr].visibility = vista;
		}
		else if (document.all)
		{
			vista = (document.all[nr].style.visibility == 'hidden') ? 'visible'	: 'hidden';
			document.all[nr].style.visibility = vista;
		}
		else if (document.getElementById)
		{
			vista = (document.getElementById(nr).style.visibility == 'hidden') ? 'visible' : 'hidden';
			document.getElementById(nr).style.visibility = vista;
	
		}
	}

/***************************************************************************************
		FUNCTION NAME :	ap_getObj(name)
		ARGS          :
                                name    : nombre del objeto a buscar


		RETURN        : OBJ
		FUNCIONALITY  : Retorna un objeto buscado
		NOTES         :
		CREATE BY     :	José Fernando Mendoza
		COMPANY       :	SPYRO SOLUTIONS
		DATE          :	16 - FEB - 2007
***************************************************************************************/

function ap_getObj(name) {
	if (document.getElementById) {
		return document.getElementById(name);
	} else if (document.all) {
		return document.all[name];
	} else if (document.layers) {
			return document.layers[name];
	}
}