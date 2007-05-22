<?php

/*
** [type] file
** [name] parsedoc.php
** [author] Wim Paulussen
** [since] 2006-12-03
** [update] 2006-12-27 : testor for extend
** [todo] documentation of documentor !!
** [todo] read file tags
** [end]
*/

// include_once('./autoload.php');
include_once('./Session.php');
include_once('./Html.php');
include_once('./Head.php');
include_once('./Body.php');
include_once('./File.php');

$sessie = new Session;

//{{{ short explanation - needs updating
if (!isset($_GET['file']))
{
	echo 'usage : parsedoc.php?file=&lt;filename&gt;<br />';
	echo '<ul>parsed items
	<li>tags that are checked</li>
		<ul>
		<li>type</li>
		<li>name</li>
		<li>since</li>
		<li>author</li>
		<li>scope</li>
		<li>update</li>
		<li>todo</li>
		<li>class</li>
		<li>expl</li>
		<li>end</li>
		</ul>
	</ul>'; 
	echo 'Put your comment after ** and include the above words in squared brackets [].<br /> See underneath an example.<br />----<br />';

	echo '
	/*<br />
	** [type] attribute<br />
	** [name] name<br />
	** [scope] private<br />
	** [expl] holds name set in session<br />
	** [end]<br />
	*/<br />----';
	die();
}
//}}}

$file = $_GET['file'];
$data	= new File($file);

$expl_text = ''; // meerdere expl mogelijk;
$update_text = ''; // meerdere updates mogelijk;
$todo_text = ''; // meerdere todo's mogelijk
$extend = ''; // meerdere mogelijk

while ($data->readlines())
{
	if(substr(trim($data->line),0,2) == '**')
	{
		$lijn = trim($data->line);
		$posbegin = strpos($lijn,'[');
		$lijn = substr($lijn,$posbegin+1);
		$poseinde = strpos($lijn,']');
		$param = substr($lijn,0,$poseinde);
		$lijn = substr($lijn,$poseinde+1);
		$value = $lijn;

		switch($param)
		{
		case 'type':
			$type = $lijn;
			break;

		case 'name':
			$name = $lijn;
			break;

		case 'since':
			$since = $lijn;
			break;

		case 'author':
			$author = $lijn;
			break;
	
		case 'scope':
			$scope = $lijn;
			break;

		case 'update':
			$update_text .= "\r\n".$lijn;
			
			break;

		case 'todo':
			$todo_text .= "\r\n".$lijn;
			break;

		case 'class':
			$class = $lijn;
			echo 'class : '.$class.'<br />';
			break;

		case 'expl':
			$expl_text .= "\r\n".$lijn;
			break;

		case 'extend':
			$extend .= $lijn."#";
			break;

		case 'end':
			if (isset($type)) { echo 'type : '.$type.'<br />'; }
			if (isset($name)) { echo 'name : '.$name.'<br />'; }
			if (isset($scope)) { echo 'scope : '.$scope.'<br />'; } 
			if (isset($since)) { echo 'since : '.$since.'<br />'; }
			if (isset($author)) { echo 'author : '.$author.'<br />'; }

			if($expl_text != '') { echo 'expl : '.nl2br($expl_text).'<br />'; };
			if($extend != '') { echo 'extends : '.$extend.'<br />'; }
			if($update_text != '') {echo 'update_text : '.nl2br($update_text).'<br />'; }
			if($todo_text != '') { echo 'todo_text : '.nl2br($todo_text).'<br />'; }
			echo '<hr />';
			
			/*
			switch($type)
			{
			case 'file':
				break;
			default:
				break;
				
			}
			*/
			$expl_text = '';
			$update_text = '';
			$todo_text = '';
			$extend = '';
			unset($type);
			unset($name);
			unset($since);
			unset($author);
			unset($scope);
			
			// einde provisonele uitleg
			/*
			
			*/
			break;
			
		default:
			echo '<b>not defined : '.$lijn.'</b><br />';
			break;
		}
	}
}

?>