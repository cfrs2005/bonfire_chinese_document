<?php
/**
 * index.php
 * ==============================================
 * Copy right 2013-2014 http://www.80aj.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @param unknowtype
 * @return return_type
 * @author: aj
 * @date: 2015-6-18
 * @version: v1.0.0
 */
spl_autoload_register ( function ($class) {
	require preg_replace ( '{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim ( $class, '\\' ) ) . '.php';
} );

use \Michelf\Markdown;
define ( DOCS_PATH, 'docs/' );

$site_name="BONFIRE学习";
$site_desc="BONFIRE学习";
$site_short_desc='基于CI框架的RBAC框架';

$artilce_index = $_GET ['ai'];
if(!empty($artilce_index)){
	$text = file_get_contents ( DOCS_PATH . $artilce_index . '.md' );
}else{
	$text = file_get_contents ( 'index.md' );
}
$tocFile = "_toc.ini";
$memnulist = array ();
$file_list = parse_ini_file ( $tocFile, true );
$html = Markdown::defaultTransform ( $text );
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title><?php echo $artilce_index;?> - <?php echo $site_name;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="assets/web.min.css" />
<script type="text/javascript" src="assets/web.min.js"></script>


</head>
<body>

	<header class="navbar navbar-static-top navbar-default" role="banner">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo $_SERVER['DOCUMENT_URI'];?>" title="<?php echo $site_name;?>"><?php echo $site_name;?></a>
				<button id="wiki-nav-toggle" data-target="#wiki-nav"
					data-toggle="collapse" type="button"
					class="navbar-toggle collapsed">
					<span class="sr-only"></span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
			</div>
			<p class="navbar-text hidden-xs"><?php echo $site_short_desc;?></p>
		</div>
	</header>

	<div class="container-fluid">

		<div class="row">

			<nav id="wiki-nav" class="col-sm-4 col-md-3 collapse in"
				role="navigation">
				<div class="list-group">
						<?php
						$i = 1;
						foreach ( $file_list as $key => $item ) {
							?>
							
<a class="list-group-item <?php if($artilce_index=="" && $i==1) echo "active";?>"
						href="#wiki-nav-<?php echo $i;?>" data-toggle="collapse"><?php echo $key;?> <b
						class="caret"></b></a>
					<div
						class="submenu panel-collapse collapse 
<?php
							foreach ( $item as $itemkey => $itemval ) {
								if ($artilce_index == str_replace ( 'developer/', "", $itemkey ))
									echo "in";
							}
							?>"
						id="wiki-nav-<?php echo $i;?>">
<?php foreach($item as $itemkey =>$itemval){?>
<a
							class="list-group-item <?php if($artilce_index==str_replace('developer/', "", $itemkey))  echo "active";?>"
							href="?ai=<?php echo str_replace('developer/', "", $itemkey);?>"><?php echo $itemval;?></a>
<?php }?>
</div>
							
							<?php
							$i ++;
						}
						?>
				</div>
			</nav>

			<section id="wiki-content" class="col-sm-8 col-md-9" role="main">
				<?php
				echo $html;
				?>
			</section>

		</div>

	</div>

	<footer id="wiki-footer" role="contentinfo">
		<div class="container-fluid">
			<p class="text-muted">
				Powered by <a href="http://www.80aj.com" target="_blank">80AJ</a>.
			</p>
		</div>
	</footer>
</body>
</html>