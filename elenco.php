<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once('lib/rb.php');
R::setup( 'mysql:host=127.0.0.1;dbname=pressione','pa', 'pressione' );
	

	$table='pressione';
	$record=(empty($_REQUEST['id'])) ?  R::dispense($table) : R::load($table, intval($_REQUEST['id']));	
	try {
		if ($record && !empty($_REQUEST['act']) && $_REQUEST['act']=='del') R::trash($record);
		if (!empty($_POST['datamisurazione'])){
			foreach ($_POST as $k=>$v){
				$record[$k]=$_POST[$k];
			}
			R::store($record);
		}
	} catch (RedBeanPHP\RedException\SQL $e) {
		?>
		<h4 class="msg label error">
			<?=$e->getMessage()?>
		</h4>
		<?php
	}	
	$pa=R::find($table);
        echo json_encode ($pa);
?>

