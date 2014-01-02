<script src="common/js/include/notifications.js"></script>

<div class="panel panel-default">
	<div class="panel-heading">
		<span class="lead text-primary">
			<span class="fa fa-comments-o"></span>&nbsp;&nbsp;Chat di gruppo 
				<span id="check_loader" class="right info"><img src="common/media/img/loader.gif" /></span>
				<small class="help-block">Messaggistica in multicast</small>
			</span>
			<div class="text-right">
				<a data-toggle="collapse" href="#collapseOne" class="text-info">
					Informazioni sulla chat di gruppo&nbsp;&nbsp;<span class="fa fa-info"></span>
				</a>
			</div>
			<div class="panel panel-info">
				<div id="collapseOne" class="panel-collapse collapse">
					<div class="panel-body text-info text-right">
						<p>Comunica con tutti gli utenti degli altri NAS: scrivi un messaggio da diffondere nell'etere o per iniziare una chiacchierata pubblica.</p>
						<p>Per i pi&ugrave; esperti, si tratta di messaggi inviati via <acronym title="Transmission Control Protocol">TCP</acronym> in <acronym title="Multicast DNS">MDNS</acronym>, nella porta 64689.</p>
					</div>
				</div>
			</div>
		</span>
	</div>
	<div class="panel-body">
		<button class="btn btn-default" title="Aggiorna l'elenco dei messaggi" id="check_notify_btn">Aggiorna&nbsp;&nbsp;<span class="glyphicon glyphicon-repeat"></span></button>
		<form action="" method="get" onsubmit="return false" class="right">
			<div class="input-group ">
				<input class="form-control" id="system-search" style="height: 2.3em;" placeholder="Filtra messaggi per..." />
				<span class="input-group-btn">
					<button class="btn btn-default" onclick="filter($('#system-search'));"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<td style="width: 20px;"></td>
				<th>Nome</th>
				<th>Messaggio</th>
			</tr>
		</thead>
		<tbody id="dash_notifications">
			<tr><td colspan="3" align="center"><span class="info">Rilevo aggiornamenti...</span></td></tr>
		</tbody>
	</table>
</div>
<hr />
<div class="panel panel-default">
	<div class="panel-heading"><span class="lead text-primary"><span class="fa fa-comment-o"></span>&nbsp;&nbsp;Saluta gli altri</span></div>
	
	<form id="editor_frm" method="post" action="" onsubmit="return false;">
		<div class="panel-body">
			<fieldset id="send_notice_area">
				<div class="input-group">
					<input type="hidden" id="user_data" value="<?php print $user["name"]; ?>" />
					<input type="hidden" id="send_previous_notice" value="" />
					<input type="text" class="form-control" id="send_notice" style="height: 2.3em;" placeholder="Scrivi un messaggio" value="" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary" id="send_notice_btn">Invia&nbsp;&nbsp;<span class="glyphicon glyphicon-share-alt"></span></button>
					</span>
				</div>
			</fieldset>
		</div>
	</form>
</div>