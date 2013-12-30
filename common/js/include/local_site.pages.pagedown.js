$(document).ready(function() {
	$("textarea#script").pagedownBootstrap({
		"sanatize": false,
		"help": false,
		"hooks": [{
			"event": "preConversion",
			"callback": function (text) {
				return text.replace(/\b(a\w*)/gi, "*$1*");
			}
		}, {
			"event": "plainLinkText",
			"callback": function (url) {
				return "This is a link to " + url.replace(/^https?:\/\//, "");
			}
		}]
	});
	$(".preview_btn").toggle(function() {
		$(".wmd-button-bar").fadeOut(300);
		$(".wmd-input").fadeOut(300, function() {
			$(".wmd-preview").fadeIn(300);
		});
		$(".preview_btn").html('Modifica&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span>');
		//$("html, body").animate({ scrollTop: ($("h1").eq(1).offset().top) }, 300);
	}, function() {
		$(".wmd-preview").fadeOut(300, function() {
			$(".wmd-button-bar").fadeIn(300);
			$(".wmd-input").fadeIn(300);
		});
		$(".preview_btn").html('Anteprima&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open"></span>');
		$("html, body").animate({ scrollTop: ($("h1").eq(1).offset().top) }, 300);
	});
	
	window.onbeforeunload = function(){ return 'onbeforeunload' };
});