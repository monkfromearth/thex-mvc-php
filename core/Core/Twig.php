<?php

class Twig {

	public static function get(){
		$loader = new Twig_Loader_Filesystem('../core/Views');
		$twig = new Twig_Environment($loader);

		$flash = new Twig_SimpleFilter('flash', function($code, $message, $type='danger'){
		    return '<div class="alert alert-'.$type.'"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>'.$code.'</strong> - '.$message.'</div>';
		});

		$twig->addFilter($flash);

		$url_for = new Twig_SimpleFilter('url_for', function($folderName, $fileName, $fileType = null){
			if ($fileType ==  null){
				$fileType = $folderName;
			}
		    return '/assets/'.$folderName.'/'.$fileName.'.'.$fileType;
		});

		$twig->addFilter($url_for);

		$lexer = new Twig_Lexer($twig, [
		    'tag_block' => ['{', '}'],
		    'tag_variable' => ['{{', '}}']
		]);

		$twig->setLexer($lexer);

		return $twig;
	}

}

?>