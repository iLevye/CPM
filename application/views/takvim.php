<? include('header.php'); ?>

<?
$this->load->javascript('takvim');
?>

<script type="text/javascript">


	$(document).ready(function(){
		$("#takvim").takvim({
			source : base_url + "task_management/sample/",
			start : "2012-02-22"
		});


		$("td").live('click', function(){
			alert($(this).position().left);
			//var pos = $("[user_id=1] .g3").html();
		});

				

	});
</script>
<style>
	#takvim {float:left;}
	#taktable td{width: 200px; height:60px; border:1px solid black;}
	#taktable .baslik td {height:20px;}
	#tasks {position:absolute; height: 100%; width:100%; float:left; border:1px solid red;}
	.task {float:left; background: red; border: 2px solid white; position:absolute;}
</style>
</head>
<body>


<div id="takvim">

</div>