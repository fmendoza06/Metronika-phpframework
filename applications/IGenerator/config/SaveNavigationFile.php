<html>
<head>
       <title>Save Navigation Configuration File</title>
</head>
<body>
<h2>Save Navigation Configuration File</h2>
<hr>
<?php

/* Esto es para independizar el pear y el ado del include_path de PHP*/
global $saveconfiguration;
$saveconfiguration="S";

require_once "config.inc.php";
require_once "Data/Serializer.class.php";

$Navigation_config = array (
    'default_action' => 'default',
    'error_view' => 'error',
    'login_view' => 'Login',
    'commands' => array (
        'default' => array(
            'class' => 'DefaultCommand',
            'views' => array (
                'success' => array(
					'view' => 'Form_Presentacion',
					'redirect' => 0
				    ),
				'fail' => array(
					'view' => 'error',
					'redirect' => 0
				    )
				)
			),
        'CmdSelectDir' => array(
                'class' => 'CmdSelectDir',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Dir',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'default',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdBackSelectDir' => array(
                'class' => 'CmdBackSelectDir',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Dir',
                        'redirect' => 0
                        )
                    )
                ),				
        'CmdDefaultConexionBD' => array(
                'class' => 'CmdDefaultConexionBD',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Conexion_BD',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Dir',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdBackConexionBD' => array(
                'class' => 'CmdBackConexionBD',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Conexion_BD',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdDefaultInformacionAplicacion' => array(
                'class' => 'CmdDefaultInformacionAplicacion',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Informacion_Aplicacion',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Conexion_BD',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdBackInformacionAplicacion' => array(
                'class' => 'CmdBackInformacionAplicacion',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Informacion_Aplicacion',
                        'redirect' => 0
                        )
                    )
                ),                
        'CmdDefaultLookAndFeel' => array(
                'class' => 'CmdDefaultLookAndFeel',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Look_And_Feel',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Informacion_Aplicacion',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdBackLookAndFeel' => array(
                'class' => 'CmdBackLookAndFeel',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Look_And_Feel',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdDefaultComponentes' => array(
                'class' => 'CmdDefaultComponentes',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Componentes',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Look_And_Feel',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdBackComponentes' => array(
                'class' => 'CmdBackComponentes',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Componentes',
                        'redirect' => 0
                        )
                    )
                ),                  
        'CmdDefaultTablasBD' => array(
                'class' => 'CmdDefaultTablasBD',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Tablas_BD',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Componentes',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdTablasBbIframe' => array(
                'class' => 'CmdTablasBbIframe',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Iframe_Tablas_BD',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Informacion_Aplicacion',
                        'redirect' => 0
                        )
                    )
                ),
        'CmdGenerarAplicacion' => array(
                'class' => 'CmdGenerarAplicacion',
                'views' => array (
                    'success' => array(
                        'view' => 'Form_Resultado',
                        'redirect' => 0
                        ),
                    'fail' => array(
                        'view' => 'Form_Tablas_BD',
                        'redirect' => 0
                        )
                    )
                )
 	    ),
	'views' => array(
	    'Form_Presentacion'=> array (
            'template' => 'Form_Presentacion.tpl'
            ),
        'Form_Dir' => array (
            'template' => 'Form_Dir.tpl'
            ),
        'Form_Conexion_BD' => array (
            'template' => 'Form_Conexion_BD.tpl'
            ),
        'Form_Informacion_Aplicacion' => array (
            'template' => 'Form_Informacion_Aplicacion.tpl'
            ),
        'Form_Look_And_Feel' => array (
            'template' => 'Form_Look_And_Feel.tpl'
            ),
        'Form_Componentes' => array (
            'template' => 'Form_Componentes.tpl'
            ),
        'Form_Tablas_BD' => array (
            'template' => 'Form_Tablas_BD.tpl'
            ),
        'Form_Iframe_Tablas_BD' => array (
            'template' => 'Form_Iframe_Tablas_BD.tpl'
            ),
        'Form_Resultado' => array (
            'template' => 'Form_Resultado.tpl'
            )
        )
    );

echo "<pre>";
print_r($Navigation_config);
echo "</pre>";

$result =& Serializer::save($Navigation_config, 'web.conf.data');

if (PEAR::isError($result)) {
    echo "Error creating configuration file";
}

?>
</body>
</html>
