<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" media="screen" type="text/css" href="<?=DOCUMENT_BASEPATH?>/assets/css/style.css">
	<title>Welcome to Peally</title>
</head>
<body>
	<div>
		<h2>Welcome to Peally</h2>
		<section>
			<h4>Controller</h4>
<?php
highlight_string('<?php 
class Example extends Core {
	public function index() {
		$this->load_model(\'time_model\');
		$this->data[\'time\'] = $this->model->time_model->format(time());
		$this->load_view(\'example\', $this->data);
    }
}
?>');
?>
		</section>
		<section>
			<h4>Model</h4>
<?php
highlight_string('<?php
class Time_model extends Core {
	public function format($time) {
		return date(\'r\', $time);
	}
}
?>');
?>
		</section>
		<section>
			<h4>View</h4>
<?php
highlight_string('<!DOCTYPE html>
<html>
	<head>
		<title>Welcome</title>
	</head>		
	<body>
		The time now is <?=$time?>. 
	</body>
</html>');
?>
		</section>
		<section>
		<h4>Output:</h4>
		<code>The time now is <?=date('r', time())?></code>
		</section>
	</div>
</body>
</html>