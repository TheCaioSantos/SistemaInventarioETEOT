$(".mascara-telefone").mask("(00) 0000-0000");
$("#celular-usuario").mask("(00) 00000-0000");
$("#cpf-usuario").mask("000.000.000-00");
$("#mascara-cnpj").mask("99.999.999/9999-99");
$('.mascara-dinheiro').mask('###0.00', {reverse: true});


$(document).ready(function() {
    $('.js-example-basic-single').select2();
});


$('#titulo-codigo-classificacao').on("change",function(){
	var codigoClassificacao = $('#titulo-codigo-classificacao').val()
	$.ajax({
		url: 'controller/codigo_classificacao.php',
		type: 'POST',
		dataType: 'json',
		data: {cod:codigoClassificacao},
		beforeSend: function(){
			$('#subtitulo-codigo-classificacao').css({'display':'block'});
			$('#subtitulo-codigo-classificacao').html("carregando...");
		},
		success: function(data)
		{
			var html = '<option value="">Selecione uma classificação...</option>';	
			for (var i = 0; i < data.length; i++) {
				html += '<option value="' + data[i][0] + '">' + data[i][3] + ' - ' + data[i][4] + '</option>';
			}

			$('#subtitulo-codigo-classificacao').html(html);
				//$('#subtitulo-codigo-classificacao').css({'display':'block'});
				//$('#subtitulo-codigo-classificacao').css(data);
			},
			error: function(data)
			{
				$('#subtitulo-codigo-classificacao').css({'display':'block'});
				$('#subtitulo-codigo-classificacao').css("Houve um erro ao carregar.");
			}
		});

});





$('#select-operacao').change(function () {
	if ($('#select-operacao').val() == '1') {
		$('#valor-entrada, #data-recibo, #numero-recibo').css({display: "flex"});
		$('#valor-transferencia, #valor-doacao, #nome-instituicao, #data-transferencia, #data-doacao, #telefone-instituicao, #cnpj-instituicao').css({display: "none"});
	} else if ($('#select-operacao').val() == '2') {
		$('#valor-transferencia, #nome-instituicao, #data-transferencia, #telefone-instituicao, #cnpj-instituicao').css({display: "flex"});
		$('#valor-entrada, #valor-doacao, #data-recibo, #data-doacao, #numero-recibo').css({display: "none"});
	} else if ($('#select-operacao').val() == '3') {
		$('#valor-doacao, #nome-instituicao, #data-doacao, #telefone-instituicao, #cnpj-instituicao').css({display: "flex"});
		$('#valor-entrada, #valor-transferencia, #data-recibo, #data-transferencia, #numero-recibo').css({display: "none"});
	}

});

$('#select-operacao').val(function () {
	if ($('#select-operacao').val() == '1') {
		$('#valor-entrada, #data-recibo, #numero-recibo').css({display: "flex"});
		$('#valor-transferencia, #valor-doacao, #nome-instituicao, #data-transferencia, #data-doacao, #telefone-instituicao, #cnpj-instituicao').css({display: "none"});
	} else if ($('#select-operacao').val() == '2') {
		$('#valor-transferencia, #nome-instituicao, #data-transferencia, #telefone-instituicao, #cnpj-instituicao').css({display: "flex"});
		$('#valor-entrada, #valor-doacao, #data-recibo, #data-doacao, #numero-recibo').css({display: "none"});
		document.getElementById('select-operacao').value = 2;
	} else if ($('#select-operacao').val() == '3') {
		$('#valor-doacao, #nome-instituicao, #data-doacao, #telefone-instituicao, #cnpj-instituicao').css({display: "flex"});
		$('#valor-entrada, #valor-transferencia, #data-recibo, #data-transferencia, #numero-recibo').css({display: "none"});
	}
});



$('.count').each(function () {
	$(this).prop('Counter', 0).animate({
		Counter: $(this).text()
	}, {
		duration: 3000,
		easing: 'swing',
		step: function (now) {
			$(this).text(Math.ceil(now));
		}
	});
});