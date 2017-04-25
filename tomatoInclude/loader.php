<?php
//tomato 로더
spl_autoload_register(function ($class) {
	$prefix = 'udemzisoft\\tomato\\';
	$base_dir = __DIR__.'/udemzisoft/tomato/src/';

	$len = strlen($prefix);

	if (strncmp($prefix,$class,$len) !== 0) {
		$relative_class = $class;
		// return;
	} else {
		$relative_class = substr($class,$len);
	}
	// $relative_class = $class;

	$interface_file = $base_dir.
		'interface.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($interface_file)) {
		require $interface_file;
	}

	$trait_file = $base_dir.
		'trait.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($trait_file)) {
		require $trait_file;
	}


	$class_file = $base_dir.
		'class.'.str_replace('\\','/',$relative_class).'.php';

	if (file_exists($class_file)) {
		require $class_file;
	}
});

spl_autoload_register(function ($class) {
	$prefix = 'udemzisoft\\tomato\\field\\';
	$base_dir = __DIR__.'/udemzisoft/tomato/src/field';

	$len = strlen($prefix);

	if (strncmp($prefix,$class,$len) !== 0) {
		$relative_class = $class;
		// return;
	} else {
		$relative_class = substr($class,$len);
	}
	// $relative_class = $class;

	$interface_file = $base_dir.
		'interface.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($interface_file)) {
		require $interface_file;
	}

	$trait_file = $base_dir.
		'trait.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($trait_file)) {
		require $trait_file;
	}


	$class_file = $base_dir.
		'class.'.str_replace('\\','/',$relative_class).'.php';

	if (file_exists($class_file)) {
		require $class_file;
	}
});

//boardSkin 로더

spl_autoload_register(function ($class) {
	$prefix = 'udemzisoft\\tomato\\boardSkin\\';
	$base_dir = __DIR__.'/src/boardSkin/';

	$len = strlen($prefix);

	if (strncmp($prefix,$class,$len) !== 0) {
		$relative_class = $class;
		// return;
	} else {
		$relative_class = substr($class,$len);
	}
	// $relative_class = $class;

	$interface_file = $base_dir.$relative_class.'/'.
		'interface.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($interface_file)) {
		require $interface_file;
	}

	$trait_file = $base_dir.$relative_class.'/'.
		'trait.'.str_replace('\\','/',$relative_class).'.php';
	if (file_exists($trait_file)) {
		require $trait_file;
	}

	$class_file = $base_dir.$relative_class.'/'.
		'class.'.str_replace('\\','/',$relative_class).'.php';

	if (file_exists($class_file)) {
		require $class_file;
	}
});