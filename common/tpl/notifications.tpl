<script src="common/js/include/notifications.js"></script>

<div class="panel panel-default">
	<div class="panel-heading">
		<span class="lead text-primary">
			<span class="fa fa-comments-o"></span>&nbsp;&nbsp;Notifiche di gruppo <sup><a data-toggle="collapse" href="#notifications_info" class="text-muted"><span class="fa fa-info"></span></a></sup>
				<span id="check_loader" class="right info"><img src="common/media/img/loader.gif" /></span>
				<small class="help-block">Messaggistica in multicast</small>
			</span>
			
			<div id="notifications_info" class="panel-body panel-collapse collapse">
				<p>Comunica con tutti gli utenti degli altri NAS: scrivi un messaggio da diffondere nell'etere o per informare gli altri.</p>
				<p>Per i pi&ugrave; esperti, si tratta di messaggi inviati via <acronym title="Transmission Control Protocol">TCP</acronym> in <acronym title="Multicast DNS">MDNS</acronym>, nella porta 64689.</p>
			</div>
		</span>
	</div>
	<div class="panel-body">
		<?php
		$manual_refresh = ($GLOBALS["user_settings"]["Chat"]["refresh_interval"] < 6000) ? " disabled" : "";
		$manual_refresh_info = ($GLOBALS["user_settings"]["Chat"]["refresh_interval"] < 6000) ? '&nbsp;<small class="panel text-muted">Il tempo di refresh &egrave; troppo breve per poter avviare l\'aggiornamento manuale</small>' : "";
		?>
		<button class="btn btn-default<?php print $manual_refresh; ?>" title="Aggiorna l'elenco dei messaggi" id="check_notify_btn">Aggiorna&nbsp;&nbsp;<span class="glyphicon glyphicon-repeat"></span></button><?php print $manual_refresh_info; ?>
		<form action="" method="get" onsubmit="return false" class="right">
			<div class="input-group ">
				<input class="form-control" id="system-search" style="height: 2.3em;" placeholder="Filtra messaggi per..." />
				<span class="input-group-btn">
					<button class="btn btn-default" onclick="filter($('#system-search'));"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
	</div>
	<table class="table">
		<thead>
			<tr>
				<td style="width: 20px;"></td>
				<th style="width: 30px;">#</th>
				<th>Nome</th>
				<th>Messaggio</th>
			</tr>
		</thead>
		<tbody id="dash_notifications">
			<tr><td colspan="4" align="center"><span class="info">Rilevo aggiornamenti...</span></td></tr>
		</tbody>
	</table>
</div>
<hr />
<div class="panel panel-default">
	<div class="panel-heading"><span class="lead text-primary"><span class="fa fa-comment-o"></span>&nbsp;&nbsp;Saluta gli altri</span></div>
	
	<form id="editor_frm" method="post" action="" onsubmit="return false;">
		<div class="panel-body">
			<fieldset id="send_notice_area">
				<?php
				if($GLOBALS["user_settings"]["Chat"]["show_ip"] == "false") {
					?>
					<div class="alert alert-warning"><span class="fa fa-info"></span>&nbsp;&nbsp;Come da impostazioni, l'indirizzo IP dei tuoi messaggi sar&agrave; celato a schermo (ma non su mdns!)</div> 
					<?php
				} else {
					?>
					<span class="info">&Egrave; possibile celare a schermo il proprio indirizzo ip antecedendo <code>noip:</code> al testo.</span> 
					<?php
				}
				?>
				<p>
				&Egrave; possibile inserire gli <a href="#smileys" class="text-primary smiley_btn" data-toggle="collapse">smileys</a>
				</p>
				<input type="hidden" id="user_data" value="<?php print $user["name"]; ?>" />
				<input type="hidden" id="user_name" value="<?php print $user["email"]; ?>" />
				<input type="hidden" id="send_previous_notice" value="" />
				<div class="input-group">
					<input type="text" class="form-control" id="send_notice" style="height: 2.3em;" placeholder="Scrivi un messaggio" autofocus value="" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary" id="send_notice_btn">Invia&nbsp;&nbsp;<span class="glyphicon glyphicon-share-alt"></span></button>
					</span>
				</div>
			</fieldset>
		</div>
	</form>
</div>